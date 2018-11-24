<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "applicant".
 *
 * @property integer $applicant_id
 * @property integer $user_id
 * @property string $NID
 * @property string $f4indexno
 * @property string $f6indexno
 * @property string $mailing_address
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property integer $loan_repayment_bill_requested
 *
 * @property User $user
 * @property Application[] $applications
 * @property EmployedBeneficiary[] $employedBeneficiaries
 * @property LoanRepaymentBatch[] $loanRepaymentBatches
 * @property LoanRepaymentBatchDetail[] $loanRepaymentBatchDetails
 * @property LoanRepaymentBill[] $loanRepaymentBills
 * @property LoanRepaymentBillDetail[] $loanRepaymentBillDetails
 */
class Applicant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $region_id;
    public $district_id;
    public static function tableName()
    {
        return 'applicant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','f4indexno', 'mailing_address','birth_certificate_number','region_id','district_id','date_of_birth','place_of_birth','disability_status'], 'required'],
//            [['disability_document'], 'required', 'when' => function ($model) {
//                    return $model->disability_status =="YES";
//                },
//                'whenClient' => "function (attribute, value) { "
//                . " return $('#applicant-disability_status').val() == 'YES'; }"],

            [['user_id'], 'integer'],
            [[ 'NID', 'date_of_birth','region_id','district_id','identification_type_id','identification_document','disability_document','disability_status','identification_document','birth_certificate_document'], 'safe'],
            [['NID'], 'string', 'max' => 30],
            [['f4indexno', 'f6indexno'], 'string', 'max' => 45],
            [['mailing_address'], 'string', 'max' => 80],
            //[['place_of_birth'], 'string', 'max' => 100],
          //  [['f4indexno'], 'unique'],
          // [['NID'], 'unique'],
            [['user_id'], 'unique'],
           // [['f6indexno'], 'unique'],
           // [['phone_number'], 'number'],
           // [['phone_number'], 'match', 'pattern' =>'/^\d{10}$/'],
            
            [['date_of_birth'], 'validateDateOfBirth','skipOnEmpty' => false],
            
         
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_id' => 'Applicant ID',
            'user_id' => 'User ID',
            'NID' => 'Identification Number',
            'identification_document'=>'Identification Document',
            'birth_certificate_number'=>'Birth Certificate Number',
            'f4indexno' => 'Form 4 Index #',
            'disability_status'=>"Are you disabled ?",
            'disability_status'=>"Are you disabled ?",
            'f6indexno' => 'F6 Index #',
            'mailing_address' => 'Postal Address',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Ward Name',
            'region_id' => 'Region Name',
            'district_id' => 'District Name',
            'loan_repayment_bill_requested' => 'Loan Repayment Bill Requested',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployedBeneficiaries()
    {
        return $this->hasMany(EmployedBeneficiary::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBatches()
    {
        return $this->hasMany(LoanRepaymentBatch::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBatchDetails()
    {
        return $this->hasMany(LoanRepaymentBatchDetail::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBills()
    {
        return $this->hasMany(LoanRepaymentBill::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBillDetails()
    {
        return $this->hasMany(LoanRepaymentBillDetail::className(), ['applicant_id' => 'applicant_id']);
    }
     public function getWard()
    {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'place_of_birth']);
    }
   /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationType()
    {
        return $this->hasOne(\common\models\IdentificationType::className(), ['identification_type_id' => 'identification_type_id']);
    }
     public function validateDateOfBirth($attribute, $params){
    // Maximum date today - 18 years
     $maxBirthday = new \DateTime();
     $maxBirthday->sub(new \DateInterval('P15Y'));
    if($this->date_of_birth > $maxBirthday->format('Y-m-d')){
        $this->addError($attribute,'Please give correct Date of Birth');
    }
  }
public function validatePhone($attribute, $params){
             $test_start=$this->phone_number;
      if($test_start[0]!=0){
        $this->addError($attribute,'Phone number must start with Zero (0)');
    }
  }
}

?>