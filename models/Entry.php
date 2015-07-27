<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property string $Created
 * @property int $CreatedBy
 * @property string $Updated
 * @property int $UpdatedBy
 * @property int $ProjectID
 * @property string $EntryText
 * 
 * Relazioni
 * @property Project $Project
 */
class Entry extends ActiveRecord {

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

    public function getProject() {
        return $this->hasOne(Project::className(), ['ProjectID' => 'ProjectID']);
    }

    /* Eventi */

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) :
            if ($this->isNewRecord) :
                $this->Created = new Expression('NOW()');
                $this->CreatedBy = Yii::$app->user->id;
            else :
                $this->Updated = new Expression('NOW()');
                $this->UpdatedBy = Yii::$app->user->id;
            endif;
            return true;
        endif;
        return false;
    }

    /* Metodi */

    public function checkObjects($attribute, $params) {
        
    }

    public function saveModel(array $attributes) {
        $this->setAttributes($attributes);
        try {
            return $this->save();
        } catch (yii\db\Exception $e) {
            
        }
    }

    /* Metodi statici */
}
