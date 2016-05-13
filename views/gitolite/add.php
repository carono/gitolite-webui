<?php
use app\models\Gitolite;
use carono\components\ActiveForm;
use yii\helpers\Html;

/**
 * @var Gitolite $gitolite
 */
$form = ActiveForm::begin();
?>
    <h2>Choose gitolite folder or .conf file</h2>
  
<?php
echo $form->field($gitolite, 'name')->textInput(["maxLength" => true]);
echo $form->field($gitolite, 'path')->typeahead('/typeahead/path');
echo Html::submitButton('Сохранить', ["class" => "btn btn-success pull-right"]);
$form->end();
