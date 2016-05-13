<?php
/**
 * Created by PhpStorm.
 * User: Карно
 * Date: 13.05.2016
 * Time: 20:49
 */

namespace app\controllers;


use app\models\Gitolite;
use yii\web\HttpException;

class UserController extends Controller
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

    public function actionGroup($id)
    {
        if ($gitolite = Gitolite::findOne($id)) {
            $this->gitolite = $gitolite;
            return $this->render('group', ['gitolite' => $gitolite]);
        } else {
            throw new HttpException(404, 'Gitolite not found');
        }
    }
}