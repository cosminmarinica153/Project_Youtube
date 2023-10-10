<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Login";

echo "<h1> Login </h1><br/>";
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>