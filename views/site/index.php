<?php

use app\models\user\DB_User; 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Youtube";

echo "<br/><br/>";
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

<?php

echo "<div class = 'feed-grid'>";

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