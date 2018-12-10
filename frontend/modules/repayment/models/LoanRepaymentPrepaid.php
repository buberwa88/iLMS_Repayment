<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "loan_repayment_prepaid".
 *
 * @property integer $prepaid_id
 * @property integer $employer_id
 * @property integer $applicant_id
 * @property integer $loan_summary_id
 * @property string $monthly_amount
 * @property string $payment_date
 * @property string $created_at
 * @property integer $created_by
 * @property string $bill_number
 * @property string $control_number
 * @property string $receipt_number
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $receipt_date
 * @property string $date_receipt_received
 * @property integer $payment_status
 * @property integer $cancelled_by
 * @property string $cancelled_at
 * @property string $cancel_reason
 * @property integer $gepg_cancel_request_status
 * @property integer $monthly_deduction_status
 * @property string $date_deducted
 */
class LoanRepaymentPrepaid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	const TOTAL_MONTHS_1 = '1';
    const TOTAL_MONTHS_2 = '2';
    const TOTAL_MONTHS_3 = '3';
    const TOTAL_MONTHS_4 = '4';
    const TOTAL_MONTHS_5 = '5';
    const TOTAL_MONTHS_6 = '6';
    const TOTAL_MONTHS_7 = '7';
    const TOTAL_MONTHS_8 = '8';
    const TOTAL_MONTHS_9 = '9';
    const TOTAL_MONTHS_10 = '10';
    const TOTAL_MONTHS_11 = '11';
	const TOTAL_MONTHS_12 = '12';
	
	const GEPG_PAYMENT_CATEGORY_EMPLOYER_BILL = 'EMPLOYER_BILL';
    const GEPG_PAYMENT_CATEGORY_BENEFICIARY_BILL = 'BENEFICIARY_BILL';
    const GEPG_PAYMENT_CATEGORY_EMPLOYER_PENALTY_BILL = 'EMPLOYER_PENALTY_BILL';
	const GEPG_PAYMENT_CATEGORY_EMPLOYER_PRE_PAID_BILL = 'EMPLOYER_PRE_PAID_BILL';
	const GEPG_PAYMENT_CATEGORY_TRESURY_BILL = 'TRESURY_BILL';
	
    public static function tableName()
    {
        return 'loan_repayment_prepaid';
    }

    /**
     * @inheritdoc
     */
	 public $payment_date2;
	 public $totalMonths;
	 public $totalBeneficiaries;
    public function rules()
    {
        return [
            //[['employer_id', 'applicant_id', 'loan_summary_id', 'monthly_amount', 'created_by', 'bill_number'], 'required'],
			[['payment_date','totalMonths'], 'required','on'=>'prepaid_posting'],
            [['employer_id', 'applicant_id', 'loan_summary_id', 'created_by', 'payment_status', 'cancelled_by', 'gepg_cancel_request_status', 'monthly_deduction_status'], 'integer'],
            [['monthly_amount'], 'number'],
            [['payment_date', 'created_at', 'date_bill_generated', 'date_control_received', 'receipt_date', 'date_receipt_received', 'cancelled_at', 'date_deducted'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['cancel_reason'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prepaid_id' => 'Prepaid ID',
            'employer_id' => 'Employer ID',
            'applicant_id' => 'Applicant ID',
            'loan_summary_id' => 'Loan Summary ID',
            'monthly_amount' => 'Monthly Amount',
            'payment_date' => 'From Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'receipt_number' => 'Receipt Number',
            'date_bill_generated' => 'Date Bill Generated',
            'date_control_received' => 'Date Control Received',
            'receipt_date' => 'Receipt Date',
            'date_receipt_received' => 'Date Receipt Received',
            'payment_status' => 'Payment Status',
            'cancelled_by' => 'Cancelled By',
            'cancelled_at' => 'Cancelled At',
            'cancel_reason' => 'Cancel Reason',
            'gepg_cancel_request_status' => 'Gepg Cancel Request Status',
            'monthly_deduction_status' => 'Monthly Deduction Status',
            'date_deducted' => 'Date Deducted',
			'totalMonths'=>'Total Months',
        ];
    }
	 public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }
	public function getApplicant()
    {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }
	 static function getTotalMonths() {
        return 
		    [self::TOTAL_MONTHS_1 => '1',
            self::TOTAL_MONTHS_2 => '2',
            self::TOTAL_MONTHS_3 => '3',
            self::TOTAL_MONTHS_4 => '4',
            self::TOTAL_MONTHS_5 => '5',
            self::TOTAL_MONTHS_6 => '6',
            self::TOTAL_MONTHS_7 => '7',
            self::TOTAL_MONTHS_8 => '8',
            self::TOTAL_MONTHS_9 => '9',
            self::TOTAL_MONTHS_10 => '10',
            self::TOTAL_MONTHS_11 => '11',
			self::TOTAL_MONTHS_12 => '12',
        ];
    }
	public static function getTotalAmountPrepaid($employerID){
       return self::findBySql("SELECT SUM(loan_repayment_prepaid.monthly_amount) AS monthly_amount,loan_repayment_prepaid.bill_number "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND (loan_repayment_prepaid.payment_status IS NULL)")->one();
        }
	public static function getTotalBeneficiariesUnderPrePaid($employerID){
       return self::findBySql("SELECT * "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND (loan_repayment_prepaid.payment_status IS NULL) GROUP BY applicant_id")->count();
        }
public static function updateConfirmPaymentandControlNoprepaidbill($bill_number,$controlNumber,$employerID){
        $date=date("Y-m-d H:i:s");
     self::updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'bill_number ="'.$bill_number.'" AND (control_number="" OR control_number IS NULL) AND (payment_status="" OR payment_status IS NULL) AND employer_id="'.$employerID.'"');       
        }
public static function getPendingPaymentPrepaid($employerID){
       return self::findBySql("SELECT * "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND (loan_repayment_prepaid.payment_status='0')")->count();
        }
public static function getGetPendingPayment($employerID){
       return self::findBySql("SELECT SUM(loan_repayment_prepaid.monthly_amount) AS monthly_amount,loan_repayment_prepaid.bill_number,loan_repayment_prepaid.control_number "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND (loan_repayment_prepaid.payment_status='0')")->one();
        }
public static function checkForCofrmedPaymentNotConsumed($employerID){
       return self::findBySql("SELECT * "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND loan_repayment_prepaid.payment_status ='1' AND loan_repayment_prepaid.monthly_deduction_status='0'")->count();
        }
static function getGePGpaymentCategory() {
        return 
		    [self::GEPG_PAYMENT_CATEGORY_EMPLOYER_BILL => 'EMPLOYER BILL',
            self::GEPG_PAYMENT_CATEGORY_BENEFICIARY_BILL => 'BENEFICIARY BILL',
            self::GEPG_PAYMENT_CATEGORY_EMPLOYER_PENALTY_BILL => 'EMPLOYER PENALTY BILL',
            self::GEPG_PAYMENT_CATEGORY_EMPLOYER_PRE_PAID_BILL => 'EMPLOYER PRE PAID BILL',
			self::GEPG_PAYMENT_CATEGORY_TRESURY_BILL => 'TRESURY BILL',
        ];
    }
public static function getTotalBeneficiariesUnderPrePaidheslb($employerID,$bill_number){
       return self::findBySql("SELECT * "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND  loan_repayment_prepaid.bill_number='$bill_number' GROUP BY applicant_id")->count();
        }	
public static function getstartPrePaidheslb($employerID,$bill_number){
      $results=self::findBySql("SELECT payment_date "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND  loan_repayment_prepaid.bill_number='$bill_number' ORDER BY loan_repayment_prepaid.prepaid_id ASC")->one();
				return $results->payment_date;
        }
public static function getEndPrePaidheslb($employerID,$bill_number){
      $results33=self::findBySql("SELECT payment_date "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND  loan_repayment_prepaid.bill_number='$bill_number' ORDER BY loan_repayment_prepaid.prepaid_id DESC")->one();
				return $results33->payment_date;
        }
public static function getTotalAmountUnderBillPrepaid($employerID,$bill_number){
      $results=self::findBySql("SELECT SUM(monthly_amount) AS monthly_amount "
                . "FROM loan_repayment_prepaid  WHERE  loan_repayment_prepaid.employer_id='$employerID' AND  loan_repayment_prepaid.bill_number='$bill_number'")->one();
				return $results->monthly_amount;
        }
}
