<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\controllers\ProjectsController;

/**
 * @property int $ProjectID
 * @property string $Created
 * @property int $CreatedBy
 * @property string $Updated
 * @property int $UpdatedBy
 * @property string $Name
 * @property string $Slug
 * 
 * Relazioni
 * @property \app\modules\user\models\User $creator
 * @property \app\modules\user\models\User $updater
 * @property Hashtag[] $hashtags
 */
class Project extends ActiveRecord {

    public function attributeLabels() {
        return [
            'ProjectID' => '#',
            'Name' => 'Nome progetto',
        ];
    }

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
            ['Name', 'required', 'message' => 'Devi inserire il nome del progetto'],
            ['Name', 'string', 'max' => 25, 'tooLong' => 'Il nome del progetto deve contenere al massimo 30 caratteri'],
        ];
    }

    public static function tableName() {
        return 'projects';
    }

    /* Relazioni */

    public function getCreator() {
        return $this->hasOne(\app\modules\user\models\User::className(), ['UserID' => 'CreatedBy']);
    }

    public function getUpdater() {
        return $this->hasOne(\app\modules\user\models\User::className(), ['UserID' => 'UpdatedBy']);
    }

    public function getHashtags() {
        return $this->hasMany(Hashtag::className(), ['ProjectID' => 'ProjectID'])->orderBy(['Name' => SORT_ASC]);
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

    public function saveModel($attributes) {
        $this->setAttributes($attributes);
        try {
            $new = $this->isNewRecord;
            return $this->save();
        } catch (yii\db\Exception $e) {
            $error = null;
            switch ($e->errorInfo[1]) :
                case 1062: # ER_DUP_ENTRY
                    if (strpos($e->errorInfo[2], 'unique_projects_name') !== false) :
                        $error = 'Nome progetto gi&agrave; utilizzato.';
                    elseif (strpos($e->errorInfo[2], 'unique_projects_slug') !== false) :
                        $error = 'Questo nome progetto porta a un nome breve (' . $this->Slug . ') gi&agrave; esistente.';
                    endif;
                    break;
            endswitch;
            # mostro il messaggio solo se è un errore riconosciuto oppure se sono in debug
            Yii::$app->session->setFlash('danger', 'Impossibile ' . ($new ? 'creare' : 'modificare') . ' il progetto.' .
                    ($error || YII_DEBUG ? ' Il server riporta:<p style="font-weight: bold;">' . ($error ? $error : $e->errorInfo[2]) . '</p>' : ''));
        }
    }

    /* Metodi statici */

    public static function GetAll() {
        return self::find()->orderBy(['Name' => SORT_ASC])->all();
    }

    /**
     * @return Project
     */
    public static function FindBySlug($slug) {
        return self::find()->with(['creator', 'updater', 'hashtags'])->where('Slug=:slug', ['slug' => $slug])->one();
    }

}
