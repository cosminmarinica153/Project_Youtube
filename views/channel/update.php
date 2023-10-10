<?php

use app\models\user\DB_User;
use yii\helpers\Html;

$this->title = 'Update Videos';
$this->beginContent('@app/views/layouts/channel.php');
$this->endContent();

echo "<h1> Chose a video to update </h1><br/>"; 
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

    echo "<div class = 'video-box'>";

    echo Html::a('
    <video width="250" height="250" poster">
        <source src="'.$video->video_path.'" type="video/mp4">
    </video>', ['channel/update_form', 'id' => $video->id]);
    
    echo '<h5>'.$video->video_name.'</h5>';
    echo "</div>";
}

echo "</div>";

?>
