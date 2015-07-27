<?php

namespace app\controllers;

use Yii;
use app\components\LogbookController;
use app\models\Entry;

class LogController extends LogbookController {

    public function behaviors() {
        return $this->accessRules([
                    ['allow' => true, 'roles' => ['@']],
        ]);
    }

    public function actionIndex() {
        $entry = new Entry;
        if (Yii::$app->getRequest()->isPost) :
            $result = $entry->saveModel(Yii::$app->getRequest()->post('Entry'));
            if ($result === true) :
                return $this->refresh();
            endif;
        endif;
        return $this->render('index', ['entry' => $entry]);
    }

}
