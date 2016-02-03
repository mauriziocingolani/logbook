<?php

namespace app\components;

use Yii;
use mauriziocingolani\yii2fmwkphp\AppWebUser;

/**
 * Questa classe va impostata come classe per il componente e deve definire
 * i metodi che permettono di stabilire il ruolo di un utente.
 */
class AppUser extends AppWebUser {

    const ROLE_GUEST = 2;
    const ROLE_EDITOR = 3;

    public function isEditor($includeDeveloper = true) {
        return $this->isRole(self::ROLE_EDITOR, $includeDeveloper);
    }

    public function isGuest($includeDeveloper = true) {
        return $this->isRole(self::ROLE_GUEST, $includeDeveloper);
    }

}
