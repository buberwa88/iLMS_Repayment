<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email_address;
    public $password;
    public $firstname;
    public $middlename;
    public $surname;
    
    public $sex;
     
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['middlename', 'safe'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['password','firstname','surname'], 'required'],
            ['email_address', 'filter', 'filter' => 'trim'],
            ['email_address', 'required'],
            ['email_address', 'email'],
            ['email_address', 'string', 'max' => 255],
            ['email_address', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        
        $user->firstname = $this->firstname;
        $user->middlename = $this->middlename;
        $user->surname = $this->surname;
        $user->sex = $this->sex;
        $user->username = $this->username;
        $user->email_address = $this->email_address;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
