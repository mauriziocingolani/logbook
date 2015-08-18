<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use app\components\LogbookController;
use app\models\Hashtag;
use app\models\Project;
use app\models\ProjectSearch;

class ProjectsController extends LogbookController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    ['allow' => true,
                        'actions' => ['hashtags'],
                    ],
                    ['allow' => true,
                        'matchCallback' => function($rule, $action) {
                            return Yii::$app->user->isDeveloper();
                        },
                    ],
                    ['allow' => false],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new ProjectSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProject($slug = null) {
        $hashtag = null;
        if ($slug) :
            $model = Project::FindBySlug($slug);
            if ($model == null) :
                throw new Exception(404, 'Il progetto non esiste.');
            endif;
            $name = $model->Slug;
            $hashtag = new Hashtag;
        else :
            $model = new Project;
            $name = 'Nuovo progetto';
        endif;
        if (Yii::$app->getRequest()->isPost) :
            if (Yii::$app->getRequest()->post('Project')) :
                $new = $model->isNewRecord;
                $result = $model->saveModel(Yii::$app->getRequest()->post('Project'));
                if ($result === true) :
                    Yii::$app->session->setFlash('success', 'Progetto ' . ($new ? 'creato' : 'aggiornato') . '!');
                    return $this->redirect(['/progetti/' . $model->Slug]);
                elseif ($result === false) :
                    Yii::$app->session->setFlash('danger', 'Impossibile ' . ($new ? 'creare' : 'modificare') . ' il progetto.');
                endif;
            elseif (Yii::$app->getRequest()->post('Hashtag')) :
                $result = $hashtag->saveModel(Yii::$app->getRequest()->post('Hashtag'), $model->ProjectID);
                if ($result === true) :
                    Yii::$app->session->setFlash('hashtagsuccess', 'Argomento aggiunto!');
                    return $this->refresh();
                elseif ($result === false) :
                    Yii::$app->session->setFlash('hashtagdanger', 'Impossibile aggiungere l\'argomento.');
                endif;
            elseif (Yii::$app->getRequest()->post('DeleteHashtag')) :
                $result = Hashtag::DeleteHashTag(Yii::$app->getRequest()->post('DeleteHashtag')['hashtagid']);
                if ($result === true) :
                    Yii::$app->session->setFlash('hashtagsuccess', 'Argomento eliminato!');
                    return $this->refresh();
                endif;
            endif;
        endif;
        return $this->render('project', [
                    'model' => $model,
                    'name' => $name,
                    'hashtag' => $hashtag,
        ]);
    }

    /* ===  Ajax === */

    public function actionHashtags() {
        echo json_encode(ArrayHelper::getColumn(Hashtag::find()->
                                where('ProjectID=:projectid', [':projectid' => Yii::$app->getRequest()->get('ProjectID')])->
                                orderBy(['Slug' => SORT_ASC])->all(), 'Slug'));
    }

}
