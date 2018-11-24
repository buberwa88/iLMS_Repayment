<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
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
class LoanRepaymentDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
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
	public $amount1;
	public $f4indexno;
	public $principal;
    public $penalty;
    public $LAF;
    public $vrf;
    public $totalLoan;
    public $outstandingDebt;
    public function rules()
    {
        return [
            [['loan_repayment_id', 'applicant_id', 'loan_summary_id'], 'required'],
            [['loan_repayment_id', 'applicant_id', 'loan_repayment_item_id', 'loan_summary_id'], 'integer'],
            [['applicantName','totalLoanees','firstname','middlename','surname', 'amount','totalAmount','amount1','f4indexno','principal','penalty','LAF','vrf','totalLoan','outstandingDebt'], 'safe'],
            [['amount'], 'number','on' => 'adjustAmount'],
			[['amount'], 'required', 'on' => 'adjustAmount'],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['loan_repayment_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\LoanRepaymentItem::className(), 'targetAttribute' => ['loan_repayment_item_id' => 'loan_repayment_item_id']],
            [['loan_repayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanRepayment::className(), 'targetAttribute' => ['loan_repayment_id' => 'loan_repayment_id']],
            [['loan_summary_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSummary::className(), 'targetAttribute' => ['loan_summary_id' => 'loan_summary_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_repayment_detail_id' => 'Loan Repayment Batch Detail ID',
            'loan_repayment_id' => 'Loan Repayment Batch ID',
            'applicant_id' => 'Applicant ID',
            'loan_repayment_item_id' => 'Loan Repayment Item ID',
            'amount' => 'Amount(TZS)',
            'loan_summary_id' => 'Loan Repayment Bill ID',
            'applicantName'=>'Full Name',
            'totalLoanees'=>'Total Employees',
            'firstname'=>'First Name',
            'middlename'=>'Middle Name',
            'surname'=>'Surname',
            'totalAmount'=>'Total Amount(TZS)',
			'amount1'=>'Amount(TZS)',
			'principal'=>'Principal Amount',
            'penalty'=>'Penalty',
            'LAF'=>'Loan Adm. Fee',
            'vrf'=>'Value Retention Fee',
            'totalLoan'=>'Total Loan Amount',
            'outstandingDebt'=>'Outstanding Debt',
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
    public function getLoanRepaymentItem()
    {
        return $this->hasOne(\backend\modules\repayment\models\LoanRepaymentItem::className(), ['loan_repayment_item_id' => 'loan_repayment_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepayment()
    {
        return $this->hasOne(LoanRepayment::className(), ['loan_repayment_id' => 'loan_repayment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSummary()
    {
        return $this->hasOne(LoanSummary::className(), ['loan_summary_id' => 'loan_summary_id']);
    }
    public function insertAllPaymentsofAllLoaneesUnderBill($loan_summary_id,$loan_repayment_id){
        $details_applicant = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST'")->all();
        $si=0;
        $moder=new EmployedBeneficiary();
		$MLREB=$moder->getEmployedBeneficiaryPaymentSetting();
		
		$details_PNT=$moder->getPNTsetting();
		$PNT_V=$details_PNT->percent; 
		
        $details_VRF=$moder->getVRFsetting();
        $VRF_V=$details_VRF->percent;
		
		/*
        foreach ($details_applicant as $value_applicant) { 
        $applicantID=$value_applicant->applicant_id;
        $amount1=$MLREB*$value_applicant->basic_salary;
        $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
        if($totalOutstandingAmount >= $amount1){
          $amount=$amount1;  
        }else{
          //$amount=$amount1-$totalOutstandingAmount;
          $amount=$totalOutstandingAmount;		  
        }
        $CalculatedBasicSalaryCode="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CalculatedBasicSalaryCode);
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$CFBS_id,
        'amount' =>$amount,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        ++$si;
        }
		*/
        
        foreach ($details_applicant as $paymentCalculation) { 
           $applicantID=$paymentCalculation->applicant_id;
           $amount1=$MLREB*$paymentCalculation->basic_salary;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
           if($totalOutstandingAmount >= $amount1){
              $amount=$amount1;  
           }else{
              $amount=$amount1-$totalOutstandingAmount;  
           }
           
           $vrf=$moder->getIndividualEmployeesVRFUnderBill($applicantID,$loan_summary_id);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAFUnderBill($applicantID,$loan_summary_id);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenaltyUnderBill($applicantID,$loan_summary_id);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
           $itemCodePRC="PRC";
           $PRC_id=$moder->getloanRepaymentItemID($itemCodePRC);
           
           $outstandingPrincipalLoan=$moder->getOutstandingPrincipalLoanUnderBill($applicantID,$loan_summary_id);
        //-----------here for LAF portion----
           if($LAF > $amount){
            $LAF_v = $amount;
            $amount_remained=0;
           }else{
             $LAF_v=$LAF; 
             $amount_remained=$amount-$LAF_v;
           }
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'amount' =>$LAF_v,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //-----------------END FOR LAF----        
        //----here for penalty portion----
            $penalty_v = $amount_remained * $PNT_V;
            if($penalty >= $penalty_v){
             $penalty_v=$penalty_v;   
            }else if($penalty < $penalty_v){
             $penalty_v=$penalty;   
            }else{
             $penalty_v=0;   
            }
            $amount_remained1=$amount_remained-$penalty_v;
           
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'amount' =>$penalty_v,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //---end for penalty----
        //-----here for VRF portion----
        if($outstandingPrincipalLoan > 0){
         $vrf_portion=$amount_remained1 * $VRF_V; 
         if($vrf >=$vrf_portion){
         $vrfTopay=$vrf_portion; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }         
        }else{
            if($vrf >=$amount_remained1){
         $vrfTopay=$amount_remained1;
         $amount_remained2=0; 
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=0;
         }
        }
        //check if principal amount exceed
        if($outstandingPrincipalLoan >= $amount_remained2){
        $amount_remained2=$amount_remained2;    
        }else if($outstandingPrincipalLoan < $amount_remained2 && $outstandingPrincipalLoan >'0'){
        $amount_remained2=$outstandingPrincipalLoan;    
        }else{
        $amount_remained2='0';    
        }
        // end check principle amount exceed
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'amount' =>$vrfTopay,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //-----END for VRF---
        //--------------here for principal portion---
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PRC_id,
        'amount' =>$amount_remained2,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //---end---
        }
        }
		
		
	public function updateNewAmountOnAdjustmentOfPaymentEmployedBeneficiary($loan_summary_id,$loan_repayment_id,$amounUpdated,$applicantID){
        $details_applicant = $this->findBySql("SELECT * FROM loan_repayment_detail WHERE  loan_summary_id='$loan_summary_id' AND applicant_id='$applicantID'")->all();
        $si=0;
        $moder=new EmployedBeneficiary();
		$MLREB=$moder->getEmployedBeneficiaryPaymentSetting();
		
		$details_PNT=$moder->getPNTsetting();
		$PNT_V=$details_PNT->percent; 
		
        $details_VRF=$moder->getVRFsetting();
        $VRF_V=$details_VRF->percent;
        
        foreach ($details_applicant as $paymentCalculation) { 
           //$applicantID=$paymentCalculation->applicant_id;
           $amount1=$amounUpdated;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
           if($totalOutstandingAmount >= $amount1){
              $amount=$amount1;  
           }else{
              //$amount=$amount1-$totalOutstandingAmount;
              $amount=$totalOutstandingAmount;			  
           }
           
           $vrf=$moder->getIndividualEmployeesVRFUnderBill($applicantID,$loan_summary_id);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAFUnderBill($applicantID,$loan_summary_id);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenaltyUnderBill($applicantID,$loan_summary_id);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
           $itemCodePRC="PRC";
           $PRC_id=$moder->getloanRepaymentItemID($itemCodePRC);
           
           $outstandingPrincipalLoan=$moder->getOutstandingPrincipalLoanUnderBill($applicantID,$loan_summary_id);
        //-----------here for LAF portion----
           if($LAF > $amount){
            $LAF_v = $amount;
            $amount_remained=0;
           }else{
             $LAF_v=$LAF; 
             $amount_remained=$amount-$LAF_v;
           }		
		$this->updateAll(['amount'=>$LAF_v], 'loan_repayment_id ="'.$loan_repayment_id.'" AND applicant_id="'.$applicantID.'" AND loan_repayment_item_id="'.$LAF_id.'"');		
        //-----------------END FOR LAF----        
        //----here for penalty portion----
            $penalty_v = $amount_remained * $PNT_V;
            if($penalty >= $penalty_v){
             $penalty_v=$penalty_v;   
            }else if($penalty < $penalty_v){
             $penalty_v=$penalty;   
            }else{
             $penalty_v=0;   
            }
            $amount_remained1=$amount_remained-$penalty_v;
           
		$this->updateAll(['amount'=>$penalty_v], 'loan_repayment_id ="'.$loan_repayment_id.'" AND applicant_id="'.$applicantID.'" AND loan_repayment_item_id="'.$PNT_id.'"');
        //---end for penalty----
        //-----here for VRF portion----
        if($outstandingPrincipalLoan > 0){
         $vrf_portion=$amount_remained1 * $VRF_V; 
         if($vrf >=$vrf_portion){
         $vrfTopay=$vrf_portion; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }         
        }else{
            if($vrf >=$amount_remained1){
         $vrfTopay=$amount_remained1;
         $amount_remained2=0; 
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=0;
         }
        }
        //check if principal amount exceed
        if($outstandingPrincipalLoan >= $amount_remained2){
        $amount_remained2=$amount_remained2;    
        }else if($outstandingPrincipalLoan < $amount_remained2 && $outstandingPrincipalLoan >'0'){
        $amount_remained2=$outstandingPrincipalLoan;    
        }else{
        $amount_remained2='0';    
        }
        // end check principle amount exceed
		
		$this->updateAll(['amount'=>$vrfTopay], 'loan_repayment_id ="'.$loan_repayment_id.'" AND applicant_id="'.$applicantID.'" AND loan_repayment_item_id="'.$vrf_id.'"');
        //-----END for VRF---
        //--------------here for principal portion---		
		$this->updateAll(['amount'=>$amount_remained2], 'loan_repayment_id ="'.$loan_repayment_id.'" AND applicant_id="'.$applicantID.'" AND loan_repayment_item_id="'.$PRC_id.'"');
        //---end---
        }
        }	
		
        
    public function insertAllPaymentsofAllLoaneesUnderBillSelfEmployedBeneficiary($loan_summary_id,$loan_repayment_id,$applicantID){
        $details_applicant = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST'")->all();
        $si=0;
        $moder=new EmployedBeneficiary();
		/*
        $details_MLREB = LoanRepaymentSetting::findBySql("SELECT percent,loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='MLRSB'")->one();
        $Amount=$details_MLREB->percent;
		*/
		$Amount=$moder->getNonEmployedBeneficiaryPaymentSetting();
        /*
        $details_PNT = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
        $PNT_V=$details_PNT->percent;
        
        $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
        $VRF_V=$details_VRF->percent;
		*/
		$details_PNT=$moder->getPNTsetting();
		$PNT_V=$details_PNT->percent; 
		
        $details_VRF=$moder->getVRFsetting();
        $VRF_V=$details_VRF->percent;
        
        //$loan_repayment_item_id=$details_MLREB->loan_repayment_item_id;
        //foreach ($details_applicant as $value_applicant) { 
        $amount1=$Amount;
        $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
        if($totalOutstandingAmount >= $amount1){
          $amount=$amount1;  
        }else{
          $amount=$amount1-$totalOutstandingAmount;  
        }
        $CalculatedBasicSalaryCode="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CalculatedBasicSalaryCode);
		/*
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$CFBS_id,
        'amount' =>$amount,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
		*/
        ++$si;
        //}
        
        //foreach ($details_applicant as $paymentCalculation) { 
           $amount1=$amount;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
           if($totalOutstandingAmount >= $amount1){
              $amount=$amount1;  
           }else{
              $amount=$amount1-$totalOutstandingAmount;  
           }
           
           $vrf=$moder->getIndividualEmployeesVRFUnderBill($applicantID,$loan_summary_id);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAFUnderBill($applicantID,$loan_summary_id);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenaltyUnderBill($applicantID,$loan_summary_id);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
           $itemCodePRC="PRC";
           $PRC_id=$moder->getloanRepaymentItemID($itemCodePRC);
           
           $outstandingPrincipalLoan=$moder->getOutstandingPrincipalLoanUnderBill($applicantID,$loan_summary_id);
        //-----------here for LAF portion----
           if($LAF > $amount){
            $LAF_v = $amount;
            $amount_remained=0;
           }else{
             $LAF_v=$LAF; 
             $amount_remained=$amount-$LAF_v;
           }
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'amount' =>$LAF_v,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //-----------------END FOR LAF----        
        //----here for penalty portion----
            $penalty_v = $amount_remained * $PNT_V;
            if($penalty >= $penalty_v){
             $penalty_v=$penalty_v;   
            }else if($penalty < $penalty_v){
             $penalty_v=$penalty;   
            }else{
             $penalty_v=0;   
            }
            $amount_remained1=$amount_remained-$penalty_v;
           
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'amount' =>$penalty_v,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //---end for penalty----
        //-----here for VRF portion----
        if($outstandingPrincipalLoan > 0){
         $vrf_portion=$amount_remained1 * $VRF_V; 
         if($vrf >=$vrf_portion){
         $vrfTopay=$vrf_portion; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }         
        }else{
            if($vrf >=$amount_remained1){
         $vrfTopay=$amount_remained1;
         $amount_remained2=0; 
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=0;
         }
        }
        //check if principal amount exceed
        if($outstandingPrincipalLoan >= $amount_remained2){
        $amount_remained2=$amount_remained2;    
        }else if($outstandingPrincipalLoan < $amount_remained2 && $outstandingPrincipalLoan >'0'){
        $amount_remained2=$outstandingPrincipalLoan;    
        }else{
        $amount_remained2='0';    
        }
        // end check principle amount exceed
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'amount' =>$vrfTopay,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //-----END for VRF---
        //--------------here for principal portion---
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PRC_id,
        'amount' =>$amount_remained2,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //---end---
        //}
        }    
        
        public function updateLoaneeWhenAdjustedPaymentAmount($totalAmount1,$loan_repayment_id,$applicantID){
        $si=0;
        $moder=new EmployedBeneficiary(); 
        /*		
        $details_PNT = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
        $PNT_V=$details_PNT->percent;
        
        $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
        $VRF_V=$details_VRF->percent;
		*/
		$details_PNT=$moder->getPNTsetting();
		$PNT_V=$details_PNT->percent; 
		
		//$details_LAF=$this->getLAFsetting();
		//$LAF=$details_LAF->percent; 
		
        $details_VRF=$moder->getVRFsetting();
        $VRF_V=$details_VRF->percent;
        
        //$loan_repayment_item_id=$details_MLREB->loan_repayment_item_id;
        //foreach ($details_applicant as $value_applicant) { 
        $amount1=$totalAmount1;
        $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
        if($totalOutstandingAmount >= $amount1){
          $amount=$amount1;  
        }else{
          $amount=$amount1-$totalOutstandingAmount;  
        }
        $CalculatedBasicSalaryCode="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CalculatedBasicSalaryCode);
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$CFBS_id,
        'amount' =>$amount,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        ++$si;
        //}
        
        //foreach ($details_applicant as $paymentCalculation) { 
           $amount1=$amount;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
           if($totalOutstandingAmount >= $amount1){
              $amount=$amount1;  
           }else{
              $amount=$amount1-$totalOutstandingAmount;  
           }
           
           $vrf=$moder->getIndividualEmployeesVRFUnderBill($applicantID,$loan_summary_id);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAFUnderBill($applicantID,$loan_summary_id);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenaltyUnderBill($applicantID,$loan_summary_id);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
           $itemCodePRC="PRC";
           $PRC_id=$moder->getloanRepaymentItemID($itemCodePRC);
           
           $outstandingPrincipalLoan=$moder->getOutstandingPrincipalLoanUnderBill($applicantID,$loan_summary_id);
        //-----------here for LAF portion----
           if($LAF > $amount){
            $LAF_v = $amount;
            $amount_remained=0;
           }else{
             $LAF_v=$LAF; 
             $amount_remained=$amount-$LAF_v;
           }
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'amount' =>$LAF_v,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //-----------------END FOR LAF----        
        //----here for penalty portion----
            $penalty_v = $amount_remained * $PNT_V;
            if($penalty >= $penalty_v){
             $penalty_v=$penalty_v;   
            }else if($penalty < $penalty_v){
             $penalty_v=$penalty;   
            }else{
             $penalty_v=0;   
            }
            $amount_remained1=$amount_remained-$penalty_v;
           
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'amount' =>$penalty_v,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //---end for penalty----
        //-----here for VRF portion----
        if($outstandingPrincipalLoan > 0){
         $vrf_portion=$amount_remained1 * $VRF_V; 
         if($vrf >=$vrf_portion){
         $vrfTopay=$vrf_portion; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=$amount_remained1-$vrfTopay;
         }         
        }else{
            if($vrf >=$amount_remained1){
         $vrfTopay=$amount_remained1;
         $amount_remained2=0; 
         }else{
         $vrfTopay=$vrf; 
         $amount_remained2=0;
         }
        }
        //check if principal amount exceed
        if($outstandingPrincipalLoan >= $amount_remained2){
        $amount_remained2=$amount_remained2;    
        }else if($outstandingPrincipalLoan < $amount_remained2 && $outstandingPrincipalLoan >'0'){
        $amount_remained2=$outstandingPrincipalLoan;    
        }else{
        $amount_remained2='0';    
        }
        // end check principle amount exceed
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'amount' =>$vrfTopay,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //-----END for VRF---
        //--------------here for principal portion---
        Yii::$app->db->createCommand()
        ->insert('loan_repayment_detail', [
        'loan_repayment_id' =>$loan_repayment_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PRC_id,
        'amount' =>$amount_remained2,
        'loan_summary_id' =>$loan_summary_id,    
        ])->execute();
        //---end---
        //}
        }
        
    public function getAmountRequiredForPaymentIndividualLoanee($applicantID,$loan_repayment_id){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
       $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
    public function getAmountTotalPaidunderBill($LoanSummaryID){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
       $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                . "FROM loan_repayment_detail RIGHT JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE  loan_repayment_detail.loan_summary_id='$LoanSummaryID' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id' AND loan_repayment.payment_status='1'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
    public function getAmountTotalPaidunderBillIndividualEmployee($LoanSummaryID,$applicantID){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
       $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_summary_id='$LoanSummaryID' AND loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
    public static function getAmountTotalPaidLoanee($applicantID){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
        $results = LoanRepaymentDetail::findBySql("SELECT b.loan_repayment_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment A ON A.loan_repayment_id = b.loan_repayment_id "
                . "WHERE b.applicant_id='$applicantID' AND b.loan_repayment_item_id<>'".$CFBS_id."' AND A.payment_status='1'")->one();
        $amount_paid=$results->amount;
        $value = (count($amount_paid) == 0) ? '0' : $amount_paid;
        return $value;
        }
		public static function getPrincipalLoanPaidPerBill($applicantID,$loan_repayment_id){
        $details_amount = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.amount AS amount "
                . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='PRC' AND loan_repayment.payment_status='1'")->one();
        $principal=$details_amount->amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
    public static function getPenaltyLoanPaidPerBill($applicantID,$loan_repayment_id){
        $details_penalty = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.amount AS amount "
                . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='PNT' AND loan_repayment.payment_status='1'")->one();
        $penalty=$details_penalty->amount;
         
        $value2 = (count($penalty) == 0) ? '0' : $penalty;
        return $value2;
        }
    public static function getLAFLoanPaidPerBill($applicantID,$loan_repayment_id){
        $details_LAF = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.amount AS amount "
                . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='LAF' AND loan_repayment.payment_status='1'")->one();
        $LAF=$details_LAF->amount;
         
        $value2 = (count($LAF) == 0) ? '0' : $LAF;
        return $value2;
        } 
    public static function getVRFLoanPaidPerBill($applicantID,$loan_repayment_id){
        $details_VRF = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.amount AS amount "
                . "FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_item.item_code='VRF' AND loan_repayment.payment_status='1'")->one();
        $VRF=$details_VRF->amount;
         
        $value2 = (count($VRF) == 0) ? '0' : $VRF;
        return $value2;
        }    
}
