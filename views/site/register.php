<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Register";

echo "<h1> Register </h1><br/>";
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'username')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password2')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

