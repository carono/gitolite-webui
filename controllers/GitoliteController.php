<?php


namespace app\controllers;


use app\models\Gitolite;
use yii\web\HttpException;

class GitoliteController extends Controller
{
    public $gitolite;

    public function actionIndex()
    {
        $gitoliteQuery = Gitolite::find();
        return $this->render('index', ['gitoliteQuery' => $gitoliteQuery]);
    }

    public function actionAdd()
    {
        $gitolite = new Gitolite();
        if ($gitolite->load($_POST) && $gitolite->save()) {
            $this->redirect($gitolite->getUrl('update'));
        }
        return $this->render('add', ['gitolite' => $gitolite]);
    }

    public function actionView($id)
    {
        if ($gitolite = Gitolite::findOne($id)) {
            $this->gitolite = $gitolite;
            return $this->render('view', ['gitolite' => $gitolite]);
        } else {
            throw new HttpException(404, 'Gitolite not found');
        }
    }

    public function actionUpdate($id)
    {
        if ($gitolite = Gitolite::findOne($id)) {
            $this->gitolite = $gitolite;
            if ($gitolite->load($_POST) && $gitolite->save()) {
                $this->redirect($gitolite->getUrl('view'));
            }
            return $this->render('update', ['gitolite' => $gitolite]);
        } else {
            throw new HttpException(404, 'Gitolite not found');
        }
    }

    public function actionDelete($id)
    {
        if ($gitolite = Gitolite::findOne($id)) {
            $gitolite->delete();
            $this->redirect(['/gitolite/index']);
        } else {
            throw new HttpException(404, 'Gitolite not found');
        }
    }
}