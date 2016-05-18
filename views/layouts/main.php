<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
$gitolite = ArrayHelper::getValue($this->context, 'gitolite');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]
    );
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items'   => [
                [
                    'label' => 'Gitolite' . ($gitolite ? " ({$gitolite->name})" : ''),
                    'url'   => ['/gitolite/index']
                ],
            ],
        ]
    );
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        <?php if ($this->context->gitolite) { ?>
            <div class="col-lg-2">
                <?php
                $id = $this->context->gitolite->id;
                echo Nav::widget(
                    [
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        'items'   => [
                            ['label' => 'Repositories', 'url' => ['/repository/index', 'id' => $id]],
                            ['label' => 'Users', 'url' => ['/user/index', 'id' => $id]],
                            ['label' => 'Groups', 'url' => ['/group/index', 'id' => $id]],
                        ],
                    ]
                );
                ?>
            </div>
        <?php } ?>
        <div class="col-lg-10">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Open source <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
