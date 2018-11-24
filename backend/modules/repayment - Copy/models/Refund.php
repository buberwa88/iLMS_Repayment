<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund".
 *
 * @property integer $refund_id
 * @property integer $claim_category
 * @property integer $employer_id
 * @property integer $applicant_id
 * @property string $employee_id
 * @property string $description
 * @property string $claimant_letter_id
 * @property string $claimant_letter_received_date
 * @property string $claim_decision_date
 * @property string $amount
 * @property string $phone_number
 * @property string $email_address
 * @property string $bank_name
 * @property string $bank_account_number
 * @property string $branch_name
 * @property integer $claim_status
 * @property string $claim_file_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Applicant $applicant
 * @property Employer $employer
 */
class Refund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund';
    }

    /**
     * @inheritdoc
     */
	 public $f4indexno;
	 public $fullname;
	 public $totalAmountRepaid;
	 public $beneficiary_full_name;
	 
    public function rules()
    {
        return [
            [['claim_category', 'applicant_id', 'description', 'claimant_letter_id', 'claimant_letter_received_date', 'claim_decision_date', 'amount', 'phone_number', 'claim_status', 'claim_file_id', 'created_at', 'created_by', 'bank_name', 'bank_account_number', 'branch_name'], 'required'],
            [['claim_category', 'employer_id', 'applicant_id', 'claim_status', 'created_by', 'updated_by'], 'integer'],
            [['claimant_letter_received_date', 'claim_decision_date', 'created_at', 'updated_at', 'f4indexno', 'fullname','totalAmountRepaid','beneficiary_f4indexno','beneficiary_firstname','beneficiary_middlename','beneficiary_surname', 'bank_name', 'bank_account_number', 'branch_name', 'updated_at', 'updated_by','beneficiary_applicant_id','beneficiary_full_name'], 'safe'],
			[['beneficiary_f4indexno'], 'validateF4indexnoFormat','skipOnEmpty' => true],
			[['claimant_letter_received_date', 'claim_decision_date'], 'validatedateInterval','skipOnEmpty' => false],
			[['phone_number'], 'checkphonenumber','skipOnEmpty' => false],
			[['bank_account_number'], 'checkBankAccount','skipOnEmpty' => false],
			[['email_address'], 'checkEmailTaken','skipOnEmpty' => false],
			['email_address', 'email'],
            [['amount'], 'number'],
			[['claimant_letter_id'], 'unique','message'=>'Letter ID already taken'],
            [['employee_id', 'claimant_letter_id', 'phone_number'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
            [['email_address'], 'string', 'max' => 100],
            [['bank_name', 'claim_file_id'], 'string', 'max' => 50],
            [['bank_account_number'], 'string', 'max' => 60],
            [['branch_name'], 'string', 'max' => 45],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
			[['beneficiary_applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['beneficiary_applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_id' => 'Refund ID',
            'claim_category' => 'Claim Category',
            'employer_id' => 'Employer ID',
            'applicant_id' => 'Applicant ID',
            'employee_id' => 'Employee ID',
            'description' => 'Description',
            'claimant_letter_id' => 'Letter ID',
            'claimant_letter_received_date' => 'Letter Received Date',
            'claim_decision_date' => 'Decision Date',
            'amount' => 'Refund Amount',
            'phone_number' => 'Telephone Number',
            'email_address' => 'Email Address',
            'bank_name' => 'Bank Name',
            'bank_account_number' => 'Bank Account Number',
            'branch_name' => 'Branch Name',
            'claim_status' => 'Claim Status',
            'claim_file_id' => 'Claim File ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
			'f4indexno'=>'Index Number',
			'fullname'=>'Full Name',
			'totalAmountRepaid'=>'Paid',
			'beneficiary_f4indexno'=>'Index Number',
			'beneficiary_firstname'=>'First Name',
			'beneficiary_middlename'=>'Middle Name',
			'beneficiary_surname'=>'Last Name',
			'beneficiary_full_name'=>'Full Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getBeneficiaryApplicant()
    {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'beneficiary_applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }
	 public function validateF4indexnoFormat($attribute, $params)
{
    $f4indexno=str_replace(".","",str_replace("S","",$this->beneficiary_f4indexno));	
	 if (!preg_match('/^[0-9]*$/', $f4indexno)) {
    $this->addError($attribute, 'Incorrect Form IV index Number');
    } 
	if(strlen($f4indexno) !=12){
	$this->addError($attribute, 'Incorrect Form IV index Number');
	}
}
    public function validatedateInterval($attribute, $params){
    // Maximum date today - 18 years
     //$maxBirthday = new \DateTime();
     //$maxBirthday->sub(new \DateInterval('P18Y'));
    if($this->claim_decision_date < $this->claimant_letter_received_date){
        $this->addError($attribute,'Please give correct Decision and letter received date');
    }
  }
  public static function getTotalRefundPerBeneficiary($applicantID){	 
	 $refundPaid = Refund::findBySql("SELECT  SUM(amount) AS 'amount'  FROM  refund WHERE  applicant_id='$applicantID'")->one();        
	 return $refundPaid->amount;
}
  public function checkphonenumber($attribute, $params)
{
    $phone=str_replace(",","",$this->phone_number);
	 if (!preg_match('/^[0-9]*$/', $phone)) {
    $this->addError('phone_number', 'Incorrect Telephone Number');
    } 
}
public function checkBankAccount($attribute, $params)
{
    $bankAccount=Refund::find()
	->andWhere(['bank_account_number' =>$this->bank_account_number])
	->andWhere(['not', ['applicant_id' =>$this->applicant_id]])
	->one();
	 if (count($bankAccount)>0) {
    $this->addError('bank_account_number', 'Bank account number already taken');
    } 
}
public function checkEmailTaken($attribute, $params)
{
    $emailAddress=Refund::find()
	->andWhere(['email_address' =>$this->email_address])
	->andWhere(['not', ['applicant_id' =>$this->applicant_id]])
	->one();
	 if (count($emailAddress)>0) {
    $this->addError('email_address', 'Email address already taken');
    } 
}
    public static function getApplicantName($applicantId) {
            $data2 = \common\models\User::findBySql(" SELECT user.user_id AS id, CONCAT(firstname,' ',middlename,' ',surname) AS name FROM user INNER JOIN applicant ON user.user_id=applicant.user_id WHERE applicant_id='$applicantId'")->asArray()->all();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
        
    }
}
