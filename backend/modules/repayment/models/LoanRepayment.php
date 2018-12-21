<?php

namespace backend\modules\repayment\models;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\repayment\models\LoanRepaymentDetail;

/**
 * This is the model class for table "loan_repayment".
 *
 * @property integer $loan_repayment_id
 * @property integer $employer_id
 * @property integer $applicant_id
 * @property string $repayment_reference_number
 * @property string $control_number
 * @property double $amount
 * @property string $receipt_number
 * @property integer $pay_method_id
 * @property string $pay_phone_number
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $date_receipt_received
 *
 * @property Applicant $applicant
 * @property Employer $employer
 * @property PayMethod $payMethod
 * @property LoanRepaymentDetail[] $LoanRepaymentDetails
 */
class LoanRepayment extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'loan_repayment';
    }

    /**
     * @inheritdoc
     */
    public $totalEmployees;
    public $operation;

    public function rules() {
        return [
            [['employer_id', 'applicant_id', 'pay_method_id'], 'integer'],
            [['cancel_reason'], 'required', 'on' => 'Cancell_bill_repayment'],
            //[['amount', 'pay_method_id'], 'required'],
            //[['amount'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'totalEmployees', 'payment_status', 'amount', 'pay_method_id', 'payment_date', 'operation', 'payment_date', 'gepg_cancel_request_status'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['pay_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\PayMethod::className(), 'targetAttribute' => ['pay_method_id' => 'pay_method_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'loan_repayment_id' => 'Loan Repayment Batch ID',
            'employer_id' => 'Employer',
            'applicant_id' => 'Applicant',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'amount' => 'Amount',
            'receipt_number' => 'Receipt Number',
            'pay_method_id' => 'Pay Method',
            'pay_phone_number' => 'Pay Phone Number',
            'date_bill_generated' => 'Payment Date',
            'date_control_received' => 'Date Control Received',
            'date_receipt_received' => 'Date Receipt Received',
            'totalEmployees' => 'Total Employees',
            'payment_status' => 'Payment Status',
            'payment_date' => 'Date of Bill',
            'operation' => 'Operation',
            'payment_date' => 'Bill Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant() {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer() {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayMethod() {
        return $this->hasOne(\backend\modules\repayment\models\PayMethod::className(), ['pay_method_id' => 'pay_method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentDetails() {
        return $this->hasMany(LoanRepaymentDetail::className(), ['loan_repayment_id' => 'loan_repayment_id']);
    }

    public function checkControlNumberStatus($employerID) {
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                        . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id='$employerID'")->one();
        $details = $existPendingControlNumber->loan_repayment_id;
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
    }

    public function getAmountRequiredForPayment($loan_repayment_id) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                        . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $amount = $details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
    }

    public function getAllEmployeesUnderBillunderEmployer($loan_repayment_id) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $totalLoanees = LoanRepaymentDetail::findBySql("SELECT COUNT(DISTINCT applicant_id) AS 'totalLoanees' FROM loan_repayment_detail WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $totalLoanees_v = $totalLoanees->totalLoanees;

        $value = (count($totalLoanees_v) == 0) ? '0' : $totalLoanees_v;
        return $value;
    }

    public function updateReferenceNumber($repaymnet_reference_number, $totalAmount1, $loan_repayment_id) {
        $date = date("Y-m-d H:i:s");
        $this->updateAll(['bill_number' => $repaymnet_reference_number, 'amount' => $totalAmount1, 'date_bill_generated' => $date], 'loan_repayment_id ="' . $loan_repayment_id . '"');
    }

    public function updateConfirmPaymentandControlNo($loan_repayment_id, $controlNumber) {
        $date = date("Y-m-d H:i:s");
        $this->updateAll(['date_control_received' => $date, 'control_number' => $controlNumber, 'payment_status' => '0'], 'loan_repayment_id ="' . $loan_repayment_id . '" AND (control_number="" OR control_number IS NULL)');
    }

    // used twice
    public function getLoanRepayment($loan_repayment_id) {
        $batchDetails = $this->findBySql("SELECT * FROM loan_repayment "
                        . "WHERE  loan_repayment.loan_repayment_id='$loan_repayment_id'")->one();
        $details = $batchDetails->loan_repayment_id;
        $value = (count($details) == 0) ? '0' : $batchDetails;
        return $value;
    }

    public function checkWaitingConfirmationFromGePG($employerID) {
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                        . "WHERE  loan_repayment.payment_status='0' AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id='$employerID'")->one();
        $details = $existPendingControlNumber->loan_repayment_id;
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
    }

    public function getDataUnderLoanRepaymentId($employerID) {
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                        . "WHERE  (loan_repayment.payment_status='0' OR loan_repayment.payment_status IS NULL OR loan_repayment.payment_status='1') AND loan_repayment.employer_id='$employerID' ORDER BY loan_repayment_id DESC")->one();
        $details = $existPendingControlNumber->loan_repayment_id;
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
    }

    /*
     * returns the Pament status 
     */

    function getPaymentStatus() {
        switch ($this->payment_status) {
            case 0:
                return 'Pending/Bill Confirmed';

                break;

            case 1:
                return 'Received/Confirmed';
                break;

            case 2:
                return 'Pending/Treasury';
                break;

            case 3:
                return 'Cancelled';
                break;

            default :
                return NULL;
                break;
        }
    }

}
