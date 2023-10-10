<?php

namespace app\models\user;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class DB_User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return "db_user";
    }

    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['authKey', 'accesToken'], 'integer'],
            ['username', 'string', 'min' => 5, 'max' => 15],
            ['email', 'email'],
            ['password', 'password'],
            ['password', 'string', 'min' => 8, 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'email',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function getIdByUsername($username)
    {
        return Yii::$app->db->createCommand('SELECT id FROM db_user WHERE username=:username')
           ->bindValue(':username', "'".$username."'")
           ->queryOne();
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password == $password;
    }
    
    public static function findByEmail($email)
    {
       return static::findOne(['email' => $email]);
    }

    public static function saveAccount($email, $username, $password)
    {
        $authKey = rand(100, 999);
        $accesToken = 0;

        Yii::$app->db->createCommand()->insert('db_user', [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'authKey' => $authKey,
            'accesToken' => $accesToken,
        ])->execute();
    }
}