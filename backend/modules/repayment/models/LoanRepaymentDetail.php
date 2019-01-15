<?php

namespace backend\modules\repayment\models;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\repayment\models\LoanRepaymentSetting;

/**
 * This is the model class for table "loan_repayment_detail".
 *
 * @property integer $loan_repayment_detail_id
 * @property integer $loan_repayment_id
 * @property integer $applicant_id
 * @property integer $loan_repayment_item_id
 * @property double $amount
 * @property integer $loan_summary_id
 *
 * @property Applicant $applicant
 * @property LoanRepaymentItem $loanRepaymentItem
 * @property LoanRepayment $LoanRepayment
 * @property LoanSummary $LoanSummary
 */
class LoanRepaymentDetail extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'loan_repayment_detail';
    }

    /**
     * @inheritdoc
     */
    public $applicantName;
    public $totalLoanees;
    public $firstname;
    public $middlename;
    public $surname;
    public $totalAmount;
    public $f4indexno;
    public $principal;
    public $penalty;
    public $LAF;
    public $vrf;
    public $totalLoan;
    public $outstandingDebt;
    public $employer_code;
    public $short_name;
    public $payment_date;
    public $receipt_date;
    public $employer_id;

    public function rules() {
        return [
            [['loan_repayment_id', 'applicant_id', 'loan_summary_id'], 'required'],
            [['loan_repayment_id', 'applicant_id', 'loan_repayment_item_id', 'loan_summary_id'], 'integer'],
            [['applicantName', 'totalLoanees', 'firstname', 'middlename', 'surname', 'amount', 'totalAmount', 'f4indexno', 'principal', 'penalty', 'LAF', 'vrf', 'totalLoan', 'outstandingDebt', 'loan_given_to', 'updated_at', 'updated_by', 'vote_number', 'Vote_name', 'sub_vote', 'sub_vote_name', 'lawson_loan_balance', 'lawson_payment_date', 'deduction_code', 'deduction_description', 'control_number', 'payment_status', 'employer_id', 'financial_year_id', 'academic_year_id','pre_post_heslb','has_disco','employer_id'], 'safe'],
            //[['amount'], 'number'],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['loan_repayment_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\LoanRepaymentItem::className(), 'targetAttribute' => ['loan_repayment_item_id' => 'loan_repayment_item_id']],
            [['loan_repayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanRepayment::className(), 'targetAttribute' => ['loan_repayment_id' => 'loan_repayment_id']],
            [['loan_summary_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSummary::className(), 'targetAttribute' => ['loan_summary_id' => 'loan_summary_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'loan_repayment_detail_id' => 'Loan Repayment Batch Detail ID',
            'loan_repayment_id' => 'Loan Repayment Batch ID',
            'applicant_id' => 'Applicant ID',
            'loan_repayment_item_id' => 'Loan Repayment Item ID',
            'amount' => 'Amount(TZS)',
            'loan_summary_id' => 'Loan Repayment Bill ID',
            'applicantName' => 'Full Name',
            'totalLoanees' => 'Total Employees',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'surname' => 'Surname',
            'totalAmount' => 'Total Amount(TZS)',
            'principal' => 'Principal Amount',
            'penalty' => 'Penalty',
            'LAF' => 'Loan Adm. Fee',
            'vrf' => 'Value Retention Fee',
            'totalLoan' => 'Total Loan Amount',
            'outstandingDebt' => 'Outstanding Debt',
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
    public function getLoanRepaymentItem() {
        return $this->hasOne(\backend\modules\repayment\models\LoanRepaymentItem::className(), ['loan_repayment_item_id' => 'loan_repayment_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepayment() {
        return $this->hasOne(LoanRepayment::className(), ['loan_repayment_id' => 'loan_repayment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSummary() {
        return $this->hasOne(LoanSummary::className(), ['loan_summary_id' => 'loan_summary_id']);
    }

    public function insertAllPaymentsofAllLoaneesUnderBill($loan_summary_id, $loan_repayment_id) {
        $details_applicant = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST'")->all();
        $si = 0;
        $moder = new EmployedBeneficiary();
        /*
          $details_MLREB = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='MLREB'")->one();
          $MLREB=$details_MLREB->percent;
         */
        $details_MLREB = $moder->getEmployedBeneficiaryPaymentSetting();
        $MLREB = $details_MLREB->rate;
        /*
          $details_PNT = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
          $PNT_V=$details_PNT->percent;
         */
        $details_PNT = $moder->getPNTsetting();
        $PNT_V = $details_PNT->rate;
        /*
          $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
          $VRF_V=$details_VRF->percent;
         */

        $details_VRF = $moder->getVRFsetting();
        $VRF_V = $details_VRF->rate;

        //$loan_repayment_item_id=$details_MLREB->loan_repayment_item_id;
        foreach ($details_applicant as $value_applicant) {
            $applicantID = $value_applicant->applicant_id;
            $amount1 = $MLREB * $value_applicant->basic_salary;
            $totalOutstandingAmount = $moder->getIndividualEmployeeTotalLoan($applicantID);
            if ($totalOutstandingAmount >= $amount1) {
                $amount = $amount1;
            } else {
                $amount = $amount1 - $totalOutstandingAmount;
            }
            $CalculatedBasicSalaryCode = "CFBS";
            $CFBS_id = $moder->getloanRepaymentItemID($CalculatedBasicSalaryCode);
            Yii::$app->db->createCommand()
                    ->insert('loan_repayment_detail', [
                        'loan_repayment_id' => $loan_repayment_id,
                        'applicant_id' => $applicantID,
                        'loan_repayment_item_id' => $CFBS_id,
                        'amount' => $amount,
                        'loan_summary_id' => $loan_summary_id,
                    ])->execute();
            ++$si;
        }

        foreach ($details_applicant as $paymentCalculation) {
            $applicantID = $paymentCalculation->applicant_id;
            $amount1 = $MLREB * $paymentCalculation->basic_salary;
            $totalOutstandingAmount = $moder->getIndividualEmployeeTotalLoan($applicantID);
            if ($totalOutstandingAmount >= $amount1) {
                $amount = $amount1;
            } else {
                $amount = $amount1 - $totalOutstandingAmount;
            }

            $vrf = $moder->getIndividualEmployeesVRF($applicantID);
            $itemCodeVRF = "VRF";
            $vrf_id = $moder->getloanRepaymentItemID($itemCodeVRF);
            $LAF = $moder->getIndividualEmployeesLAF($applicantID);
            $itemCodeLAF = "LAF";
            $LAF_id = $moder->getloanRepaymentItemID($itemCodeLAF);
            $penalty = $moder->getIndividualEmployeesPenalty($applicantID);
            $itemCodePNT = "PNT";
            $PNT_id = $moder->getloanRepaymentItemID($itemCodePNT);
            $itemCodePRC = "PRC";
            $PRC_id = $moder->getloanRepaymentItemID($itemCodePRC);

            $outstandingPrincipalLoan = $moder->getOutstandingPrincipalLoan($applicantID);
            //-----------here for LAF portion----
            if ($LAF > $amount) {
                $LAF_v = $amount;
                $amount_remained = 0;
            } else {
                $LAF_v = $LAF;
                $amount_remained = $amount - $LAF_v;
            }
            Yii::$app->db->createCommand()
                    ->insert('loan_repayment_detail', [
                        'loan_repayment_id' => $loan_repayment_id,
                        'applicant_id' => $applicantID,
                        'loan_repayment_item_id' => $LAF_id,
                        'amount' => $LAF_v,
                        'loan_summary_id' => $loan_summary_id,
                    ])->execute();
            //-----------------END FOR LAF----        
            //----here for penalty portion----
            $penalty_v = $amount_remained * $PNT_V;
            if ($penalty >= $penalty_v) {
                $penalty_v = $penalty_v;
            } else if ($penalty < $penalty_v) {
                $penalty_v = $penalty;
            } else {
                $penalty_v = 0;
            }
            $amount_remained1 = $amount_remained - $penalty_v;

            Yii::$app->db->createCommand()
                    ->insert('loan_repayment_detail', [
                        'loan_repayment_id' => $loan_repayment_id,
                        'applicant_id' => $applicantID,
                        'loan_repayment_item_id' => $PNT_id,
                        'amount' => $penalty_v,
                        'loan_summary_id' => $loan_summary_id,
                    ])->execute();
            //---end for penalty----
            //-----here for VRF portion----
            if ($outstandingPrincipalLoan > 0) {
                $vrf_portion = $amount_remained1 * $VRF_V;
                if ($vrf >= $vrf_portion) {
                    $vrfTopay = $vrf_portion;
                    $amount_remained2 = $amount_remained1 - $vrfTopay;
                } else {
                    $vrfTopay = $vrf;
                    $amount_remained2 = $amount_remained1 - $vrfTopay;
                }
            } else {
                if ($vrf >= $amount_remained1) {
                    $vrfTopay = $amount_remained1;
                    $amount_remained2 = 0;
                } else {
                    $vrfTopay = $vrf;
                    $amount_remained2 = 0;
                }
            }
            Yii::$app->db->createCommand()
                    ->insert('loan_repayment_detail', [
                        'loan_repayment_id' => $loan_repayment_id,
                        'applicant_id' => $applicantID,
                        'loan_repayment_item_id' => $vrf_id,
                        'amount' => $vrfTopay,
                        'loan_summary_id' => $loan_summary_id,
                    ])->execute();
            //-----END for VRF---
            //--------------here for principal portion---
            Yii::$app->db->createCommand()
                    ->insert('loan_repayment_detail', [
                        'loan_repayment_id' => $loan_repayment_id,
                        'applicant_id' => $applicantID,
                        'loan_repayment_item_id' => $PRC_id,
                        'amount' => $amount_remained2,
                        'loan_summary_id' => $loan_summary_id,
                    ])->execute();
            //---end---
        }
    }

    public function getAmountRequiredForPaymentIndividualLoanee($applicantID, $loan_repayment_id) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                        . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $amount = $details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
    }

    public function getAmountTotalPaidunderBill($LoanSummaryID) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail RIGHT JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE  loan_repayment_detail.loan_summary_id='$LoanSummaryID' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id' AND loan_repayment.payment_status='1'")->one();
        $amount = $details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
    }

    public function getAmountTotalPaidunderBillIndividualEmployee($LoanSummaryID, $applicantID) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                        . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_summary_id='$LoanSummaryID' AND loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $amount = $details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
    }

    public function getItemsPaidAmountInBill($applicantID, $loan_summary_id, $itemID, $loan_given_to) {
        $results = LoanRepaymentDetail::findBySql("SELECT b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $itemID . "' AND D.payment_status='1' AND b.loan_given_to='$loan_given_to' group by b.loan_summary_id")->one();
        return $results;
    }

    public static function getAmountTotalPaidLoanee($applicantID) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $results = LoanRepaymentDetail::findBySql("SELECT b.loan_repayment_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment A ON A.loan_repayment_id = b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_repayment_item_id<>'" . $CFBS_id . "' AND A.payment_status='1'")->one();
        $amount_paid = $results->amount;
        $value = (count($amount_paid) == 0) ? '0' : $amount_paid;
        return $value;
    }

    public static function getAmountTotalPaidLoaneeUnderLoanSummary($applicantID, $loan_summary_id) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $results = LoanRepaymentDetail::findBySql("SELECT b.loan_repayment_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment A ON A.loan_repayment_id = b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_repayment_item_id<>'" . $CFBS_id . "' AND A.payment_status='1' AND b.loan_summary_id='$loan_summary_id'")->one();
        $amount_paid = $results->amount;
        $value = (count($amount_paid) == 0) ? '0' : $amount_paid;
        return $value;
    }

    public static function getAmountTotalPaidLoaneeUnderLoanSummaryEmployerOnly($applicantID, $loan_summary_id) {
        $moder = new EmployedBeneficiary();
        $CFBS = "CFBS";
        $CFBS_id = $moder->getloanRepaymentItemID($CFBS);
        $results = LoanRepaymentDetail::findBySql("SELECT b.loan_repayment_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment A ON A.loan_repayment_id = b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_repayment_item_id<>'" . $CFBS_id . "' AND A.payment_status='1' AND b.loan_summary_id='$loan_summary_id' AND A.applicant_id IS NULL")->one();
        $amount_paid = $results->amount;
        $value = (count($amount_paid) == 0) ? '0' : $amount_paid;
        return $value;
    }

    public function getPrincipalLoanPaidPerBill($applicantID, $loan_repayment_id) {
        $details_amount = $this->findBySql("SELECT loan_repayment_detail.amount AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='PRC' AND loan_repayment.payment_status='1'")->one();
        $principal = $details_amount->amount;

        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
    }

    public function getPenaltyLoanPaidPerBill($applicantID, $loan_repayment_id) {
        $details_penalty = $this->findBySql("SELECT loan_repayment_detail.amount AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='PNT' AND loan_repayment.payment_status='1'")->one();
        $penalty = $details_penalty->amount;

        $value2 = (count($penalty) == 0) ? '0' : $penalty;
        return $value2;
    }

    public function getLAFLoanPaidPerBill($applicantID, $loan_repayment_id) {
        $details_LAF = $this->findBySql("SELECT loan_repayment_detail.amount AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='LAF' AND loan_repayment.payment_status='1'")->one();
        $LAF = $details_LAF->amount;

        $value2 = (count($LAF) == 0) ? '0' : $LAF;
        return $value2;
    }

    public function getVRFLoanPaidPerBill($applicantID, $loan_repayment_id) {
        $details_VRF = $this->findBySql("SELECT loan_repayment_detail.amount AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='VRF' AND loan_repayment.payment_status='1'")->one();
        $VRF = $details_VRF->amount;

        $value2 = (count($VRF) == 0) ? '0' : $VRF;
        return $value2;
    }

    public static function getBeneficiaryRepayment($applicantID) {
        return self::findBySql("SELECT loan_repayment_detail.amount,loan_repayment_detail.loan_repayment_item_id,loan_repayment_detail.vrf_accumulated,loan_repayment_detail.loan_summary_id,loan_repayment_detail.treasury_payment_id,employer_id,bill_number,control_number,receipt_number,receipt_date,payment_status FROM loan_repayment_detail INNER JOIN  loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE applicant_id='$applicantID' AND loan_repayment.payment_status=1 ORDER BY loan_repayment_detail_id ASC")->one();
    }

    public static function getBeneficiaryRepaymentByDate($applicantID, $date, $loan_given_to) {
        $date = date("Y-m-d 23:59:59", strtotime($date));
        return self::findBySql("SELECT loan_repayment_detail.amount,loan_repayment_detail.loan_repayment_item_id,loan_repayment_detail.vrf_accumulated,loan_repayment_detail.loan_summary_id,loan_repayment_detail.treasury_payment_id,loan_repayment.employer_id,loan_repayment.bill_number,loan_repayment.control_number,loan_repayment.receipt_number,loan_repayment.receipt_date,loan_repayment.payment_status FROM loan_repayment_detail INNER JOIN  loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment.payment_status=1 AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.receipt_date <='" . $date . "' ORDER BY loan_repayment_detail_id ASC")->one();
    }

    /*
     * checks if the beneficiary has repayment
     */

    public static function beneficiaryRepaymentExistByDate($applicantID, $date, $loan_given_to) {
        $date = date("Y-m-d 23:59:59", strtotime($date));
        $sql = "SELECT loan_repayment_detail.amount,loan_repayment_detail.loan_repayment_item_id,
                loan_repayment_detail.vrf_accumulated,
                loan_repayment_detail.loan_summary_id,
                loan_repayment_detail.treasury_payment_id,loan_repayment.employer_id,
                loan_repayment.bill_number,loan_repayment.control_number,
                loan_repayment.receipt_number,loan_repayment.receipt_date,
                loan_repayment.payment_status FROM loan_repayment_detail 
                INNER JOIN  loan_repayment 
                ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id
                WHERE loan_repayment_detail.applicant_id='$applicantID' 
                AND loan_repayment.payment_status=1 
                AND loan_repayment_detail.loan_given_to='$loan_given_to' 
                AND loan_repayment.receipt_date <='" . $date . "'
                ORDER BY loan_repayment_detail_id ASC";
        return self::findBySql($sql)->exists();
    }

    public static function getPaidItemUnderActiveLoanSummaryPerBeneficiary($applicantID, $loanSummaryID, $itemCode_id) {
        return self::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount FROM loan_repayment_detail INNER JOIN  loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_repayment_detail.loan_summary_id WHERE applicant_id='$applicantID' AND loan_repayment.payment_status=1 AND loan_repayment_detail.loan_summary_id='$loanSummaryID' AND loan_repayment_detail.loan_repayment_item_id='$itemCode_id' ORDER BY loan_repayment_detail_id ASC")->one();
    }

    public static function getLastBeneficiaryRepaymentByDate($applicantID, $date) {
        return self::findBySql("SELECT loan_repayment_detail.amount,loan_repayment_detail.loan_repayment_item_id,loan_repayment_detail.vrf_accumulated,loan_repayment_detail.loan_summary_id,loan_repayment_detail.treasury_payment_id,loan_repayment.employer_id,loan_repayment.bill_number,loan_repayment.control_number,loan_repayment.receipt_number,loan_repayment.receipt_date,loan_repayment.payment_status FROM loan_repayment_detail INNER JOIN  loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment.payment_status=1 AND loan_repayment.receipt_date <='" . $date . "' ORDER BY loan_repayment_detail_id DESC")->one();
    }

    public static function getBeneficiariesOnRepaymentWithinDateRange($startDate, $endDate) {
        $startDate = date("Y-m-d 23:59:59", strtotime($startDate));
        $endDate = date("Y-m-d 23:59:59", strtotime($endDate));
        return self::findBySql("SELECT loan_repayment_detail.amount,loan_repayment_detail.loan_repayment_item_id,loan_repayment_detail.vrf_accumulated,loan_repayment_detail.loan_summary_id,loan_repayment_detail.treasury_payment_id,loan_repayment.employer_id,loan_repayment.control_number,loan_repayment.receipt_number,loan_repayment.receipt_date,loan_repayment.payment_status,loan_repayment_detail.applicant_id FROM loan_repayment_detail INNER JOIN  loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE loan_repayment.payment_status=1 AND loan_repayment.receipt_date >='" . $startDate . "' AND loan_repayment.receipt_date <='" . $endDate . "' GROUP BY loan_repayment_detail.applicant_id  ORDER BY loan_repayment_detail.loan_repayment_detail_id ASC")->all();
    }

    function getLoanType() {
        switch ($this->loan_given_to) {
            case 1:
                return 'Direct Beneficiary';

                break;
            case 2:
                return 'Through Employer';

                break;

            default:
                return NULL;
                break;
        }
    }

}
