<?php
use app\models\Gitolite;
use yii\grid\GridView;

/**
 * @var Gitolite $gitolite
 */
echo GridView::widget(
    [
        'dataProvider' => $gitolite->searchUsers(),
        'columns'      => [
            [
                'attribute' => 'team',
                'value'     => function ($model) {
                    return join(', ', array_keys($model->teams));
                }
            ],
            'name',
            [
                'class'          => \carono\components\ActionColumn::className(),
                'checkUrlAccess' => false
            ]
        ]
    ]
);