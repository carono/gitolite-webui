<?php
use app\models\query\GitoliteQuery;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var GitoliteQuery $gitoliteQuery
 */
?>
    <a href="/gitolite/add" class="btn btn-primary">Add new</a>
<?php
echo GridView::widget(
    [
        'dataProvider' => $gitoliteQuery->search(),
        'emptyText'    => 'No gitolite admins find, ' . Html::a('add new', ['/gitolite/add']),
        'columns'      => [
            'name',
            'path',
            [
                'class'          => \carono\components\ActionColumn::className(),
                'checkUrlAccess' => false
            ]
        ]
    ]
);