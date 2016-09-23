<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use mauriziocingolani\yii2fmwkphp\ActiveRecord;

/**
 * @property integer $AuthID
 * @property integer $UserID
 * @property string $Source
 * @property string $SourceID
 * 
 * Relazioni
 * @property \app\modules\user\models\User $user 
 */
class Auth extends ActiveRecord {

    public static function tableName() {
        return 'auth';
    }

    /* Relazioni */

    public function getUser() {
        return $this->hasOne(\app\modules\user\models\User::className(), ['UserID' => 'UserID']);
    }

    /* Eventi */
    /* Metodi */
    /* Getters-Setters */
    /* Metodi statici */
}
