<?php

namespace app\modules\user\models;

use Yii;
use yii\db\Expression;
use yii\web\IdentityInterface;
use mauriziocingolani\yii2fmwkphp\NamedActiveRecord;
use mauriziocingolani\yii2fmwkphp\PasswordHelper;

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
     * @param string $username Nome utente o inrdirizzo email da cercare
     * @return \static Oggetto User oppure null
     */
    public static function FindByUserName($username) {
        return static::find()->
                        where(['UserName' => $username])->
                        orWhere(['Email' => $username])->one();
    }

    /* Ajax */
}
