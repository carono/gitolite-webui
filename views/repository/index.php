<?php
use app\models\Gitolite;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var Gitolite $gitolite
 */
$gitolite->searchRepositories();
//echo GridView::widget(
//    [
//        'dataProvider' => $gitolite->searchRepositories(),
//        'columns'      => [
//            'name',
//            'path',
//            [
//                'class'          => \carono\components\ActionColumn::className(),
//                'checkUrlAccess' => false
//            ]
//        ]
//    ]
//);