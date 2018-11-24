<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\LoanRepayment;

/**
 * This is the model class for table "treasury_payment".
 *
 * @property integer $treasury_payment_id
 * @property string $bill_number
 * @property string $control_number
 * @property string $amount
 * @property string $receipt_number
 * @property integer $pay_method_id
 * @property string $pay_phone_number
 * @property string $payment_date
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $date_receipt_received
 * @property integer $payment_status
 *
 * @property PayMethod $payMethod
 * @property TreasuryPaymentDetail[] $treasuryPaymentDetails
 */
class TreasuryPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'treasury_payment';
    }

    /**
     * @inheritdoc
     */
     public $amountx;
     public $totalBeneficiaries;
	 
    public function rules()
    {
        return [
            [['amount', 'pay_method_id'], 'required'],
            [['amount'], 'number'],
            [['pay_method_id', 'payment_status'], 'integer'],
			[['payment_date'], 'required','on'=>'billGeneration'],
            [['payment_date', 'date_bill_generated', 'date_control_received', 'date_receipt_received', 'amountx','totalBeneficiaries'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['pay_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\PayMethod::className(), 'targetAttribute' => ['pay_method_id' => 'pay_method_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'treasury_payment_id' => 'Treasury Payment ID',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'amount' => 'Amount',
            'receipt_number' => 'Receipt Number',
            'pay_method_id' => 'Pay Method ID',
            'pay_phone_number' => 'Pay Phone Number',
            'payment_date' => 'Payment Date',
            'date_bill_generated' => 'Date Bill Generated',
            'date_control_received' => 'Date Control Received',
            'date_receipt_received' => 'Date Receipt Received',
            'payment_status' => 'Payment Status',
			'amountx'=>'Amount',
			'totalBeneficiaries'=>'Total Beneficiaries',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayMethod()
    {
        return $this->hasOne(\backend\modules\repayment\models\PayMethod::className(), ['pay_method_id' => 'pay_method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreasuryPaymentDetails()
    {
        return $this->hasMany(TreasuryPaymentDetail::className(), ['treasury_payment_id' => 'treasury_payment_id']);
    }
	
	public static function checkUnCompleteBillTreasury(){
        $existIncompleteBill = TreasuryPayment::findBySql("SELECT * FROM treasury_payment "
                . "WHERE  treasury_payment.payment_status IS NULL")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
	public static function checkControlNumberStatus(){
        $existPendingControlNumber = TreasuryPayment::findBySql("SELECT * FROM treasury_payment "
                . "WHERE  treasury_payment.payment_status IS NULL AND treasury_payment.date_receipt_received IS NULL")->one();
        $details=$existPendingControlNumber->treasury_payment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }
	public static function checkBillPendingGovernmentEmployers(){
        $existPendingControlNumber = LoanRepayment::findBySql("SELECT loan_repayment.loan_repayment_id AS loan_repayment_id FROM loan_repayment INNER JOIN employer ON loan_repayment.employer_id=employer.employer_id "
                . "WHERE  loan_repayment.control_number IS NULL AND employer.salary_source='1'")->one();
		if(count($existPendingControlNumber)>0){
		$results=1;
		}else{
		$results=0;
		}	
        return $results;
        }
	public static function getAmountRequiredForPayment($treasury_payment_id){
       $details_amount = TreasuryPaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM treasury_payment_detail  WHERE  treasury_payment_detail.treasury_payment_id='$treasury_payment_id'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
	public function updateConfirmPaymentandControlNo($treasury_payment_id,$controlNumber){
        $date=date("Y-m-d H:i:s");
     $this->updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'treasury_payment_id ="'.$treasury_payment_id.'" AND (control_number="" OR control_number IS NULL)');  
      
	  $details_treasuryPayment = TreasuryPaymentDetail::findBySql("SELECT * FROM treasury_payment_detail WHERE  treasury_payment_id='$treasury_payment_id'")->all();
        
        foreach ($details_treasuryPayment as $paymentTreasuryDetails) { 
           $loan_repayment_id=$paymentTreasuryDetails->loan_repayment_id;           
      LoanRepayment::updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'loan_repayment_id ="'.$loan_repayment_id.'" AND (control_number="" OR control_number IS NULL)');
	  }
    }	
    public function updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$treasury_payment_id){
        $date=date("Y-m-d H:i:s");
        $this->updateAll(['bill_number' =>$repaymnet_reference_number,'amount'=>$totalAmount1,'date_bill_generated'=>$date], 'treasury_payment_id ="'.$treasury_payment_id.'"'); 
    }
    
    
}
