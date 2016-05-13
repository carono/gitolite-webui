<?php

namespace app\models\query;

use yii\data\Sort;
use yii\data\ActiveDataProvider;
/**
 * This is the ActiveQuery class for [[\app\models\Gitolite]].
 *
 * @see \app\models\Gitolite
 */
class GitoliteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Gitolite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Gitolite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function search($filter = null)
    {
        $this->filter($filter);
        $sort = new Sort();
        return new ActiveDataProvider(
            [
                'query' => $this,
                'sort'  => $sort
            ]
        );
    }

    public function filter($model)
    {
		if ($model){
        }
        return $this;
    }
}
