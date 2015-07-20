<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\LoginForm;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\models\Login;
use app\modules\user\models\Role;
use mauriziocingolani\yii2fmwkphp\Controller;
use mauriziocingolani\yii2fmwkphp\PasswordHelper;

class DefaultController extends Controller {

    public function behaviors() {
        return $this->accessRules([
                    [ 'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['logout'],
                    ],
                    [ 'allow' => true,
                        'actions' => [ 'users', 'user'],
                        'matchCallback' => function() {
                    return Yii::$app->user->isDeveloper();
                },
                    ],
                    ['allow' => true,
                        'roles' => ['?'],
                        'actions' => ['login'],
                    ],
        ]);
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
        else :
            $model = new User;
        endif;
        if (Yii::$app->getRequest()->isPost) :
            $model->setAttributes(Yii::$app->getRequest()->post('User'));
            if ($model->Password1) :
                $password = $model->Password1;
                $model->Password = PasswordHelper::EncryptToMysql($password);
            elseif ($model->isNewRecord) :
                $password = PasswordHelper::GeneratePassword();
                $model->Password = PasswordHelper::EncryptToMysql($password);
            endif;
            try {
                $new = $model->isNewRecord;
                if ($model->save()) :
                    if ($new) :
                        Yii::$app->mailer->compose('new-account', ['username' => $model->UserName, 'password' => $password])->
                                setFrom('webmaster@mauriziocingolani.it')->
                                setTo($model->getAttribute('Email'))->
                                setBcc('maurizio@mauriziocingolani.it')->
                                setSubject('LogBook - Account per accesso')->
                                send();
                        Yii::$app->session->setFlash('success', 'Utente creato! Un messaggio con le credenziali di accesso &egrave; stato inviato all\'indirizzo ' . $model->getAttribute('Email') . '.');
                        return $this->redirect('/utenti/' . $model->UserName);
                    else :
                        Yii::$app->session->setFlash('success', 'Utente modificato!');
                    endif;
                else :
                    Yii::$app->session->setFlash('error', 'Impossibile creare l\'utente.');
                endif;
            } catch (yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', 'Impossibile creare l\'utente.' . (YII_DEBUG ? ' Il server riporta:<p>' . $e->errorInfo[2] . '</p>' : ''));
            }
        endif;
        return $this->render('user', ['model' => $model]);
    }

}
