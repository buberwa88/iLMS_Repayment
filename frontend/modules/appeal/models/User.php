<?php

namespace frontend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $sex
 * @property string $username
 * @property string $password_hash
 * @property integer $security_question_id
 * @property string $security_answer
 * @property string $email_address
 * @property string $passport_photo
 * @property string $phone_number
 * @property integer $is_default_password
 * @property integer $status
 * @property string $status_comment
 * @property integer $login_counts
 * @property string $last_login_date
 * @property string $date_password_changed
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $activation_email_sent
 * @property integer $email_verified
 * @property string $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $login_type
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'surname', 'sex', 'username', 'password_hash', 'email_address', 'phone_number', 'last_login_date', 'auth_key', 'created_at', 'updated_at'], 'required'],
            [['security_question_id', 'is_default_password', 'status', 'login_counts', 'activation_email_sent', 'email_verified', 'updated_at', 'created_by', 'login_type'], 'integer'],
            [['status_comment'], 'string'],
            [['last_login_date', 'date_password_changed', 'created_at'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['sex'], 'string', 'max' => 1],
            [['username', 'passport_photo'], 'string', 'max' => 200],
            [['password_hash', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['security_answer', 'phone_number'], 'string', 'max' => 50],
            [['email_address'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email_address'], 'unique'],
            [['security_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => SecurityQuestion::className(), 'targetAttribute' => ['security_question_id' => 'security_question_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'security_question_id' => 'Security Question ID',
            'security_answer' => 'Security Answer',
            'email_address' => 'Email Address',
            'passport_photo' => 'Passport Photo',
            'phone_number' => 'Phone Number',
            'is_default_password' => 'Is Default Password',
            'status' => 'Status',
            'status_comment' => 'Status Comment',
            'login_counts' => 'Login Counts',
            'last_login_date' => 'Last Login Date',
            'date_password_changed' => 'Date Password Changed',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'activation_email_sent' => 'Activation Email Sent',
            'email_verified' => 'Email Verified',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'login_type' => 'Login Type',
        ];
    }

    public function getFullName() {
        return $this->firstname." ".$this->middlename." ".$this->surname;
    }
}
