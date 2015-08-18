<?php

namespace app\controllers;

use Yii;
use app\components\LogbookController;
use app\models\Entry;
use app\modules\user\models\User;

class LogController extends LogbookController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [['allow' => true]],
            ],
        ];
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

    public function actionUsers() {
        $users = User::find()->where('BanDateTime IS NULL')->orderBy(['UserName' => SORT_ASC])->all();
        $data = array();
        foreach ($users as $us) :
            $data[] = $us->UserName;
        endforeach;
        echo json_encode($data);
    }
}
