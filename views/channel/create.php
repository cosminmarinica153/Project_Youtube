<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Upload Video";

$this->beginContent('@app/views/layouts/channel.php');
$this->endContent();

echo "<br/><h1> Upload Video </h1><br/>";
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'video_name')->textInput() ?>
<?= $form->field($model, 'video_description')->textarea(['rows' => 5, 'maxlengt' => 200]) ?>
<?= $form->field($model, 'video_file')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('Upload Video', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

