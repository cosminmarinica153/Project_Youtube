<?php 

use app\models\user\DB_User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $video->video_name;
?>

<style>
    .watch-flex{
        display: flex;
        width: 1100px;
        justify-content: center;
        margin-left: 75px;
    }

    .video-box{
        border-right: 2px solid black;
        width: 550px;
        max-height: 625px;
        padding: 0 25px;
    }
    
    .comment-box{
        display: flex;
        flex-direction: column;    
        overflow: auto;
        width: 550px;
        max-height: 600px;
        margin: 25px;
        padding-right: 5px;
    }

    .comment-box::-webkit-scrollbar {
      width: 10px;
    }

    .comment-box::-webkit-scrollbar-thumb {
      background: #333;
      border-radius: 5px; 
    }

    .comment-box::-webkit-scrollbar-horizontal {
      display: none;
    }

    .comment{
        border: 2px solid black;
        margin-bottom: 15px;
    }

    .name-date{
        display:flex;
        justify-content: space-between;   
        padding: 5px 10px;
    }

    .comment-content{
        padding: 0 10px 5px 10px;
    }

    .delete-btn
    {
        padding:5px;
    }

    .views-date{
        display:flex;
        justify-content: space-between;   
        padding: 5px 10px;
    }
</style>

<?php

echo '<div class="watch-flex">';

echo 
    '<div class="video-box">'.
        '<video height="500" width="500" controls autoplay>'.
            '<source src="' . $video->video_path . '" type="video/mp4">'.
        '</video><br/>'.
        "<h4>".$video->video_name."</h4>".
        "<p style='max-width:500px'>".$video->video_description."</p>".
        "<div class = 'views-date'>
            <h6>".$video->video_views." views</h6>
            <h6>posted at ".substr($video->video_upload_date, 0, -10)."</h6>
    </div></div>";

echo '<div class="comment-box">'; 
echo '<h4> Comment on this video </h4>';
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'contents')->textarea(['rows' => 2, 'maxlengt' => 200]) ?>

<div class="form-group">
    <?= Html::submitButton('Comment', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end();

foreach($comments as $comment)
{
    $channel = DB_User::findOne($comment->user_id);

    echo
    "<div class = 'comment'>
        <div class = 'name-date'>
            <h6>".$channel->username."</h6>
            <h6>posted at ".substr($comment->time_posted, 0, -10)."</h6>
        </div>
        <div class = 'comment-content'>".$comment->contents."</div>";
        if(!Yii::$app->user->isGuest)
            if(Yii::$app->user->identity->id == $comment->user_id || Yii::$app->user->identity->id == $video->user_id)
            {
                echo Html::a(Html::submitButton('delete', ['class' => 'btn btn-primary', 'style' => 'margin: 10px 5px;'])
                , ['site/delete_comment', 'comment_id' => $comment->id, 'video_id' => $video->id]);
            }
    echo "</div>";

}

echo '</div>';

echo '</div>';
