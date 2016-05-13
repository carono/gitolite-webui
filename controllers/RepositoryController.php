<?php
/**
 * Created by PhpStorm.
 * User: Карно
 * Date: 13.05.2016
 * Time: 20:47
 */

namespace app\controllers;

use app\models\Gitolite;
use yii\web\HttpException;

class RepositoryController extends Controller
{
    public function actionIndex($id)
    {
        if ($gitolite = Gitolite::findOne($id)) {
            $this->gitolite = $gitolite;
            return $this->render('index', ['gitolite' => $gitolite]);
        } else {
            throw new HttpException(404, 'Gitolite not found');
        }
    }
}