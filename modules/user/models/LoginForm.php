<?php

namespace app\modules\user\models;

use Yii;
use app\modules\user\models\User;
use yii\base\Model;

class LoginForm extends Model {

    public $UserName;
    public $Password;
    private $_user = false;

    public function attributeLabels() {
        return [
            'UserName' => 'Nome utente',
        ];
    }

    public function rules() {
        return [
            ['UserName', 'required', 'message' => 'Inserisci il nome utente o l\'indirizzo email'],
            ['Password', 'required', 'message' => 'Inserisci la password'],
            ['Password', 'validatePassword'],
        ];
    }

    /* Eventi */
    /* Metodi */

    /**
     * Esegue il login dell'utente attuale, ovvero quello assegnato alla proprietà {@link $_user}.
     * @return boolean Esito del login
     */
    public function login() {
        if ($this->validate()) :
            return Yii::$app->user->login($this->_getUser(), 3600 * 24);
        endif;
        return false;
    }

    /**
     * Valida la password inserita nella form rispetto all'utente attualemente selezionato tramite il nome utente
     * e assegnato alla proprietà {@link $_user}. Se l'utente non esiste o la password è errata assegna
     * l'errore al campo {@link $Password}.
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) :
            $user = $this->_getUser();
            if (!$user || !$user->validatePassword($this->Password))
                $this->addError($attribute, 'Nome utente o password non validi.');
        endif;
    }

    /**
     * Popola la proprietà {@link $_user} con l'oggetto User relativo all'utente che sta cercando di loggarsi,
     * cercato tramite il nome utente.
     * @return mixed Oggetto {@link User} o null se l'utente che sta cercando di loggarsi non esiste
     */
    private function _getUser() {
        if ($this->_user === false) :
            $this->_user = User::FindByUserName($this->UserName);
        endif;
        return $this->_user;
    }

    /* Metodi statici */
    /* Ajax */
}
