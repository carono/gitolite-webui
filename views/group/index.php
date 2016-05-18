<?php
use app\models\Gitolite;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * @var Gitolite $gitolite
 */
//$gitolite->searchTeams();

echo GridView::widget(
    [
        'dataProvider' => $gitolite->searchTeams(),
        'columns'      => [
            'name',
            [
                'attribute' => 'items',
                'value'     => function ($model) {
                    return join(', ', ArrayHelper::map($model->items, 'name', 'name'));
                }
            ],
            'type',
            [
                'class'          => \carono\components\ActionColumn::className(),
                'checkUrlAccess' => false
            ]
        ]
    ]
);