<?php

namespace frontend\modules\appeal\models;

use Yii;
use \frontend\modules\appeal\models\base\Appeal as BaseAppeal;

/**
 * This is the model class for table "appeal".
 */
class Appeal extends BaseAppeal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['application_id', 'current_study_year', 'appeal_category_id', 'updated_by', 'created_at'], 'required'],
            [['application_id', 'current_study_year', 'appeal_category_id', 'verification_status', 'updated_by'], 'integer'],
            [['amount_paid', 'needness'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at', 'updated_at'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13]
        ]);
    }
    
    
    public function getApplicantFullName()
    {
        return $this->application->applicant->user->firstname." ".$this->application->applicant->user->middlename.$this->application->applicant->user->surname;
    }

}
