<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
 * @property \app\modules\user\models\User $Creator
 * @property \app\modules\user\models\User $Updater
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
        ];
    }

    public static function tableName() {
        return 'projects';
    }

    /* Relazioni */
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

    /**
     * @return Project
     */
    public static function FindBySlug($slug) {
        return self::find()->where('Slug=:slug', ['slug' => $slug])->one();
    }

}
