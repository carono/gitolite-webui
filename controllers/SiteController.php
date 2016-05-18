<?php

namespace app\controllers;

use Yii;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMigrate()
    {
        defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
        defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
        $controller = new \yii\console\controllers\MigrateController(null, null);
        $controller->db = Yii::$app->db;
        $controller->migrationPath = Yii::getAlias('@app/migrations');
        $controller->interactive = false;
        $controller->actionUp();
        try {
            \app\models\Migration::find()->count();
            $this->redirect(['/gitolite/index']);
        } catch (\Exception $e) {
            
        }
        return $this->render('migrate');
    }
}
