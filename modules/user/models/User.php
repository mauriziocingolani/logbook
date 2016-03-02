<?php

namespace app\modules\user\models;

use Yii;
use yii\db\Expression;
use yii\web\IdentityInterface;
use mauriziocingolani\yii2fmwkphp\NamedActiveRecord;
use mauriziocingolani\yii2fmwkphp\PasswordHelper;
use app\modules\user\controllers\DefaultController;

/**
 * @property integer $UserID ID utente
 * @property string $Created Data e ora di creazione
 * @property integer $CreatedBy Utente che ha creato l'utente
 * @property string $Updated Data e ora di ultima modifica
 * @property integer $UpdatedBy Utente che ha modificato per ultimo l'utente
 * @property integer $RoleID Ruolo dell'utente
 * @property string $UserName Nome utente
 * @property string $Email Indirizzo email (valido come nome utente)
 * @property string $Password Password utente
 * @property string $BanDateTime Data e ora di disattivazione utente
 * @property string $BanReason Motivo disattivazione utente
 */
class User extends NamedActiveRecord implements IdentityInterface {

    public $Password1;
    public $Password2;

    public function attributeLabels() {
        return [
            'UserID' => '#',
            'RoleID' => 'Ruolo',
            'UserName' => 'Nome utente',
            'Email' => 'Email',
            'Password1' => 'Password',
            'Password2' => 'Conferma password',
        ];
    }

    public function rules() {
        return [
            ['RoleID', 'required'],
            ['UserName', 'required', 'message' => 'Inserisci il nome utente'],
            ['UserName', 'compare', 'compareValue' => 'nuovo', 'operator' => '!=', 'message' => 'Nome utente non consentito'],
            ['UserName', 'match', 'pattern' => '/^[a-z]{1}[a-z0-9_]+[a-z0-9]{1}$/i', 'message' => 'Nome utente non valido'],
            ['Email', 'required', 'message' => 'Inserisci l\'indirizzo email'],
            ['Email', 'email', 'message' => 'Indirizzo email non valido'],
            [['UserName', 'Email'], 'trim'],
            [['Password1', 'Password2'], 'default'],
            ['Password2', 'compare', 'compareAttribute' => 'Password1', 'operator' => '==', 'message' => 'Le due password non corrispondono'],
        ];
    }

    public static function tableName() {
        return 'users';
    }

    /* Implementazione interfaccia IdentityInterface */

    public function getAuthKey() {
        return $this->getAttribute('AuthKey');
    }

    public function getId() {
        return $this->getAttribute('UserID');
    }

    public function validateAuthKey($authKey) {
        throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /* Relazioni */

    public function getRole() {
        return $this->hasOne(Role::className(), ['RoleID' => 'RoleID']);
    }

    /* Eventi */

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) :
            $this->Created = new Expression('NOW()');
            $this->CreatedBy = Yii::$app->user->id;
            return true;
        endif;
        return false;
    }

    /* Metodi */

    public function getName() {
        if ($this->UserName)
            return $this->UserName;
        if ($this->Email)
            return $this->Email;
    }

    public function saveModel($attributes) {
        $this->setAttributes($attributes);
        if ($this->Password1) :
            $password = $this->Password1;
            $this->Password = PasswordHelper::EncryptToMysql($password);
        elseif ($this->isNewRecord) :
            $password = PasswordHelper::GeneratePassword();
            $this->Password = PasswordHelper::EncryptToMysql($password);
        endif;
        try {
            $new = $this->isNewRecord;
            $result = $this->save();
            if ($result && $new) :
                Yii::$app->mailer->compose('new-account', ['username' => $this->UserName, 'password' => $password])->
                        setFrom('webmaster@mauriziocingolani.it')->
                        setTo($this->getAttribute('Email'))->
                        setBcc('maurizio@mauriziocingolani.it')->
                        setSubject('LogBook - Account per accesso')->
                        send();
            endif;
            return $result;
        } catch (yii\db\Exception $e) {
            $error = null;
            switch ($e->errorInfo[1]) :
                case 1062: # ER_DUP_ENTRY
                    if (strpos($e->errorInfo[2], 'unique_username') !== false) :
                        $error = 'Nome utente gi&agrave; utilizzato.';
                    endif;
                    break;
            endswitch;
            # mostro il messaggio solo se è un errore riconosciuto oppure se sono in debug
            Yii::$app->session->setFlash('error', 'Impossibile ' . ($new ? 'creare' : 'modificare') . ' l\'utente.' .
                    ($error || YII_DEBUG ? ' Il server riporta:<p style="font-weight: bold;">' . ($error ? $error : $e->errorInfo[2]) . '</p>' : ''));
        }
    }

    /**
     * Verifica se la password indicata coincide con quella dell'oggetto.
     * @param string $password Password da verificare
     * @return boolean Esito della verifica password
     */
    public function validatePassword($password) {
        return PasswordHelper::DecryptFromMysql($this->getAttribute('Password')) === $password;
    }

    /* Metodi statici */

    /**
     * Ricerca un utente in base al nome utente o all'indirizzo email.
     * Se il nome utente esiste restituisce l'oggetto User corrispondente.
     * La variabile YII_LOCKED (definita nel file web/constants.php) inibisce
     * l'accesso agli utenti diversi da UserID=1.
     * @param string $username Nome utente o inrdirizzo email da cercare
     * @return \static Oggetto User oppure null
     */
    public static function FindByUserName($username) {
        $query = static::find();
        $where = ['UserName' => $username, 'BanDateTime' => null];
        if (YII_LOCKED)
            $where['UserID'] = 1;
        return $query->where($where)->
                        orWhere(['Email' => $username])->one();
    }

    /* Ajax */
}
