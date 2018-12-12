<?php

namespace backend\modules\repayment\models;

use Yii;
//use yii\web\UploadedFile;
use frontend\modules\application\models\Applicant;
//use frontend\modules\application\models\User;
use \common\models\User;
use \common\models\LoanBeneficiary;
//use backend\modules\allocation\models\AcademicYear;
use \common\models\AcademicYear;
use backend\modules\disbursement\models\Disbursement;
use backend\modules\repayment\models\LoanRepaymentSetting;
use backend\modules\repayment\models\LoanRepaymentItem;
use backend\modules\repayment\models\LoanRepaymentDetail;
use backend\modules\application\models\Application;
use backend\modules\repayment\models\LoanSummaryDetail;
use backend\modules\repayment\models\LoanSummary;
use backend\models\SystemSetting;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\repayment\models\EmployerPenaltyCycle;

/**
 * This is the model class for table "employed_beneficiary".
 *
 * @property integer $employed_beneficiary_id
 * @property integer $employer_id
 * @property string $employee_id
 * @property integer $applicant_id
 * @property double $basic_salary
 * @property string $employment_status
 * @property string $created_at
 * @property integer $created_by
 *
 * @property Applicant $applicant
 * @property Employer $employer
 * @property User $createdBy
 */
class EmployedBeneficiary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employed_beneficiary';
    }

    /**
     * @inheritdoc
     */
        public $imageFile;
	    public $file;
        public $employee_check_number;
        public $employee_f4indexno;
        public $employee_firstname;
        public $employee_mobile_phone_no;
        public $employee_year_completion_studies;
        public $employee_academic_awarded;
        public $employee_instituitions_studies;
        public $employee_NIN;
        public $employee_current_nameifchanged;
        public $principal;
		public $penalty;
		public $LAF;
		public $VRF;
		public $totalLoan;
		public $paid;
		public $outstanding;
        public $totalLoanees;
		public $region;
	    public $district;
		//public $firstname;
		//public $middlename;
		//public $surname;
		public $employerName;
		public $f4indexno2;
                public $employer_code;
    public function rules()
    {
        return [
            [['employee_check_number','employee_f4indexno', 'employee_firstname', 'employee_mobile_phone_no','employee_NIN','basic_salary'], 'required', 'on'=>'Uploding_employed_beneficiaries'],
            [['f4indexno2'], 'required', 'on'=>'update_employee'],
            [['support_document'], 'required', 'on'=>'deactivate_double_employed'],
            [['employee_status'], 'required', 'on'=>'employee_status_update'],
            [['support_document'], 'file', 'extensions'=>['pdf']],
            [['employer_id', 'applicant_id', 'created_by', 'employee_mobile_phone_no','loan_summary_id'], 'integer'],
			[['firstname', 'middlename', 'surname'], 'match','not' => true,'pattern' => '/[^a-zA-Z_-]/','message' => 'Only Characters  Are Allowed...'],
            ['employee_mobile_phone_no', 'string', 'length' => [10, 12]],
            [['basic_salary','phone_number'], 'number'],
			['phone_number', 'string', 'length' => [0, 12]],
            [['employment_status'], 'string'],
            [['employer_id', 'employee_id', 'applicant_id', 'employment_status', 'created_at', 'created_by', 'created_at',
                'employee_current_nameifchanged','NID','f4indexno','firstname','phone_number','loan_summary_id', 'principal', 'totalLoanees','verification_status','firstname','middlename','surname','employerName','learning_institution_id','place_of_birth','principal','penalty','LAF','VRF','totalLoan','paid','outstanding','f4indexno2','confirmed','mult_employed','support_document','employee_status','vote_number'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls','on'=>'Uploding_employed_beneficiaries'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls','on'=>'uploaded_files_employees'],
            [['employee_id'], 'string', 'max' => 20],
            /*
			['file', 'file','on'=>'uploaded_files_aggregates',
                                            'types'=>'csv',
                                            'maxSize'=>1024 * 1024 * 10, // 10MB
                                            'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
                                            'allowEmpty' => false
                              ],
             * 
             */
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['loan_summary_id'], 'exist', 'skipOnError' => true, 'targetClass' =>LoanSummary::className(), 'targetAttribute' => ['loan_summary_id' => 'loan_summary_id']],
			[['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
			[['place_of_birth'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['place_of_birth' => 'ward_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employed_beneficiary_id' => 'Employed Beneficiary ID',
            'employer_id' => 'Employer ID',
            'employee_id' => 'Employee ID',
            'applicant_id' => 'Applicant ID',
            'basic_salary' => 'Gross Salary',
            'employment_status' => 'Employment Status',
            'created_at' => 'Created On',
            'created_by' => 'Created By',
            'employee_check_number'=>'employee_check_number',
            'employee_f4indexno'=>'Form IV Index No.',
            'employee_firstname'=>'Employee Name',
            'employee_mobile_phone_no'=>'Employee mobile phone No.',
            'employee_year_completion_studies'=>'Employee year of completion studies',
            'employee_academic_awarded'=>'Employee academic award',
            'employee_instituitions_studies'=>'Employee instituitions studies',
            'employee_NIN'=>'National Identification No.',
            'employee_check_number'=>'Check Number',
            'NID'=>'National Identification Number',
            'f4indexno'=>'Form IV Index Number',
	    'f4indexno2'=>'Form IV Index Number',
            'firstname'=>'Full Name',
            'phone_number'=>'Phone Number',
            'loan_summary_id'=>'Loan Repayment Bill ID',
            'principal'=>'Principle',
            'totalLoanees'=>'Total Loanees',
            'verification_status'=>'Verification Status',
	    'firstname'=>'First Name',
	    'middlename'=>'Middle Name',
	    'surname'=>'Last name',
			'employerName'=>'Employer Name',
			'place_of_birth'=>'Ward',
			'district'=>'District',
			'learning_institution_id'=>'Learning Institution',
			'sex'=>'Gender',
			'region'=>'Region',
			'principal'=>'Principal',
			'penalty'=>'Penalty',
			'LAF'=>'LAF',
			'VRF'=>'VRF',
			'totalLoan'=>'Total Loan',
			'paid'=>'Paid',
			'outstanding'=>'Outstanding Loan',
            'support_document'=>'Support Document',
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
    public function getLoanSummary()
    {
        return $this->hasOne(LoanSummary::className(), ['loan_summary_id' => 'loan_summary_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }
	/**
     * @return \yii\db\ActiveQuery
     */
	public function getWard() {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'place_of_birth']);
    }
    
    
    public function upload($date_time)
    {
        if ($this->validate()) {
            //$date_time=date("Y_m_d_H_i_s");
            $this->imageFile->saveAs('uploads/' . $date_time.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            $this->imageFile->saveAs('uploads/' . $date_time.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return false;
        }
    }
    public function getindexNoApplicant($applcantF4IndexNo){
        $details = \frontend\modules\application\models\Applicant::find()
                            ->where(['f4indexno'=>$applcantF4IndexNo])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
        return $details;
        }

    public function getEmployeeUserId($applicantId){
        $details_employee_userId = \frontend\modules\application\models\Applicant::find()
                            ->where(['applicant_id'=>$applicantId])
                            //->orderBy('applicant_id DESC')
                            ->limit(1)->one();
        return $details_employee_userId;
        } 
        public function getUserPhone($user_id){
        $details_employee_phone = User::find()
                            ->where(['user_id'=>$user_id])
                            //->orderBy('applicant_id DESC')
                            ->limit(1)->one();
        return $details_employee_phone;
        } 
    public function updateUserPhone($phoneNumber,$user_id){
        User::updateAll(['phone_number' =>$phoneNumber ], 'user_id ="'.$user_id.'"');
 }
 
    public function updateEmployeeNane($current_name,$applicant_id,$NIN){
        Applicant::updateAll(['current_name' =>$current_name,'NID'=>$NIN], 'applicant_id ="'.$applicant_id.'"');
 }
 
    public function updateBeneficiary($checkIsmoney,$employeeExistsId){
        $this->updateAll(['basic_salary' =>$checkIsmoney], 'employed_beneficiary_id ="'.$employeeExistsId.'"');
 }
    public function checkEmployeeExists($applicantId,$employerId,$employeeId){
        $details_employee_existance = $this->find()
                            ->where(['applicant_id'=>$applicantId,'employer_id'=>$employerId,'employee_id'=>$employeeId])
                            ->orderBy('employed_beneficiary_id DESC')
                            ->limit(1)->one();
        return $details_employee_existance;
        }
    public function checkEmployeeExistsNonApplicant($f4indexno,$employerId,$employeeId){
        $employee_existance_nonApplicant = $this->find()
                            ->where(['f4indexno'=>$f4indexno,'employer_id'=>$employerId,'employee_id'=>$employeeId])
                            ->orderBy('employed_beneficiary_id DESC')
                            ->limit(1)->one();
        return $employee_existance_nonApplicant;
        }
    public static function getstartToEndAcademicYrOfBeneficiary($applicantID,$filter){
		$details_academicY =\common\models\LoanBeneficiary::getAcademicYear($applicantID,$filter);
        $academicYid=$details_academicY->disbursementBatch->academic_year_id;
        //$LastacademicYear=$details_academicY->academic_year;
		$LastacademicYear=$details_academicY->disbursementBatch->academicYear->academic_year;
        $value_academicY = (count($academicYid) == 0) ? '0' : $LastacademicYear;
        return $value_academicY;
        }
    public static function getExplodeAcademicYear($academicYear){
        if($academicYear !='0'){
         $YearV=explode("/",$academicYear);
         $Year_V1=$YearV[1]; 
         $Year_V2=$YearV[0];
         $lastV2=strlen($Year_V1);
         if($lastV2==2){
         $starting=substr($Year_V2,0,2);
         $Year=$starting.$Year_V1;
         }else{
         $Year=$Year_V1;   
         }
        }else{
         $Year=0;   
        }
        return $Year;
        }
    public function updateBeneficiaryNonApplicant($checkIsmoney,$results_nonApplicantFound,$f4indexno,$firstname,$phone_number,$NID){
        $this->updateAll(['basic_salary' =>$checkIsmoney,'f4indexno'=>$f4indexno,'firstname'=>$firstname,'phone_number'=>$phone_number,'NID'=>$NID], 'employed_beneficiary_id ="'.$results_nonApplicantFound.'"');
 }
    public static function getIndividualEmployeesPrincipalLoan($applicantID){	
				
		$details_disbursedAmount=\common\models\LoanBeneficiary::getPrincipleNoReturn($applicantID);			
        $principal=$details_disbursedAmount->disbursed_amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
    public static function getIndividualEmployeesPenalty($applicantID,$date){
		//---checking grace period---
		$dateGraduated=\common\models\LoanBeneficiary::getGraduationDate($applicantID);		
        $todateTNew1=strtotime($date);
		$periodPendingUnpaid=round(($todateTNew1-strtotime($dateGraduated))/(60*60*24));
		$gracePeriod=EmployedBeneficiary::getGracePeriodSetting($dateGraduated);
		//---end for grace period----
		if($gracePeriod >=$periodPendingUnpaid){
		$penalty_to_pay=0;	
		}else{
        	$details_pnt=EmployedBeneficiary::getPNTsetting();
		$PNT=$details_pnt->rate;
        $loan_repayment_item_id=$details_pnt->loan_repayment_item_id;
        ////////////
		$details_disbursedAmount=\common\models\LoanBeneficiary::getTotalLoanNoReturn($applicantID,$PNT);
        $penalty_to_pay=$details_disbursedAmount->disbursed_amount;
        if($penalty_to_pay < 0){
		$penalty_to_pay=0;	
		}	
		}
		/////////////
        return $penalty_to_pay;
        }
		
        public static function getIndividualEmployeePaidPrincipalLoan($applicantID){
        $principleCode="PRC";
        $PRC_id=EmployedBeneficiary::getloanRepaymentItemID($principleCode);
        $details_paidLoan = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$PRC_id' AND loan_repayment_detail.applicant_id='$applicantID'")->one();
        $paidAmount=$details_paidLoan->amount;
         
        $value = (count($paidAmount) == 0) ? '0' : $paidAmount;
        return $value;
        }
        public static function getIndividualEmployeesLAF($applicantID){
		  $details_LAF=EmployedBeneficiary::getLAFsetting();
          $LAF=$details_LAF->rate;
		  $details_disbursedAmount=\common\models\LoanBeneficiary::getTotalLoanNoReturn($applicantID,$LAF);				
        $LAF_to_pay=$details_disbursedAmount->disbursed_amount;        
         if($LAF_to_pay < 0){
		 $LAF_to_pay=0;
		 }
        return $LAF_to_pay;
        //return $value_LAF;
        }
		public static function getVRFapplicantLoanTrhoughEmployer($applicantID){
		  $details_VRF=EmployedBeneficiary::getVRFsettingApplicantThroughEmployer();
          $VRF_rate=$details_VRF->rate;
   $details_disbursedAmount=\common\models\LoanBeneficiary::getTotalLoanNoReturnGivenThroughEmployer($applicantID,$VRF_rate);				
        $VRF_to_pay=$details_disbursedAmount->disbursed_amount;        
         if($VRF_to_pay < 0){
		 $VRF_to_pay=0;
		 }
        return $VRF_to_pay;
        //return $value_LAF;
        }
		
        
    public static function getOutstandingPrincipalLoan($applicantID){
        $OutstandingAmount=EmployedBeneficiary::getIndividualEmployeesPrincipalLoan($applicantID)-EmployedBeneficiary::getIndividualEmployeePaidPrincipalLoan($applicantID);
        //$OutstandingAmount=$this->getIndividualEmployeesPrincipalLoan($applicantID);
        $value = (count($OutstandingAmount) == 0) ? '0' : $OutstandingAmount;
        return $value;
        }
        
    public static function getIndividualEmployeesVRF($applicantID,$date){
		//CALCULATE VRF BEFORE ANY REPAYMENT
	//Get Disbursement per beneficiary
	  $numberOfDaysPerYear=\backend\modules\repayment\models\EmployedBeneficiary::getTotaDaysPerYearSetting();
	  $pricipalLoan1qaws=\common\models\LoanBeneficiary::getAmountNoReturned($applicantID);
	  ///looiping among all the disbursed_amount
	   
	      foreach ($pricipalLoan1qaws as $resultsApp) {
					$pricipalLoan=$resultsApp->disbursed_amount;
					                    $academicYearEndate=$resultsApp->disbursementBatch->academicYear->end_date;
                                        $dateLoanDisbursed=date("Y-m-d",strtotime($resultsApp->status_date)); 
                                        $formula_stage_level=\common\models\LoanBeneficiary::getVrFBeforeRepayment($dateLoanDisbursed);
                                        //var_dump($formula_stage_level);
                                        $VRF_Rate=$formula_stage_level->rate;
					     			switch($formula_stage_level->formula_stage_level){
										case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DISBUSRMENT:
										 //formula_stage_level==1 for From Disbursement date
                                        $totalNumberOfDays=round(($date-strtotime($dateLoanDisbursed))/(60*60*24));
										break;
																		
										case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DUE_LOAN:
										//formula_stage_level==2 for Due Loan 
                                            //here for after graduation
											switch($formula_stage_level->formula_stage_level){
												case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DUE_LOAN_AFTER_GRADUATION:
												$dateGraduated=\common\models\LoanBeneficiary::getGraduationDate($applicantID) ;
                                            //---checking grace period---
                                                   
                                                    $periodPendingUnpaid=round(($date-strtotime($dateGraduated))/(60*60*24));
                                                    if(($periodPendingUnpaid-$formula_stage_level->grace_period) > 0){
                                                    $totalNumberOfDays=$periodPendingUnpaid-$formula_stage_level->grace_period;
                                                    }else{
                                                      $totalNumberOfDays=0;              
                                                    }
												break;
												
												case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DUE_LOAN_AFTER_ACADEMIC_YEAR:
												 // here for after academic year 
                                                   if((round(($date-strtotime($academicYearEndate))/(60*60*24))) > 0){
                                                    $totalNumberOfDays=round(($date-strtotime($academicYearEndate))/(60*60*24));   
                                                    }else{
                                                     $totalNumberOfDays=0;   
                                                     }
												break;
												
											}
																					
										break;
										
									}
									$item_fomula=$formula_stage_level->item_formula;  //=PRC*R*T
									
                                 $totlaVRF +=($pricipalLoan*$VRF_Rate*$totalNumberOfDays)/$numberOfDaysPerYear;
                    }
					if($totlaVRF < 0){
		$totlaVRF=0;	
		}
return 	$totlaVRF;				
		}
        
    public static function getIndividualEmployeeTotalLoan($applicantID){
        $totalLoan=EmployedBeneficiary::getIndividualEmployeesPrincipalLoan($applicantID) + EmployedBeneficiary::getIndividualEmployeesPenalty($applicantID) + EmployedBeneficiary::getIndividualEmployeesLAF($applicantID) + EmployedBeneficiary::getIndividualEmployeesVRF($applicantID);
        
        $value_totalLoan = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value_totalLoan;
        }
    public function getAllEmployeesUnderBillunderEmployer($employerID){
        $details_count = $this->findBySql("SELECT COUNT(employed_beneficiary_id) AS 'totalLoanees' FROM employed_beneficiary WHERE  employed_beneficiary.employer_id='$employerID'  AND employed_beneficiary.applicant_id IS NOT NULL  AND employed_beneficiary.employment_status='ONPOST' AND employed_beneficiary.verification_status='1'")->one();
        $totalLoanees=$details_count->totalLoanees;
   
        $value = (count($totalLoanees) == 0) ? '0' : $totalLoanees;
        return $value;
        }
        
    public static function getTotalLoanInBill($employerID){
        $LoanSummaryDetails=new LoanSummaryDetail();
        $totalBillAmount=$LoanSummaryDetails->getTotalBillAmount($employerID);
        $value = (count($totalBillAmount) == '0') ? '0' : $totalBillAmount;
        return $value;
        }
    public static function getTotalLoanInBillAfterDecease($employerID){
        $LoanSummaryDetails=new LoanSummaryDetail();
        $totalBillAmount=$LoanSummaryDetails->getTotalBillAmountForDeceased($employerID);
        $value = (count($totalBillAmount) == '0') ? '0' : $totalBillAmount;
        return $value;
        }    
    public function getTotalLoanInBillLoanee($applicantID){
        $LoanSummaryDetails=new LoanSummaryDetail();
        $totalBillAmount=$LoanSummaryDetails->getTotalBillAmountLoanee($applicantID);
        $value = (count($totalBillAmount) == '0') ? '0' : $totalBillAmount;
        return $value;
        }
    public static function getloanRepaymentItemID($itemCode){
        $details_item = LoanRepaymentItem::findBySql("SELECT loan_repayment_item_id FROM loan_repayment_item WHERE  loan_repayment_item.item_code='$itemCode'")->one();
        $details_v=$details_item->loan_repayment_item_id; 
        $value = (count($details_v) == 0) ? '0' : $details_v;
        return $value;
        }
    public function getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID){
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM(disbursed_amount) AS disbursed_amount "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID' AND application.academic_year_id='$academicYearID'")->one();
        $principal=$details_disbursedAmount->disbursed_amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
    public function verifyEmployees($employerID){
        $this->updateAll(['verification_status' =>'1'], 'employer_id ="'.$employerID.'" AND (applicant_id IS NOT NULL OR applicant_id >=1) AND verification_status<>"1"');
 }
 
    public function verifyEmployeesInBulk($employed_beneficiary_id){
        $this->updateAll(['verification_status' =>'3'], '(employer_id  IS NOT NULL OR employer_id >=1) AND (applicant_id IS NOT NULL OR applicant_id >=1) AND verification_status<>"1" AND employed_beneficiary_id="'.$employed_beneficiary_id.'"');
 }
    public function submitEmployeesInBulk(){
        $this->updateAll(['verification_status' =>'1'], 'verification_status="3"');
 }
    public static function getIndividualEmployeePaidVRF($applicantID){
        $principleCode="VRF";
        $VRF_id=EmployedBeneficiary::getloanRepaymentItemID($principleCode);
        $details_paidVRF = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$VRF_id' AND loan_repayment_detail.applicant_id='$applicantID'")->one();
        $paidAmount=$details_paidVRF->amount;
         
        $value = (count($paidAmount) == 0) ? '0' : $paidAmount;
        return $value;
        }
    public function getEmployerFromSubmittedBeneficiaries(){
        $LoanSummaryModel = new LoanSummary();
        $checkBeneficiary = $this->findBySql("SELECT * FROM employed_beneficiary  WHERE  employed_beneficiary.verification_status='3' GROUP BY employer_id")->all();
        foreach($checkBeneficiary as $existBeneficiary){
           $employerID=$existBeneficiary->employer_id;
           $LoanSummaryModel->ceaseBillIfNewEmployeeAdded($employerID);
        }
        } 
    public function getUnverifiedEmployees($verification_status){
        $details_count = $this->findBySql("SELECT COUNT(employed_beneficiary_id) AS 'totalLoanees' FROM employed_beneficiary WHERE  employed_beneficiary.applicant_id IS NOT NULL  AND employed_beneficiary.employment_status='ONPOST' AND employed_beneficiary.verification_status IN('$verification_status')")->one();
        $totalLoanees=$details_count->totalLoanees;
   
        $value = (count($totalLoanees) == 0) ? '0' : $totalLoanees;
        return $value;
        }
	public  static function getGracePeriodSetting($graduationDate){
	    $details_gracePeriod = SystemSetting::findBySql("SELECT setting_value FROM system_setting WHERE  setting_code='LRGPD' AND is_active='1' AND graduated_from <= '$graduationDate' AND graduated_to >= '$graduationDate'")->one();
        $gracePeriod=$details_gracePeriod->setting_value;
		return $gracePeriod;
	}    
    public static function getEmployedBeneficiaryPaymentSetting(){
	    $value = SystemSetting::findBySql("SELECT system_setting.setting_value*0.01 AS 'setting_value' FROM system_setting WHERE  setting_code='EMLRP' AND is_active='1'")->one();
        $value_v=$value->setting_value;
		return $value_v;
	}
    public static function getNonEmployedBeneficiaryPaymentSetting(){
	    $value = SystemSetting::findBySql("SELECT setting_value FROM system_setting WHERE  setting_code='SEMLRA' AND is_active='1'")->one();
        $value_v=$value->setting_value;
		return $value_v;
	}
    public static function getVRFsetting(){
	$details_VRF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='2'")->one();
    return $details_VRF;
	}
    public static function getLAFsetting(){
	$details_LAF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF' AND loan_repayment_setting.is_active='1'")->one();
    return $details_LAF;
	}
	public static function getVRFsettingApplicantThroughEmployer(){
	$details_VRF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.item_applicable_scope='EMPLOYER'")->one();
    return $details_VRF;
	}
    public static function getPNTsetting(){
	$details_PNT = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT' AND loan_repayment_setting.is_active='1'")->one();
    return $details_PNT;
	}
   public static function getBeneficiaryOutstandingLoan($applicantID){
   $outstandingLoan=EmployedBeneficiary::getIndividualEmployeeTotalLoan($applicantID) - LoanRepaymentDetail::getAmountTotalPaidLoanee($applicantID);
   return $outstandingLoan;
   }
   public function updateResubmittedBeneficiaries($employed_beneficiary_id){
        $this->updateAll(['verification_status' =>'0'], 'employed_beneficiary_id="'.$employed_beneficiary_id.'"');
 }
   public static function updateNewF4indexno($employed_beneficiary_id,$verification_status){
        EmployedBeneficiary::updateAll(['verification_status' =>$verification_status], 'employed_beneficiary_id="'.$employed_beneficiary_id.'"');
 }
   public function getApplicantID($employed_beneficiary_id){
        $results=EmployedBeneficiary::find()->where(['employed_beneficiary_id' =>$employed_beneficiary_id])->one();
		return $results;
 }
	public static function getEmployerMontlyPenaltyRate(){
	$details = EmployerPenaltyCycle::findBySql("SELECT employer_penalty_cycle.penalty_rate*0.01 AS 'penalty',employer_penalty_cycle.repayment_deadline_day AS 'payment_deadline_day_per_month',duration,duration_type,employer_penalty_cycle_id FROM employer_penalty_cycle  WHERE employer_penalty_cycle.is_active='1' AND employer_penalty_cycle.cycle_type='0'")->one();
    return $details;
	}
	public static function getEmployerPenaltyCycleUsed($penaltyCycleID){
	$details = EmployerPenaltyCycle::findBySql("SELECT employer_penalty_cycle.penalty_rate*0.01 AS 'penalty',employer_penalty_cycle.repayment_deadline_day AS 'payment_deadline_day_per_month',duration,duration_type,employer_penalty_cycle_id FROM employer_penalty_cycle  WHERE employer_penalty_cycle.employer_penalty_cycle_id='$penaltyCycleID'")->one();
    return $details;
	}
	public static function getEmployerMontlyPenaltySpecificEmployer($employerID){
	$details = EmployerPenaltyCycle::findBySql("SELECT employer_penalty_cycle.penalty_rate*0.01 AS 'penalty',employer_penalty_cycle.repayment_deadline_day AS 'payment_deadline_day_per_month',duration,duration_type,employer_penalty_cycle_id FROM employer_penalty_cycle  WHERE employer_penalty_cycle.is_active='1' AND employer_id='$employerID' AND employer_penalty_cycle.cycle_type='1'")->one();
    return $details;
	}
    public static function updateBeneficiaryFromOldEmployer($employerID,$applicantID,$newverificationStatus){
        EmployedBeneficiary::updateAll(['verification_status' =>$newverificationStatus], 'employer_id<>"'.$employerID.'" AND applicant_id="'.$applicantID.'" AND verification_status<>"'.$newverificationStatus.'" AND employment_status="ONPOST"');
 }
 public static function getTotaDaysPerYearSetting(){
	    $value = SystemSetting::findBySql("SELECT setting_value FROM system_setting WHERE  setting_code='TNDY' AND is_active='1'")->one();
        $value_v=$value->setting_value;
		return $value_v;
	}
	// this function checks all selected beneficiaries from HESLB panel
public static function getActiveNewBeneficiariesDuringLoanSummaryCreation(){
	return  self::findBySql('SELECT employed_beneficiary.employer_id,employer.employer_name,employer.employer_code  FROM employed_beneficiary INNER JOIN employer ON employer.employer_id=employed_beneficiary.employer_id WHERE employer.employer_id=employed_beneficiary.employer_id AND  employed_beneficiary.employment_status="ONPOST" AND (employed_beneficiary.loan_summary_id IS NULL OR employed_beneficiary.loan_summary_id="") AND employed_beneficiary.verification_status=1 GROUP BY employed_beneficiary.employer_id')->all();
}
	// this function checks all selected beneficiaries from HESLB panel
public static function getActiveBeneficiariesUnderEmployerDuringLoanSummaryCreation($employerID){
	return  self::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1' AND (loan_summary_id IS NULL OR loan_summary_id='')")->all();
}
public static function getIndividualLAFReprocessLoan($amount){
		  $details_LAF=EmployedBeneficiary::getLAFsetting();
          $LAF=$details_LAF->rate;				
        $LAF_to_pay=$amount*$LAF;        
         if($LAF_to_pay < 0){
		 $LAF_to_pay=0;
		 }
        return $LAF_to_pay;
        //return $value_LAF;
}
 public static function getIndividualPNTreprocessLoan($amount){
	 //NOTE: If somebody has penalty before, go straight to the calculation because this is the scenario of ON REPAYMENT
        $details_pnt=EmployedBeneficiary::getPNTsetting();
		$PNT=$details_pnt->rate;
        ////////////
        $penalty_to_pay=$amount*$PNT;
        if($penalty_to_pay < 0){
		$penalty_to_pay=0;	
		}
		/////////////
        return $penalty_to_pay;
}
public static function getIndividualVRFreprocessLoan($applicantID,$date,$amount,$statusDate,$academicYearEndate){
		//CALCULATE VRF BEFORE ANY REPAYMENT
		$date=strtotime($date);
	//Get Disbursement per beneficiary
	  $numberOfDaysPerYear=\backend\modules\repayment\models\EmployedBeneficiary::getTotaDaysPerYearSetting();
	  ///looiping among all the disbursed_amount
	   
	      //foreach ($pricipalLoan1qaws as $resultsApp) {
					$pricipalLoan=$amount;
                                        $dateLoanDisbursed=date("Y-m-d",strtotime($statusDate)); 
                                        $formula_stage_level=\common\models\LoanBeneficiary::getVrFBeforeRepayment($dateLoanDisbursed);
                                        //var_dump($formula_stage_level);
                                        $VRF_Rate=$formula_stage_level->rate;
					     			switch($formula_stage_level->formula_stage_level){
										case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DISBUSRMENT:
										 //formula_stage_level==1 for From Disbursement date
                                        $totalNumberOfDays=round(($date-strtotime($dateLoanDisbursed))/(60*60*24));
										break;
																		
										case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DUE_LOAN:
										//formula_stage_level==2 for Due Loan 
                                            //here for after graduation
											switch($formula_stage_level->formula_stage_level){
												case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DUE_LOAN_AFTER_GRADUATION:
												$dateGraduated=\common\models\LoanBeneficiary::getGraduationDate($applicantID) ;
                                            //---checking grace period---
                                                   
                                                    $periodPendingUnpaid=round(($date-strtotime($dateGraduated))/(60*60*24));
                                                    if(($periodPendingUnpaid-$formula_stage_level->grace_period) > 0){
                                                    $totalNumberOfDays=$periodPendingUnpaid-$formula_stage_level->grace_period;
                                                    }else{
                                                      $totalNumberOfDays=0;              
                                                    }
												break;
												
												case LoanRepaymentSetting::FORMULA_STAGE_LEVEL_DUE_LOAN_AFTER_ACADEMIC_YEAR:
												 // here for after academic year 
                                                   if((round(($date-strtotime($academicYearEndate))/(60*60*24))) > 0){
                                                    $totalNumberOfDays=round(($date-strtotime($academicYearEndate))/(60*60*24));   
                                                    }else{
                                                     $totalNumberOfDays=0;   
                                                     }
												break;
												
											}
																					
										break;
										
									}
									$item_fomula=$formula_stage_level->item_formula;  //=PRC*R*T
									
                                 $totlaVRF +=($pricipalLoan*$VRF_Rate*$totalNumberOfDays)/$numberOfDaysPerYear;
                    
					if($totlaVRF < 0){
		$totlaVRF=0;	
		}
return 	$totlaVRF;				
		}	
}
