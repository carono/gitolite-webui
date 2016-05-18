<?php
use app\models\Gitolite;
use yii\grid\GridView;

/**
 * @var Gitolite $gitolite
 */

echo GridView::widget(
    [
        'dataProvider' => $gitolite->searchRepositories(),
        'columns'      => [
            'name',
            [
                'class'          => \carono\components\ActionColumn::className(),
                'checkUrlAccess' => false
            ]
        ]
    ]
);