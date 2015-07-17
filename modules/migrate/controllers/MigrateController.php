<?php

namespace app\modules\migrate\controllers;

use Yii;
use yii\base\InvalidParamException;
use mauriziocingolani\yii2fmwkphp\Controller;

class MigrateController extends Controller {

    public function init() {
        parent::init();
        defined('STDIN') or define('STDIN', fopen('php://input', 'r'));
        defined('STDOUT') or define('STDOUT', fopen('php://output', 'w'));
    }

    public function actionCreate($migrationName) {
        if ($migrationName == null)
            throw new InvalidParamException('Nome della migrazione mancante.');
        //migration command begin
        $migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
        $migration->runAction('create', [$migrationName, 'migrationPath' => '@app/migrations/', 'interactive' => false]);
        //migration command end
    }

    public function actionMigrate($action = 'up') {
        //migration command begin
        $migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
        $migration->runAction($action, ['migrationTable' => 'YiiMigrations', 'migrationPath' => '@app/migrations/', 'interactive' => false]);
        //migration command end
    }

}
