<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 */
echo Html::tag('span', 'Fail init database, execute manually: php yii migrate', ["class" => "alert alert-error"]);
