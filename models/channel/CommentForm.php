<?php

namespace app\models\channel;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $contents;

    public function rules()
    {
        return [
            [['contents'], 'required'],
            ['contents', 'string', 'max' => 200, 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'contents' => 'Add comment'
        ];
    }

    public function addComment($video_id, $user_id)
    {
        if ($this->validate()) {
            DB_Comments::addComment($video_id, $user_id, $this->contents);
            return true;
        }
        return false;
    }
}