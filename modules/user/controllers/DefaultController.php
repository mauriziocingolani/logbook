<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\LoginForm;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\models\Login;
use app\modules\user\models\Role;
use mauriziocingolani\yii2fmwkphp\Controller;

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
        $model = new User;
        if (Yii::$app->getRequest()->isPost) :
//            $model->setAttributes(Yii::$app->getRequest()->post('User'));
//            $model->RoleID = Role::ROLE_GUEST;
//            $password = substr(sha1(time()), 0, 10);
//            $model->Password = base64_encode(Yii::$app->getSecurity()->encryptByKey($password, Yii::$app->params['encryption_key']));
//            try {
//                if ($model->save()) :
//                    Yii::$app->mailer->compose('new-account', ['username' => $model->UserName, 'password' => $password])->
//                            setFrom('webadmin@mastersida.info')->
//                            setTo($model->getAttribute('Email'))->
//                            setBcc('m.cingolani@ggfgroup.it')->
//                            setSubject('Master SIDA - Account per accesso Gestionale Almalaurea')->
//                            send();
//                    Yii::$app->session->setFlash('success', 'Utente creato! Un messaggio con le credenziali di accesso &egrave; stato inviato all\'indirizzo ' . $model->getAttribute('Email') . '.');
//                else :
//                    Yii::$app->session->setFlash('error', 'Impossibile creare l\'utente.');
//                endif;
//            } catch (yii\db\Exception $e) {
//                Yii::$app->session->setFlash('error', 'Impossibile creare l\'utente.' . (YII_DEBUG ? ' Il server riporta:<p>' . $e->errorInfo[2] . '</p>' : ''));
//            }
        endif;
        return $this->render('user', ['model' => $model]);
    }

}
