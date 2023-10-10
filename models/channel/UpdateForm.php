<?php

namespace app\models\channel;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UpdateForm extends Model
{
    public $video_name;
    public $video_description;

    public function rules()
    {
        return [
            [['video_name', 'video_description'], 'required'],
            [['video_name'], 'string', 'max' => 50],
            ['video_name', 'validateName'],
            [['video_description'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'video_name' => 'Video name',
            'video_description' => 'Video description',
        ];
    }

    public function validateName($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            $video = DB_Videos::findByVideoName($this->video_name);
            if(DB_Videos::findByVideoName($this->video_name))
                    $this->addError($attribute, 'Video title already in use');
        }
    }

    public function updateVideo($id)
    {
        if ($this->validate()) {
            Yii::$app->db->createCommand()->update('db_videos', [
                'video_name' => $this->video_name,
                'video_description' => $this->video_description
            ], 'id = '.$id)->execute();
            return true;
        }
        return false;
    }
}