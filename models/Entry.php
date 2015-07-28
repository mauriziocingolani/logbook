<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;
use app\modules\user\models\User;

/**
 * @property int $EntryID
 * @property string $Created
 * @property int $CreatedBy
 * @property int $ProjectID
 * @property string $EntryText
 * 
 * Relazioni
 * @property User $creator
 * @property Project $project
 * @property User[] $users
 * @property Hashtag[] $hashtags
 * 
 * Getters
 * @property string $text
 * 
 * Privati 
 * @property User[] $_users
 * @property Hashtag[] $_hashtags
 */
class Entry extends ActiveRecord {

    private $_splittedText;
    private $_users;
    private $_hashtags;

    public function attributeLabels() {
        return [
            'ProjectID' => 'Progetto',
            'EntryText' => 'Testo',
        ];
    }

    public function rules() {
        return [
            ['EntryText', 'required', 'message' => 'Inserisci il testo della voce'],
            ['EntryText', 'checkObjects'],
            ['ProjectID', 'safe'],
        ];
    }

    public static function tableName() {
        return 'entries';
    }

    /* Relazioni */

    public function getCreator() {
        return $this->hasOne(User::className(), ['UserID' => 'CreatedBy']);
    }

    public function getHashtags() {
        return $this->hasMany(User::className(), ['UserID' => 'UserID'])->
                        viaTable('entries_hashtags', ['HashtagID' => 'HashtagID']);
    }

    public function getProject() {
        return $this->hasOne(Project::className(), ['ProjectID' => 'ProjectID']);
    }

    public function getUsers() {
        return $this->hasMany(User::className(), ['UserID' => 'UserID'])->
                        viaTable('entries_users', ['EntryID' => 'EntryID']);
    }

    /* Eventi */

    public function afterFind() {
        parent::afterFind();
        $this->_findObjects();
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) :
            $this->Created = new Expression('NOW()');
            $this->CreatedBy = Yii::$app->user->id;
            return true;
        endif;
        return false;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->db->transaction(function() {
            foreach ($this->_users as $user) :
                Yii::$app->db->createCommand()->insert('entries_users', [
                    'EntryID' => $this->EntryID,
                    'UserID' => $user->UserID,
                ])->execute();
            endforeach;
            foreach ($this->_hashtags as $hashtag) :
                Yii::$app->db->createCommand()->insert('entries_hashtags', [
                    'EntryID' => $this->EntryID,
                    'HashtagID' => $hashtag->HashtagID,
                ])->execute();
            endforeach;
        });

//        $this->createEntryUsers();
    }

    /* Metodi */

    public function checkObjects($attribute, $params) {
        if ($this->hasErrors())
            return;
        $this->_findObjects($attribute);
    }

    /**
     * Rimpiazza i riferimenti a utenti e hashtag con tag <span class="lb-obj">,
     * in modo da evidenziarli nel testo della entry.
     */
    public function getText() {
        $text = $this->EntryText;
        foreach ($this->_users as $user) :
            $text = preg_replace('/@' . $user->UserName . '/', '<span class="lb-obj"><i class="fa fa-at"></i>' . $user->UserName . '</span>', $text);
        endforeach;
        foreach ($this->_hashtags as $hashtag) :
            $text = preg_replace('/#' . $hashtag->Slug . '/', '<span class="lb-obj"><i class="fa fa-slack"></i>' . $hashtag->Slug . '</span>', $text);
        endforeach;
        return $text;
    }

//    public function createEntryUsers() {
//        
//    }

    public function saveModel(array $attributes) {
        $this->setAttributes($attributes);
        try {
            return $this->save();
        } catch (yii\db\Exception $e) {
            
        }
    }

    /**
     * Ricerca nel testo dell'entry gli eventuali riferimenti a utenti e hashtag e verifica che esistano.
     * Il testo viene splittato per caratteri di separazione (spazio, virgola, due punti, punto e virgola,
     * punto esclamativo e di domanda), quindi ogni elemento viene analizzato (se inizia per @ o #)
     * e il corrispondente oggetto ricercato nel database.
     * Gli oggetti trovati vengono inseriti nelle proprietà {@link $_users} e {@link $_hashtags}. Se il parametro
     * {@link $attribute} è assegnato, allora in caso di oggetti mancanti viene 
     * @param string $attribute Attributo (per validazione durante la creazione)
     */
    private function _findObjects($attribute = null) {
        $this->_splittedText = preg_split('/[ ,:;?!]/', $this->EntryText);
        $this->_users = [];
        $this->_hashtags = [];
        foreach ($this->_splittedText as $element) :
            if (strlen($element) > 0) :
                if ($element[0] === '@') :
                    $user = User::FindByUserName(substr($element, 1));
                    if ($user) :
                        $this->_users[] = $user;
                    else :
                        if ($attribute) :
                            $this->addError($attribute, 'Utente non riconosciuto: ' . $element);
                            break;
                        endif;
                    endif;
                elseif ($element[0] === '#') :
                    $hashtag = Hashtag::FindBySlug(substr($element, 1), $this->ProjectID);
                    if ($hashtag) :
                        $this->_hashtags[] = $hashtag;
                    else :
                        if ($attribute) :
                            $this->addError($attribute, 'Argomento non riconosciuto: ' . $element);
                            break;
                        endif;
                    endif;
                endif;
            endif;
        endforeach;
    }

    /* Metodi statici */

    /**
     * @return Entry[]
     */
    public static function GetAll($limit = null) {
        $query = self::find();
        $query->orderBy(['Created' => SORT_DESC]);
        if ($limit)
            $query->limit($limit);
        return $query->all();
    }

}
