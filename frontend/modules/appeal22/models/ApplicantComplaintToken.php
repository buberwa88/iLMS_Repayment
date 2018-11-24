<?php

namespace backend\modules\appeal\models;

use Yii;
use \backend\modules\appeal\models\base\ApplicantComplaintToken as BaseApplicantComplaintToken;

/**
 * This is the model class for table "applicant_complaint_token".
 */
class ApplicantComplaintToken extends BaseApplicantComplaintToken
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['token','applicant_id','status'], 'required'],
            [['applicant_id', 'created_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['token'], 'string', 'max' => 64]
        ]);
    }
    
    
    public function getFullName(){
        return $this->applicant->user->firstname." ".$this->applicant->user->middlename." ".$this->applicant->user->surname;
    }

    public function getTokenStatus(){
        
        if($this->status == 0){
            return "Active";
        }

        return "Used";
    }
}
