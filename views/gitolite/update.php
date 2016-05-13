<?php
use app\models\Gitolite;
use carono\components\ActiveForm;
use yii\helpers\Html;

/**
 * @var Gitolite $gitolite
 */
$form = ActiveForm::begin();
echo $form->field($gitolite, 'name')->textInput(["maxLength" => true]);
echo Html::submitButton('Сохранить', ["class" => "btn btn-success pull-right"]);
$form->end();
