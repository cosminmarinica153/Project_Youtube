<?php

namespace app\models\channel;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FeedSearch extends Model
{
    public $video_name;

    public function rules()
    {
        return [
            [['video_name'], 'required'],
            [['video_name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'video_name' => 'Video name',
        ];
    }

    public function searchVideo()
    {
        if ($this->validate()) {
            $videos = [];
            $threshold = 50;
            $dataProvider = DB_Videos::find()->all();
            foreach($dataProvider as $data)
            {
                similar_text($this->video_name, $data->video_name, $similarityPercentage);
                if ($similarityPercentage >= $threshold)
                {
                    array_push($videos, $data);
                }       
            }
            return $videos;
        }
        return false;
    }
}