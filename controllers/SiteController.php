<?php

namespace app\controllers;

use app\components\LogbookController;

class SiteController extends LogbookController {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionError() {
        
    }

    public function actionOffline() {
        return $this->render('offline');
    }

}
