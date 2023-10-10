<?php

namespace app\models\channel;

use Yii;
use yii\db\ActiveRecord;

class DB_Videos extends ActiveRecord
{
    public static function tableName()
    {
        return "db_videos";
    }

    public function rules()
    {
        return [
            [['user_id', 'video_name', 'video_description', 'video_views', 'video_upload_date', 'video_path'], 'required'],
            ['user_id', 'exist', 'targetClass' => DB_User::class, 'targetAttribute' => 'id'],
            ['video_name', 'string', 'max' => 100],
            ['video_description', 'string', 'max' => 200],
            ['video_views', 'int'],
            ['video_upload_date', 'timestamp'],
            ['video_path', 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'video_name' => 'Video Name',
            'video_description' => 'Video Description',
            'video_views' => 'Views',
            'video_upload_date' => 'Upload Date',
            'video_path' => 'Video Path',
        ];
    }

    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findByVideoName($video_name)
    {
        return static::findOne(['video_name' => $video_name]);
    }

    public static function saveVideo($video_name, $video_description, $video_path)
    {
        $user_id = Yii::$app->user->identity->getId();
        $video_views = 0;

        Yii::$app->db->createCommand()->insert('db_videos', [
            'user_id' => $user_id,
            'video_name' => $video_name,
            'video_description' => $video_description,
            'video_views' => $video_views,
            'video_path' => $video_path
        ])->execute();
    }

    public static function deleteVideo($id)
    {
        Yii::$app->db->createCommand()->delete('db_videos', 'id = '.$id)->execute();
        
        return true;
    }

    public static function incrementViews($video)
    {
        $video->video_views++;

        Yii::$app->db->createCommand()->update('db_videos', [
            'video_views' => $video->video_views,
        ], 'id = '.$video->id)->execute();
    }
}