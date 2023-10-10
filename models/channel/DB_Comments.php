<?php

namespace app\models\channel;

use Yii;
use yii\db\ActiveRecord;

class DB_Comments extends ActiveRecord
{
    public static function tableName()
    {
        return "db_comments";
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'video_id', 'contents', 'time_posted'], 'required'],
            ['contents', 'string', 'max' => 200, 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'contents' => 'Comment',
            'time_posted' => 'Posted at ',
        ];
    }

    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function addComment($video_id, $user_id, $contents)
    {
        Yii::$app->db->createCommand()->insert('db_comments', [
            'video_id' => $video_id,
            'user_id' => $user_id,
            'contents' => $contents,
        ])->execute();
    }

    public static function deleteComment($id)
    {
        Yii::$app->db->createCommand()->delete('db_comments', 'id = '.$id)->execute();
        return true;
    }
}