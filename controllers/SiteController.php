<?php

namespace app\controllers;

use yii\web\Controller;

//use app\components\LogbookController;

class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [['allow' => true]],
            ],
        ];
//        return $this->accessRules([
//                    ['allow' => true]
//        ]);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionError() {
        
    }

    public function actionOffline() {
        return $this->render('offline');
    }

    public function actionLicenza() {
        return $this->render('license/it');
    }

    public function actionLicense() {
        return $this->render('license/en');
    }

}
