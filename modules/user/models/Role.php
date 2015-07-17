<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * @property integer $RoleID Chiave primaria
 * @property string $Description Descrizione del ruolo
 */
class Role extends ActiveRecord {

    const ROLE_DEVELOPER = 1;
    const ROLE_GUEST = 2;

    public function attributeLabels() {
        return [
            'RoleID' => 'ID',
            'Description' => 'Descrizione',
        ];
    }

    public static function tableName() {
        return 'roles';
    }

}
