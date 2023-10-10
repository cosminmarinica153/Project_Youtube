<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Update Titles";

$this->beginContent('@app/views/layouts/channel.php');
$this->endContent();

echo "<h1> Update Video </h1><br/>";
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'video_name')->textInput(['value' => $video->video_name]) ?>
<?= $form->field($model, 'video_description')->textarea(['value' => $video->video_description, 'rows' => 5, 'maxlengt' => 200]) ?>

<div class="form-group">
    <?= Html::submitButton('Update Video', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>