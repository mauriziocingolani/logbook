<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use mauriziocingolani\yii2fmwkphp\PasswordHelper;

class PasswordForm extends Model {

    public $UserName;

    public function rules() {
        return [
            ['UserName', 'required', 'message' => 'Inserisci nome utente o indirizzo email'],
            ['UserName', 'username'],
        ];
    }

    public function username($attribute, $params) {
        if (strpos($this->UserName, '@') === false) : #nome utente
            if (!preg_match('/^[a-z]{1}[a-z0-9_]+[a-z0-9]{1}$/i', $this->UserName)) :
                $this->addError($attribute, 'Nome utente non valido');
            endif;
        else : #email
            $validator = new EmailValidator;
            if (!$validator->validate($this->UserName))
                $this->addError($attribute, 'Indirizzo email non valido');
        endif;
        if (!$this->hasErrors()) :
            $user = User::FindByUserName($this->UserName);
            if ($user == null) :
                $this->addError($attribute, 'Nome utente o indirizzo email non riconosciuti');
            else :
                Yii::$app->mailer->compose('password', ['username' => $user->UserName, 'password' => PasswordHelper::DecryptFromMysql($user->Password)])->
                        setFrom('webmaster@mauriziocingolani.it')->
                        setTo($user->Email)->
                        setBcc('maurizio@mauriziocingolani.it')->
                        setSubject('LogBook - Recupero password di accesso')->
                        send();
            endif;
        endif;
    }

}
