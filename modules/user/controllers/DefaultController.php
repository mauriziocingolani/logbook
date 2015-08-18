<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\Login;
use app\modules\user\models\LoginForm;
use app\modules\user\models\PasswordForm;
use app\modules\user\models\Role;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use mauriziocingolani\yii2fmwkphp\Controller;

class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    ['allow' => true,
                        'roles' => ['@'],
                        'actions' => ['logout'],
                    ],
                    ['allow' => true,
                        'actions' => ['users', 'user'],
                        'matchCallback' => function() {
                    return Yii::$app->user->isDeveloper();
                },
                    ],
                    ['allow' => true,
                        'roles' => ['?'],
                        'actions' => ['login', 'password'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();
        $model = new LoginForm;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) :
            Login::RegisterLogin();
            return $this->goBack();
        else :
            if (Yii::$app->getRequest()->isPost)
                Login::RegisterLogin();
            return $this->render('login', [
                        'model' => $model,
            ]);
        endif;
    }

    public function actionPassword() {
        $model = new PasswordForm;
        if (Yii::$app->getRequest()->isPost) :
            $model->setAttributes(Yii::$app->getRequest()->post('PasswordForm'));
            if ($model->validate()) :
                Yii::$app->session->setFlash('success', 'La password &egrave; stata inviata al tuo indirizzo email.');
                return $this->refresh();
            endif;
        endif;
        return $this->render('password', ['model' => $model]);
    }

    public function actionLogout() {
        $id = Yii::$app->user->id;
        Yii::$app->user->logout();
        Login::RegisterLogout($id);
        $this->goHome();
    }

    public function actionUsers() {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('users', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUser($username = null) {
        if ($username && $username != 'nuovo') :
            $model = User::FindByUserName($username);
            if ($model == null) :
                throw new Exception(404, 'L\'utente non esiste.');
            endif;
            $name = $model->UserName;
        else :
            $model = new User;
            $name = 'Nuovo utente';
        endif;
        if (Yii::$app->getRequest()->isPost) :
            $new = $model->isNewRecord;
            $result = $model->saveModel(Yii::$app->getRequest()->post('User'));
            if ($result === true) :
                if ($new) :
                    Yii::$app->session->setFlash('success', 'Utente creato! Un messaggio con le credenziali di accesso &egrave; stato inviato all\'indirizzo ' . $model->getAttribute('Email') . '.');
                    return $this->redirect('/utenti/' . $model->UserName);
                else :
                    Yii::$app->session->setFlash('success', 'Utente aggiornato!');
                    return $this->refresh();
                endif;
            else :
                Yii::$app->session->setFlash('danger', 'Impossibile ' . ($new ? 'creare' : 'modificare') . ' l\'utente.');
            endif;
        endif;
        return $this->render('user', [
                    'model' => $model,
                    'name' => $name,
        ]);
    }

}
