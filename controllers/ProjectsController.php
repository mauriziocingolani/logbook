<?php

namespace app\controllers;

use Yii;
use yii\web\HttpException;
use app\components\LogbookController;
use app\models\Project;
use app\models\ProjectSearch;

class ProjectsController extends LogbookController {

    public function behaviors() {
        return $this->accessRules([
                    ['allow' => true, 'roles' => ['@']],
        ]);
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
        if ($slug) :
            $model = Project::FindBySlug($slug);
            if ($model == null) :
                throw new Exception(404, 'Il progetto non esiste.');
            endif;
        else :
            $model = new Project;
        endif;
        if (Yii::$app->getRequest()->isPost) :
            $model->setAttributes(Yii::$app->getRequest()->post('Project'));
            try {
                $new = $model->isNewRecord;
                if ($model->save()) :
                    Yii::$app->session->setFlash('success', 'Progetto ' . ($new ? 'creato' : 'modificato') . '!');
                    return $this->redirect('/progetti/' . $model->Slug);
                else :
                    Yii::$app->session->setFlash('error', 'Impossibile ' . ($new ? 'creare' : 'modificare') . ' il progetto.');
                endif;
            } catch (yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', 'Impossibile ' . ($new ? 'creare' : 'modificare') . ' il progetto.' . (YII_DEBUG ? ' Il server riporta:<p>' . $e->errorInfo[2] . '</p>' : ''));
            }
        endif;
        return $this->render('project', [
                    'model' => $model,
        ]);
    }

}
