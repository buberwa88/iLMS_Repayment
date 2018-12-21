<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "employer_contact_person".
 *
 * @property integer $repayment_employer_contact_person_id
 * @property integer $employer_id
 * @property integer $user_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $role
 */
class EmployerContactPerson extends \yii\db\ActiveRecord
{
    
    const ROLE_PRIMARY = "Primary";
    const ROLE_SECONDARY = "Secondary";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer_contact_person';
    }

    /**
     * @inheritdoc
     */
	 public $salary_source;
	 public $employer_name;
	 public $short_name;
	 public $employer_code;
	 public $email_verification_code;
	 
    public function rules()
    {
        return [
            [['employer_id', 'user_id', 'role'], 'required'],
            [['employer_id', 'user_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['role'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */	 
    public function attributeLabels()
    {
        return [
            'repayment_employer_contact_person_id' => 'Repayment Employer Contact Person ID',
            'employer_id' => 'Employer ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'role' => 'Role',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'user_id']);
    }
	public function getEmployer()
    {
        return $this->hasOne(\frontend\modules\repayment\models\Employer::className(), ['employer_id' => 'employer_id']);
    }
}
