<?php

namespace app\components;

use Yii;
use yii\web\User;

/**
 * Questa classe va impostata come classe per il componente e deve definire
 * i metodi che permettono di stabilire il ruolo di un utente.
 */
class AppUser extends User {

    public function isDeveloper() {
        return !Yii::$app->user->isGuest && Yii::$app->user->identity->RoleID == 1;
    }

}
