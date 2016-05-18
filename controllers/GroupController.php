<?php
/**
 * Created by PhpStorm.
 * User: Карно
 * Date: 15.05.2016
 * Time: 16:37
 */

namespace app\controllers;


use app\models\Gitolite;
use yii\web\HttpException;

class GroupController extends Controller
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