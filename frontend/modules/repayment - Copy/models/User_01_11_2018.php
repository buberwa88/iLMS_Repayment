<?php
namespace frontend\modules\repayment\models;

use Yii;
use \common\models\User as RepaymentUser;

/**
 * This is the model class for table "disbursement_user_task".
 */
class User extends RepaymentUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['user_id'], 'safe'],      
            [['firstname', 'surname', 'middlename', 'password_hash', 'email_address', 'login_type', 'created_at'], 'required'],
			[['firstname', 'surname', 'middlename', 'password_hash', 'email_address', 'password', 'created_at', 'confirm_password','phone_number'], 'required', 'on'=>'employer_registration'],
			['password', 'string', 'length' => [8, 24]],
            [['security_question_id', 'is_default_password', 'status', 'login_counts', 'activation_email_sent', 'email_verified', 'created_by', 'phone_number'], 'integer'],
            [['status_comment'], 'string'],
            [['last_login_date', 'date_password_changed', 'created_at'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            //[['sex'], 'string', 'max' => 1],
            [['username', 'passport_photo'], 'string', 'max' => 200],
            [['password_hash', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['security_answer', 'phone_number'], 'string', 'max' => 50],
            [['email_address'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email_address'], 'unique'],
            ['email_address', 'email'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly", 'on' => 'employer_registration' ],
            [['security_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\SecurityQuestion::className(), 'targetAttribute' => ['security_question_id' => 'security_question_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['password','confirm_password'],'required'],
        ]);
    }
	
}