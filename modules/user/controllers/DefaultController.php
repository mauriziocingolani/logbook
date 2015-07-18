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

}
