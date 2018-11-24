<?php

namespace common\models;

use Yii;
use kartik\password\StrengthValidator;

class PasswordChangeForm extends \yii\db\ActiveRecord {

   
    public $newpass;
    public $olpassword;
    public $repeatnewpass;


    public function rules() {
        return [
            [[ 'newpass', 'repeatnewpass'], 'required'],
            ['newpass', 'findPasswords'],
           // [['newpass'], StrengthValidator::className(), 'preset' => 'normal', 'userAttribute' => 'username'],
            ['repeatnewpass', 'compare', 'compareAttribute' => 'newpass', 'message' => "Passwords don't match"],
        ];
    }

    public function findPasswords($attribute, $params) {
        $user = User::find()->where([
                    'user_id' => Yii::$app->user->identity->user_id])->one();
         echo  $hash = $user->password;
           exit();
        if ((Yii::$app->getSecurity()->validatePassword($this->newpass, $hash)) != TRUE) {
              Yii::$app->getSession()->setFlash(
                                    'errorMessage', 'Please enter new password!'
                            );
            $this->addError($attribute, 'New Password can not be the same as default password!');
        }
    }

    public function attributeLabels() {
        return [
          
            'newpass' => 'New Password',
            'repeatnewpass' => 'Repeat New Password',
        ];
    }

}
