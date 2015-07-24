<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
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
 * @property string $Slug
 * 
 * Relazioni
 * @property \app\modules\user\models\User $creator
 * @property \app\modules\user\models\User $updater
 * @property Project $project
 */
class Hashtag extends ActiveRecord {

    public function behaviors() {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'Name',
                'slugAttribute' => 'Slug',
            ],
        ];
    }

    public function rules() {
        return [
            ['Name', 'required', 'message' => 'Inserisci l\'argomento'],
        ];
    }

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
            $this->Name = strtolower($this->Name);
            return true;
        endif;
        return false;
    }

    /* Metodi */

    public function saveModel($attributes, $projectid) {
        $this->setAttributes($attributes);
        $this->ProjectID = $projectid;
        try {
            return $this->save();
        } catch (yii\db\Exception $e) {
            $error = null;
            switch ($e->errorInfo[1]) :
                case 1062: # ER_DUP_ENTRY
                    if (strpos($e->errorInfo[2], 'unique_hashtags_name_project') !== false) :
                        $error = 'Argomento gi&agrave; creato per questo progetto.';
                    endif;
                    break;
            endswitch;
            # mostro il messaggio solo se è un errore riconosciuto oppure se sono in debug
            Yii::$app->session->setFlash('hashtag-danger', 'Impossibile creare l\'argomento.' .
                    ($error || YII_DEBUG ? ' Il server riporta:<p style="font-weight: bold;">' . ($error ? $error : $e->errorInfo[2]) . '</p>' : ''));
        }
    }

    /* Metodi statici */
}
