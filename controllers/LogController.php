<?php

namespace app\controllers;

use Yii;
use app\components\LogbookController;
use app\models\Entry;
use app\modules\user\models\User;

class LogController extends LogbookController {

    public function behaviors() {
        return $this->accessRules([
                    ['allow' => true, 'roles' => ['@']],
        ]);
    }

    public function actionIndex() {
        $entry = new Entry;
        if (Yii::$app->getRequest()->isPost) :
            if (Yii::$app->getRequest()->post('Entry')) :
                $result = $entry->saveModel(Yii::$app->getRequest()->post('Entry'));
                if ($result === true) :
                    return $this->refresh();
                endif;
            elseif (Yii::$app->getRequest()->post('DeleteEntry')) :
                $result = Entry::DeleteEntry(Yii::$app->getRequest()->post('DeleteEntry')['entryid']);
                if ($result === true) :
                    Yii::$app->session->setFlash('entrysuccess', 'Voce eliminata!');
                    return $this->refresh();
                endif;
            endif;
        endif;
        return $this->render('index', [
                    'entry' => $entry,
        ]);
    }

}
