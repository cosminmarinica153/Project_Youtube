<?php

namespace app\models\channel;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadForm extends Model
{
    public $video_name;
    public $video_description;
    public $video_file;

    public function rules()
    {
        return [
            [['video_name', 'video_description', 'video_file'], 'required'],
            ['video_name', 'string', 'max' => 50],
            ['video_name', 'validateName'],
            ['video_description', 'string', 'max' => 200],
            ['video_file', 'file','skipOnEmpty' => false, 'extensions' => 'mp4, avi, mkv', 'maxSize' => 50 * 1024 * 1024]
        ];
    }

    public function attributeLabels()
    {
        return [
            'video_name' => 'Video name',
            'video_description' => 'Video description',
            'video_file' => 'Upload File',
        ];
    }

    public function validateName($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if(DB_Videos::findByVideoName($this->video_name))
                $this->addError($attribute, 'Video title already exists!');
        }
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = 'videos/' . $this->video_name . '.' . $this->video_file->extension;
            $this->video_file->saveAs($path);
            DB_Videos::saveVideo($this->video_name, $this->video_description, $path);
            return true;
        }
        return false;
    }
}