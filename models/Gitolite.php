<?php

namespace app\models;

use Yii;
use \app\models\base\Gitolite as BaseGitolite;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

/**
 * This is the model class for table "gitolite".
 *
 * @property string conf
 */
class Gitolite extends BaseGitolite
{
    public function getUrl($action, $asString = false)
    {
        $url = null;
        if ($action == "update") {
            $url = ['/gitolite/update', 'id' => $this->id];
        } elseif ($action == "view") {
            $url = ['/repository/index', 'id' => $this->id];
        }
        if ($asString) {
            return Url::to($url, true);
        } else {
            return $url;
        }
    }

    public function getConf()
    {
        return $this->path . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'gitolite.conf';
    }

    public function searchTeams()
    {
        $conf = $this->conf;
        $p = new \carono\gitolite\Gitolite();
        $p->import($conf);
        $dataProvider = new ArrayDataProvider();
        $dataProvider->models = $p->getTeams();
        return $dataProvider;
    }

    public function searchUsers()
    {
        $conf = $this->conf;
        $p = new \carono\gitolite\Gitolite();
        $p->import($conf);
        $dataProvider = new ArrayDataProvider();
        $dataProvider->models = $p->getUsers();
        return $dataProvider;
    }

    public function searchRepositories()
    {
        $conf = $this->conf;
        $p = new \carono\gitolite\Gitolite();
        $p->import($conf);
        $dataProvider = new ArrayDataProvider();
        $dataProvider->models = $p->getRepos();
        return $dataProvider;
    }

    public function beforeValidate()
    {
        $error = 'It is not a gitolite folder';
        if (is_file($this->path) && basename($this->path) != 'gitolite.conf') {
            $this->addError('path', $error);
        } elseif (is_dir($this->path) && !file_exists($this->path . DIRECTORY_SEPARATOR . 'gitolite.conf')
            && !file_exists($this->path . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'gitolite.conf')
        ) {
            $this->addError('path', $error);
        }
        return parent::beforeValidate();
    }
}
