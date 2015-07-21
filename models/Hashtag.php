<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $HashtagID
 * @property string $Created
 * @property int $CreatedBy
 * @property string $Updated
 * @property int $UpdatedBy
 * @property int $ProjectID
 * @property string $Name
 * 
 * Relazioni
 * @property \app\modules\user\models\User $creator
 * @property \app\modules\user\models\User $updater
 * @property Project $project
 */
class Hashtag extends ActiveRecord {

    public static function tableName() {
        return 'hashtags';
    }

    /* Relazioni */

    public function getCreator() {
        return $this->hasOne(\app\modules\user\models\User::className(), ['UserID' => 'CreatedBy']);
    }

    public function getUpdater() {
        return $this->hasOne(\app\modules\user\models\User::className(), ['UserID' => 'UpdatedBy']);
    }

    public function getProject() {
        return $this->hasOne(Project::className(), ['ProjectID'=>'ProjectID']);
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
            $this->Name = strtolower($this->Name);
            return true;
        endif;
        return false;
    }

    /* Metodi */
    /* Metodi statici */
}
