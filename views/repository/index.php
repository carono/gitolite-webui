<?php
use app\models\Gitolite;
use yii\grid\GridView;
use carono\gitolite\Repo;

/**
 * @var Gitolite $gitolite
 */

echo GridView::widget(
    [
        'dataProvider' => $gitolite->searchRepositories(),
        'columns'      => [
            ['class' => \yii\grid\SerialColumn::className()],
            'name',
            [
                'attribute' => 'group',
                'value'     => function (Repo $model) {
                    return join(', ', array_keys($model->teams));
                }
            ],
            [
                'class'          => \carono\components\ActionColumn::className(),
                'checkUrlAccess' => false
            ]
        ]
    ]
);