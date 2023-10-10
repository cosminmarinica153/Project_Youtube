<?php

namespace app\models\user;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $username;
    public $password;
    public $password2;

    public function rules()
    {
        return [
            [['email', 'username', 'password', 'password2'], 'required'],
            ['username', 'string', 'min' => 5, 'max' => 15],
            ['username', 'validateUsername'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['password', 'string', 'min' => 8, 'max' => 20],
            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'email',
            'username' => 'Username',
            'password' => 'Password',
            'password2' => 'Confirm Password',
        ];
    }

    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if(DB_User::findByUsername($this->username))
                $this->addError($attribute, 'Username already exists!');
        }
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if(DB_user::findByEmail($this->email))
                $this->addError($attribute, 'Email already in use!');
        }
    }

    public function register()
    {
        if ($this->validate()) {
            DB_User::saveAccount($this->email, $this->username, $this->password);
            return true;
        }
        return false;
    }

}