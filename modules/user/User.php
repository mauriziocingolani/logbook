<?php

namespace app\modules\user;

use yii\base\Module;

class User extends Module {

    public $canRegister = false;
    public $canLoginWithSocial = false;

}
