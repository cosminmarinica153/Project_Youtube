<?php

use app\models\user\DB_User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Search";

echo "<h1> Search </h1><br/>";
?>
<style>
    .feed-grid{
        display: grid;
        grid-template-columns: auto auto auto;
        justify-items: center;
    }

    .feed-video-box{
        max-width: 250px;
        max-height: 500px;
        overflow: hidden;
    }
</style>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'video_name')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

echo "<div class = 'feed-grid'>";

if(isset($found))
{
    if($found == false)
        echo "<h2> Video not Found </h2";
    else
    {
    foreach($videos as $video)
    {
        $channel = DB_User::findOne($video->user_id);

        echo "<div class = 'feed-video-box'>";

        echo Html::a('
        <video width="250" height="250" poster">
            <source src="'.$video->video_path.'" type="video/mp4">
        </video>', ['site/watch', 'id' => $video->id]);
    
        echo '<h5>'.$video->video_name.'</h5>';
        echo '<p>'.$channel->username.'<br/>';
        echo $video->video_views.' views</p>';
        echo "</div>";
    }

    echo "</div>";
    }
}         