<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\repayment\models\EmployedBeneficiarySearch;
use backend\modules\repayment\models\EmployerSearch;
use backend\modules\repayment\models\Employer;
use backend\modules\repayment\models\LoanSummary;
use frontend\modules\repayment\models\LoanSummaryDetail;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \common\models\LoanBeneficiary;
use \common\models\LoanBeneficiarySearch;

/**
 * EmployedBeneficiaryController implements the CRUD actions for EmployedBeneficiary model.
 */
class EmployedBeneficiaryController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public $layout="main_private";
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EmployedBeneficiary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        //echo $employer;
        //exit;
        //$employerID='2';
        $dataProvider = $searchModel->getEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAllBeneficiaries()
    {
        $searchModelLoanBeneficiary = new LoanBeneficiarySearch();
        $searchModel = new EmployedBeneficiarySearch();
		$searchModelNonBenef = new EmployedBeneficiarySearch();
        $dataProvider = $searchModel->getBeneficiaryOnly(Yii::$app->request->queryParams);
		$dataProviderNonBeneficiary = $searchModel->getNonBeneficiaryOnly(Yii::$app->request->queryParams);
		
		$dataProviderLoanBeneficiary = $searchModelLoanBeneficiary->search(Yii::$app->request->queryParams);

        return $this->render('AllBeneficiaries', [
            'searchModel' => $searchModel,
			'searchModelNonBenef'=>$searchModelNonBenef,
            'dataProvider' => $dataProvider,
			'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary,
			'searchModelLoanBeneficiary' => $searchModelLoanBeneficiary,
			'dataProviderLoanBeneficiary' => $dataProviderLoanBeneficiary,
        ]);
    }
	 public function actionRegisteredLonees()
    {
        $searchModelLoanBeneficiary = new LoanBeneficiarySearch();		
		$dataProviderLoanBeneficiary = $searchModelLoanBeneficiary->search(Yii::$app->request->queryParams);

        return $this->render('registeredLonees', [
			'searchModelLoanBeneficiary' => $searchModelLoanBeneficiary,
			'dataProviderLoanBeneficiary' => $dataProviderLoanBeneficiary,
        ]);
    }
	public function actionBeneficiariesView()
    {
        $searchModelLoanBeneficiary = new LoanBeneficiarySearch();

        return $this->render('BeneficiariesView', [
            'model'=>$searchModelLoanBeneficiary,
        ]);
    }
    public function actionNewEmployedBeneficiaries()
    {

        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $dataProvider = $searchModel->getNewEmployedBeneficiaries(Yii::$app->request->queryParams);
        $verification_status=0;
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status);
        return $this->render('newEmployedBeneficiaries', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUnverifiedEmployees' => $results,
        ]);
    }
	
	public function actionNewEmployedBeneficiariesFound()
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $employee_status=0;
        $dataProvider = $searchModel->getNewEmployedBeneficiariesFound(Yii::$app->request->queryParams,$employee_status);
        $verification_status=0;
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status);
        return $this->render('newEmployedBeneficiariesFound', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUnverifiedEmployees' => $results,
        ]);
    }
	
	public function actionNewEmployeenoloan()
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $dataProvider = $searchModel->getNewEmployedNewEmployeenoloan(Yii::$app->request->queryParams);
        $verification_status='0,4';
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status);
        return $this->render('newEmployeenoloan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUnverifiedEmployees' => $results,
        ]);
    }
	public function actionActiveEmployedBeneficiaries()
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $dataProvider = $searchModel->getActiveEmployedBeneficiaries(Yii::$app->request->queryParams);
        return $this->render('activeEmployedBeneficiaries', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionBeneficiariesSubmitted()
    {
        $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $dataProvider = $searchModel->getNewEmployedBeneficiariesWaitingSubmit(Yii::$app->request->queryParams);
        $verification_status=3;
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status);
        return $this->render('beneficiariesSubmitted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUnverifiedEmployees' => $results,
        ]);
    }
	public function actionNonFoundUploadedEmployees()
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $dataProvider = $searchModel->getNonBeneficiaryOnly(Yii::$app->request->queryParams);
        $verification_status=0;
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status);
        return $this->render('nonFoundUploadedEmployees', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUnverifiedEmployees' => $results,
        ]);
    }

    /**
     * Displays a single EmployedBeneficiary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
	//$this->layout="default_main";
	
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
		
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionUploadError()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        $model = new EmployedBeneficiary();
        return $this->render('upload_error', [
            'model' =>$model,
        ]);
    }

    /**
     * Creates a new EmployedBeneficiary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 /*
    public function actionCreate()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        $model = new EmployedBeneficiary();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employed_beneficiary_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	*/
	public function actionCreate($id=null) {
        $user_loged_in = Yii::$app->user->identity->login_type;
        $modelEmployedBeneficiary = new \frontend\modules\repayment\models\EmployedBeneficiary();
        $searchModelEmployedBeneficiarySearch = new \frontend\modules\repayment\models\EmployedBeneficiarySearch();
        $modelEmployedBeneficiary->scenario = 'additionalEmployee';
        $employerModel = new \frontend\modules\repayment\models\EmployerSearch();
        $modelEmployedBeneficiary->created_by = \Yii::$app->user->identity->user_id;
        $loggedin = $modelEmployedBeneficiary->created_by;
        $modelEmployedBeneficiary->created_at = date("Y-m-d H:i:s");
        $employerID = $id;
        $modelEmployedBeneficiary->verification_status = 0;

        if ($modelEmployedBeneficiary->load(Yii::$app->request->post()) && $modelEmployedBeneficiary->validate()) {
			//echo $modelEmployedBeneficiary->programme_level_of_study;exit;
            //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
			    $splitF4Indexno=explode('.',$modelEmployedBeneficiary->f4indexno);
				$f4indexnoSprit1=$splitF4Indexno[0];
				$f4indexnoSprit2=$splitF4Indexno[1];
				$f4indexnoSprit3=$splitF4Indexno[2];
				$regNo=$f4indexnoSprit1.".".$f4indexnoSprit2;
				$f4CompletionYear=$f4indexnoSprit3;
            $employeeID = $modelEmployedBeneficiary->getApplicantDetails($regNo,$f4CompletionYear, $modelEmployedBeneficiary->NID);
            $modelEmployedBeneficiary->applicant_id = $employeeID->applicant_id;
            // check for disbursed amount to employee
            //check using non-unique identifiers
			$startCpyear=0;
			$endCpyear=0;
			$programmeStudiedGeneral = $startCpyear.$endCpyear;
			$academicInstitutionGeneral=$startCpyear.$endCpyear;
			$studyLevelGeneral=$startCpyear.$endCpyear;
			$EntryAcademicYearGeneral=$startCpyear.$endCpyear;
			$CompletionAcademicYearGeneral=$startCpyear.$endCpyear;
            if (!is_numeric($modelEmployedBeneficiary->applicant_id) && $modelEmployedBeneficiary->applicant_id < 1 && $modelEmployedBeneficiary->applicant_id == '') {
                $resultsUsingNonUniqueIdent = $modelEmployedBeneficiary->getApplicantDetailsUsingNonUniqueIdentifiers($modelEmployedBeneficiary->firstname, $modelEmployedBeneficiary->middlename, $modelEmployedBeneficiary->surname,$academicInstitutionGeneral,$studyLevelGeneral, $programmeStudiedGeneral,$EntryAcademicYearGeneral,$CompletionAcademicYearGeneral);
                $modelEmployedBeneficiary->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
				$modelEmployedBeneficiary->upload_status=1;
				$modelEmployedBeneficiary->employment_start_date=date("Y-m-d H:i:s");
				$modelEmployedBeneficiary->confirmed=1;
            }
            // end check using unique identifiers

            if (!is_numeric($modelEmployedBeneficiary->applicant_id)) {
                $modelEmployedBeneficiary->applicant_id = '';
            }
            //$applicantId = $model->applicant_id;
            //check if employee is on study
            if ($modelEmployedBeneficiary->applicant_id != '') {
                $employeeOnstudyStatus = $modelEmployedBeneficiary->getEmployeeOnStudyStatus($modelEmployedBeneficiary->applicant_id);
                if ($employeeOnstudyStatus != '') {
                    $modelEmployedBeneficiary->employee_status = 1;
                } else {
                    $modelEmployedBeneficiary->employee_status = 0;
                }
            } else {
                $modelEmployedBeneficiary->employee_status = 0;
            }
            // check for disbursed amount to employee      
            if ($modelEmployedBeneficiary->applicant_id > 0) {
                $resultDisbursed = $modelEmployedBeneficiary->getIndividualEmployeesPrincipalLoan($modelEmployedBeneficiary->applicant_id);
                if ($resultDisbursed == 0) {
                    $modelEmployedBeneficiary->verification_status = 4;
                }
            }
            //end check
        }
        if ($modelEmployedBeneficiary->load(Yii::$app->request->post()) && $modelEmployedBeneficiary->save()) {
            $dataProvider = $searchModelEmployedBeneficiarySearch->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams, $employerID);
            $dataProviderNonBeneficiary = $searchModelEmployedBeneficiarySearch->getNonVerifiedEmployees(Yii::$app->request->queryParams, $employerID);
            $sms = "Employee Added Successful!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['employer/view','id'=>$employerID]);
        } else {
            return $this->render('create', [
                        'model' => $modelEmployedBeneficiary,'employerID'=>$employerID,
            ]);
        }
    }
    
	public function actionUploadGeneral()
        {
            $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
           $modelHeader = new EmployedBeneficiary();
	   $modelHeader->scenario = 'Uploding_employed_beneficiaries';
           $employerModel = new EmployerSearch();
           $modelHeader->created_by=\Yii::$app->user->identity->user_id;
           $loggedin=$modelHeader->created_by;
           $employer2=$employerModel->getEmployer($loggedin);
           $employerID=$employer2->employer_id;           
           if($modelHeader->load(Yii::$app->request->post()))
             {
                          $date_time=date("Y_m_d_H_i_s");
                          $inputFiles1=UploadedFile::getInstance($modelHeader, 'imageFile');
                          $modelHeader->imageFile=UploadedFile::getInstance($modelHeader, 'imageFile');
                          $modelHeader->upload($date_time);
                          $inputFiles = 'uploads/'.$date_time.$inputFiles1;
		
        try {
          $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
          $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
          $objPHPExcel = $objReader ->load($inputFiles);
        } catch (Exception $ex) {
          die('Error');
        }

        $sheet = $objPHPExcel ->getSheet(0);
        $highestRow = $sheet ->getHighestRow();
        $highestColumn = $sheet ->getHighestColumn();
 
       
        if(strcmp($highestColumn,"H")==0 && $highestRow >=4){        
                  
  $s1=1;
  
                  for ($row = 4; $row <= $highestRow; ++$row) {

          $rowData = $sheet ->rangeToArray('A'.$row. ':' .$highestColumn.$row, NULL, TRUE, FALSE);

          $modelHeader = new EmployedBeneficiary();

          $modelHeader->employer_id = $employerID;
          $modelHeader->created_by=\Yii::$app->user->identity->user_id;
          $modelHeader->employment_status = "ONPOST";
          $modelHeader->created_at = date("Y-m-d H:i:s");
          $sn = $rowData[0][0];
          $modelHeader->employee_check_number = $rowData[0][1];
          $modelHeader->employee_f4indexno = $rowData[0][2];
          $modelHeader->employee_firstname = $rowData[0][3];
          $modelHeader->employee_mobile_phone_no = $rowData[0][4];
          $modelHeader->employee_current_nameifchanged = $rowData[0][5];
          $modelHeader->employee_NIN = $rowData[0][6];
          $modelHeader->basic_salary = str_replace(",","",$rowData[0][7]);
          $checkIsmoney=$modelHeader->basic_salary;
          $applcantF4IndexNo=$modelHeader->employee_f4indexno;
          $employeeID=$modelHeader->getindexNoApplicant($applcantF4IndexNo);
          $modelHeader->applicant_id=$employeeID->applicant_id;
          $modelHeader->employee_id=$modelHeader->employee_check_number;
          if(!is_numeric($modelHeader->applicant_id)){
             $modelHeader->applicant_id='';              
          }
          if(!is_numeric($modelHeader->created_by)){
            $modelHeader->created_by=0;
          }
          $applicantId=$modelHeader->applicant_id;
          $employerId=$modelHeader->employer_id;
          $employeeId=$modelHeader->employee_id;
          $f4indexno=$modelHeader->employee_f4indexno;
          $nameChanged=trim($modelHeader->employee_current_nameifchanged);
          if($nameChanged=='' OR empty($nameChanged)){
            $firstname=$modelHeader->employee_firstname;  
          }else{
            $firstname=$modelHeader->employee_current_nameifchanged;  
          }
          $phone_number=$modelHeader->employee_mobile_phone_no;
          $NID=$modelHeader->employee_NIN;
          
          if($sn !='' AND (!is_numeric($checkIsmoney) OR $modelHeader->employee_f4indexno=='' OR $modelHeader->employee_check_number=='' OR $modelHeader->employee_firstname=='' OR
                  $modelHeader->employee_mobile_phone_no=='' OR $modelHeader->employee_NIN=='')){
				  unlink('uploads/'.$date_time.$inputFiles1);
           $sms = '<p>Operation did not complete, Please check the information in the excel you are trying to upload.'
                   . '<br/><i>The following columns are compulsory.</i>'
                   . '<ul><li>CHECK NUMBER</li><li>FORM FOUR INDEX NUMBER</li><li>FULL NAME</li>'
                   . '<li>MOBILE PHONE NUMBER</li><li>NATIONAL IDENTIFICATION NUMBER(NIN)</li>'
                   . '<li>BASIC SALARY(TZS)</li></ul></p>';
                   //Yii::$app->session->setFlash('sms', $sms);
                   //$sms="Information Updated Successful!";
                   Yii::$app->getSession()->setFlash('error', $sms);
                   return $this->redirect(['upload-error']);
          }
          /*
          if($sn !='' AND ($modelHeader->applicant_id=='' OR $modelHeader->applicant_id==0)){
		  unlink('uploads/'.$date_time.$inputFiles1);
           $sms = '<p>Operation did not complete, Employee of form four index number, <i><strong>'.$applcantF4IndexNo."</strong></i> ".'not found.</p>';
                   //Yii::$app->session->setFlash('sms', $sms);
                   Yii::$app->getSession()->setFlash('error', $sms);
                   return $this->redirect(['upload-error']);
          }
           * 
           */
          if($sn !='' AND ($modelHeader->created_by=='' OR $modelHeader->created_by==0)){
		  unlink('uploads/'.$date_time.$inputFiles1);
           $sms = '<p>Operation did not complete,session expired </p>';
                   //Yii::$app->session->setFlash('sms', $sms);
                   Yii::$app->getSession()->setFlash('error', $sms);
                   return $this->redirect(['upload-error']);
          }
          if($sn ==''){
		  unlink('uploads/'.$date_time.$inputFiles1);
           $sms = '<p>Operation failed, file with no records is not allowed</p>';
                   //Yii::$app->session->setFlash('sms', $sms);
                   Yii::$app->getSession()->setFlash('error', $sms);
                   return $this->redirect(['upload-error']);
          }
          
          // check if beneficiary exists and save
          $employeeExist=$modelHeader->checkEmployeeExists($applicantId,$employerId,$employeeId);
          $employeeExistsId=$employeeExist->employed_beneficiary_id;
          if($employeeExistsId >=1){
           $eployee_exists_status=1;   
          }else{
           $eployee_exists_status=0;
           //check if nonApplicant exists in beneficiary table
          $nonApplicantFound=$modelHeader->checkEmployeeExistsNonApplicant($f4indexno,$employerId,$employeeId);
          $results_nonApplicantFound=$nonApplicantFound->employed_beneficiary_id;        
          if($results_nonApplicantFound >=1){
           $eployee_exists_nonApplicant=1;   
          }else{
           $eployee_exists_nonApplicant=0;   
          }
          //end check if nonApplicant Exists 
          }          
          
          if($applicantId==''){
              $modelHeader->NID=$modelHeader->employee_NIN;
              $modelHeader->f4indexno=$modelHeader->employee_f4indexno;
              if($modelHeader->employee_current_nameifchanged !=''){
              $modelHeader->firstname=$modelHeader->employee_current_nameifchanged;
              }else{
              $modelHeader->firstname=$modelHeader->employee_firstname;    
              }
              $modelHeader->phone_number=$modelHeader->employee_mobile_phone_no;
          }
          
          if($sn !='' && $eployee_exists_status==0 && $eployee_exists_nonApplicant==0){
          if($modelHeader->validate()){          
          $modelHeader->save();
                  }
          }else if($sn !='' && $eployee_exists_status==1){
            $modelHeader->updateBeneficiary($checkIsmoney,$employeeExistsId);
          }else if($sn !='' && $eployee_exists_status==0 && $eployee_exists_nonApplicant==1){
           $modelHeader->updateBeneficiaryNonApplicant($checkIsmoney,$results_nonApplicantFound,$f4indexno,$firstname,$phone_number,$NID); 
          }
          //end check for beneficiary existance
          //update contact and current name of applicant
          if($applicantId >=1){
              $employeeID=$modelHeader->getEmployeeUserId($applicantId);
              $user_id=$employeeID->user_id;
              $phoneNumber=$modelHeader->employee_mobile_phone_no;
              $modelHeader->updateUserPhone($phoneNumber,$user_id);
              $modelHeader->getindexNoApplicant($applcantF4IndexNo);
              $current_name=$modelHeader->employee_current_nameifchanged;
              $applicant_id=$applicantId;
              $NIN=$modelHeader->employee_NIN;
              $modelHeader->updateEmployeeNane($current_name,$applicant_id,$NIN);
          }
          //end update applicant's contact and current name
        } 
        unlink('uploads/'.$date_time.$inputFiles1);
        $sms = '<p>Information Successful Uploaded.</p>';

                   //Yii::$app->session->setFlash('sms', $sms);
                   Yii::$app->getSession()->setFlash('success', $sms);
             }else{
               //$sms = '<p style="color: #cc0000">Operation failed, Please check excel colums.</p>';
                 unlink('uploads/'.$date_time.$inputFiles1);
               $sms = '<p>Operation failed, Please check excel colums.</p>';
                   Yii::$app->session->setFlash('error', $sms);  
             }
                   

             }  
 
          return $this->render("upload_general", ['model'=>$modelHeader]);
        }
	
     

    /**
     * Updates an existing EmployedBeneficiary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	    //$this->layout="default_main";
		
        $model = $this->findModel($id);
        $model->scenario = 'update_employee';
		//$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
        $modelLoanBeneficiary = new LoanBeneficiary();
		$NIN='';
		$applcantF4IndexNo=$model->f4indexno2;
		$model->f4indexno=$model->f4indexno2;
		$employeeID=\frontend\modules\repayment\models\EmployedBeneficiary::getApplicantDetails($applcantF4IndexNo,$NIN);
		$model->applicant_id=$employeeID->applicant_id;
		
        
        if ($model->save()) {
		   if($model->applicant_id !=''){
		   
		    // check for disbursed amount to employee
							if($model->applicant_id > 0){
							$resultDisbursed=\frontend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesPrincipalLoan($model->applicant_id);
							if($resultDisbursed ==0){
							$verification_status=4;
							EmployedBeneficiary::updateNewF4indexno($model->employed_beneficiary_id,$verification_status);
							}
							}
			//end check
		   
            $sms="Information Updated Successful!";
			Yii::$app->getSession()->setFlash('success', $sms);
			}else{
			$sms="Operation failed, form IV index number is invalid";
			Yii::$app->getSession()->setFlash('error', $sms);
			}            
            return $this->redirect(['employed-beneficiary/non-found-uploaded-employees']);
        } }else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionDownload() {
        //$path = Yii::getAlias('@webroot') . '/dwload';
        $file = Yii::$app->params['employeeExcelTemplate'] . '/EMPLOYEES_DETAILS_TEMPLATE.xlsx';
		//echo Yii::$app->params['employeeExcelTemplate'];exit;
        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$file} is not found!");
        }
    }

    /**
     * Deletes an existing EmployedBeneficiary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
public function actionList_beneficiaries($id) {
        $count_beneficiaries=EmployedBeneficiary::find()->where(['employer_id'=>$id])->count();
        $beneficiaries=EmployedBeneficiary::find()->where(['employer_id'=>$id])->orderBy('employed_beneficiary_id DESC')->all();
        if($count_beneficiaries > 0){
            foreach($beneficiaries as $results) echo "<option value='".$results->employed_beneficiary_id."'>".$results->employee_id."</option>";            
        }else{
            echo "<option>--</option>";
        }
    }
    /**
     * Finds the EmployedBeneficiary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployedBeneficiary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployedBeneficiary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionBeneficiaries($employerID)
    {
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $dataProvider = $searchModel->getEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'employerID'=>$employerID,
        ]);
    }
	public function actionBeneficiariesUnderEmployer($employerID)
    {
	    $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $dataProvider = $searchModel->getEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);

        return $this->render('beneficiariesUnderEmployer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'employerID'=>$employerID,
        ]);
    }
	public function actionNonBeneficiaryUnderemployer($employerID)
    {
	    $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $dataProvider = $searchModel->getNonBeneficiaryUnderEmployer(Yii::$app->request->queryParams,$employerID);

        return $this->render('nonBeneficiaryUnderemployer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'employerID'=>$employerID,
        ]);
    }
    
    public function actionBeneficiariesVerified($employerID)
    {
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneficiary = new EmployedBeneficiary();
        $employedBeneficiary->verifyEmployees($employerID);
        $dataProvider = $searchModel->getEmployeesUnderEmployerVerified(Yii::$app->request->queryParams,$employerID);

        return $this->render('beneficiaries_verified', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'employerID'=>$employerID,
        ]);
    }
    
    public function actionVerifyBeneficiariesInBulk()
    {
	    $this->layout="default_main";
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneficiary = new EmployedBeneficiary();
		//$action=Yii::$app->request->post('action');
		$selection=(array)Yii::$app->request->post('selection');//typecasting
		$doubleEmployed=0;
		foreach($selection as $employed_beneficiary_id){
        //$employedBeneficiary->verifyEmployeesInBulk($employed_beneficiary_id);
        $employedBeneficiaryVerify=EmployedBeneficiary::findOne(['employed_beneficiary_id'=>$employed_beneficiary_id]);                   
                   //$employedBeneficiaryVerify->verification_status='3';
                   $employedBeneficiaryVerify->verification_status='1';
				// here for logs
                        $old_data=\yii\helpers\Json::encode($employedBeneficiaryVerify->oldAttributes);
			    //end for logs
        $employedBeneficiaryDetails2=EmployedBeneficiary::findOne(['applicant_id'=>$employedBeneficiaryVerify->applicant_id,'mult_employed'=>1,'confirmed'=>1])-count();                
                        if($employedBeneficiaryDetails2 =='0'){
                   $employedBeneficiaryVerify->save();
						}else{
							++$doubleEmployed;
						}				   
		         // here for logs                        					
						$new_data=\yii\helpers\Json::encode($employedBeneficiaryVerify->attributes);
						$model_logs=\common\models\base\Logs::CreateLogall($employedBeneficiaryVerify->employed_beneficiary_id,$old_data,$new_data,"employed_beneficiary","UPDATE",1);
				//end for logs
        }		
        $verification_status=3;
        $results=$employedBeneficiary->getUnverifiedEmployees($verification_status);
        $dataProvider = $searchModel->getNewEmployedBeneficiariesWaitingSubmit(Yii::$app->request->queryParams);
        //if($employedBeneficiary->verifyEmployeesInBulk()){
		if($employed_beneficiary_id !=''){
			                        
                        //CREATE LOAN SUMMARY
    $employeesLoanSummary = \backend\modules\repayment\models\EmployedBeneficiary::getActiveNewBeneficiariesDuringLoanSummaryCreation();
    foreach($employeesLoanSummary AS $employeesLoanSumResults){        
        $employer_id=$employeesLoanSumResults->employer_id;
        $LoanSummaryModel=new LoanSummary();
        $LoanSummaryDetailModel = new \backend\modules\repayment\models\LoanSummaryDetail();
        //$resultsEmployer=$LoanSummaryModel->getEmployerDetails($employer_id);
        $billNumber=$employeesLoanSumResults->employer_code."-".date("Y")."-".$LoanSummaryModel->getLastBillID($employer_id);
        $tracedBy=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;
		$billNote='';
        
        
        $LoanSummaryModel->amount = '0';
        $LoanSummaryModel->created_by=Yii::$app->user->identity->user_id;
        $LoanSummaryModel->created_at=date("Y-m-d H:i:s");
        $employerID=$LoanSummaryModel->employer_id;
        $LoanSummaryModel->vrf_accumulated=0.00;
        $LoanSummaryModel->vrf_last_date_calculated=$LoanSummaryModel->created_at;
        $LoanSummaryModel->employer_id=$employer_id;
        $LoanSummaryModel->reference_number=$billNumber;
        $LoanSummaryModel->description=$billNote;
        $LoanSummaryModel->traced_by="Employer Submission";  
        //check if employer has a loan_summary and it is on payment
        $employeesLoanSummaryExist = \backend\modules\repayment\models\LoanSummary::findBySql('SELECT loan_summary_detail.loan_summary_id  FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE loan_summary.employer_id="'.$employer_id.'" AND (loan_summary.status=1 OR loan_summary.status=0) AND loan_summary_detail.loan_given_to="'.$loan_given_to.'" ORDER BY loan_summary.loan_summary_id DESC')->one();
        //end check
        if(count($employeesLoanSummaryExist)==0){
          $LoanSummaryModel->save(); 
          
        $loan_summary_id=$LoanSummaryModel->loan_summary_id;            
        $LoanSummaryDetailModel->insertAllBeneficiariesUnderBill($employer_id,$loan_summary_id);
        $LoanSummaryModel->updateCeasedBill($employer_id);
        }else{
        $loan_summary_id=$employeesLoanSummaryExist->loan_summary_id;            
        $LoanSummaryDetailModel->insertAllBeneficiariesUnderBill($employer_id,$loan_summary_id);        
        $LoanSummaryModel->updateCeasedBill($employer_id);
        }
		
     $totalAmount=\backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountForLoanSummary($loan_summary_id,$loan_given_to);
     \backend\modules\repayment\models\LoanSummary::updateNewTotalAmountLoanSummary($loan_summary_id,$totalAmount); 
    }   
	        if($doubleEmployed==0){
                        //END CREATE LOAN SUMMARY                          
		        $sms="Beneficiaries submitted!";
			Yii::$app->getSession()->setFlash('success', $sms);
			}else{
			$sms="Error: Some Beneficiaries won't be submitted because they are in double employment status!";
			Yii::$app->getSession()->setFlash('warning', $sms);	
			}
			}
			if($employed_beneficiary_id ==''){
		   $sms=" Error: No any beneficiary selected!";
		   Yii::$app->getSession()->setFlash('error', $sms);
		   }
		return $this->redirect(['new-employed-beneficiaries-found']);
    }

    public function actionBulkBeneficiariesSubmited()
    {
	
		
		$searchModel = new EmployedBeneficiarySearch();
		$searchModelNonBenef = new EmployedBeneficiarySearch();
		$employedBeneficiary = new EmployedBeneficiary();
		$employedBeneficiary->submitEmployeesInBulk();
        $dataProvider = $searchModel->getBeneficiaryOnly(Yii::$app->request->queryParams);
		$dataProviderNonBeneficiary = $searchModel->getNonBeneficiaryOnly(Yii::$app->request->queryParams);

        return $this->render('AllBeneficiaries', [
            'searchModel' => $searchModel,
			'searchModelNonBenef'=>$searchModelNonBenef,
            'dataProvider' => $dataProvider,
			'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary,
        ]);
		
		
		
    }

	public function actionEmployerWaitingLoanSummary()
    {
        $searchModel = new EmployedBeneficiarySearch();
        $dataProvider = $searchModel->getEmployersWaitingBill(Yii::$app->request->queryParams);
        return $this->render('employerWaitingLoanSummary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /*
    public function actionEmployerWaitingBill()
    {        
        return $this->render('employerWaitingBill');
    }
	*/
	public function actionLoanSummaryRequestsList()
    {        
        return $this->render('loanSummaryRequestsList');
    }
	public function actionResubmitBeneficiary()
    {
	    $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneficiary = new EmployedBeneficiary();
		//$action=Yii::$app->request->post('action');
		$selection=(array)Yii::$app->request->post('selection');//typecasting
		foreach($selection as $employed_beneficiary_id){
        $employedBeneficiary->updateResubmittedBeneficiaries($employed_beneficiary_id); 
        }		
        //$verification_status=3;
        //$results=$employedBeneficiary->getUnverifiedEmployees($verification_status);
        //$dataProvider = $searchModel->getNewEmployedBeneficiariesWaitingSubmit(Yii::$app->request->queryParams);
        //if($employedBeneficiary->verifyEmployeesInBulk()){
		if($employed_beneficiary_id !=''){
		    $sms="Beneficiaries Re-submitted!";
			Yii::$app->getSession()->setFlash('success', $sms);
			}
			if($employed_beneficiary_id ==''){
		   $sms=" Error: No any beneficiary selected!";
		   Yii::$app->getSession()->setFlash('error', $sms);
		   }
		return $this->redirect(['beneficiaries-submitted']);
    } 

    public function actionConfirmedEmployeesbeneficiaries()
    {
	    $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneficiary = new EmployedBeneficiary();
		$selection=(array)Yii::$app->request->post('selection');
		foreach($selection as $employed_beneficiary_id){
		
		if($employed_beneficiary_id > 0){
		$resultsapplicantid=$employedBeneficiary->getApplicantID($employed_beneficiary_id);
		$applicantID=$resultsapplicantid->applicant_id;
		$resultDisbursed=\frontend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesPrincipalLoan($applicantID);
							if($resultDisbursed ==0){
							$sms=" Error: Please confirm if employee is beneficiary";
		                    Yii::$app->getSession()->setFlash('error', $sms);
							return $this->redirect(['new-employeenoloan']);
							}
							}
		
        $employedBeneficiary->updateResubmittedBeneficiaries($employed_beneficiary_id); 
        }		
		if($employed_beneficiary_id !=''){
		    $sms="Employees confirmed as beneficiaries";
			Yii::$app->getSession()->setFlash('success', $sms);
			}
			if($employed_beneficiary_id ==''){
		   $sms=" Error: No any employee selected!";
		   Yii::$app->getSession()->setFlash('error', $sms);
		   }
		return $this->redirect(['new-employeenoloan']);
    }	
    
    public function actionMultEmployed($id)
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $dataProvider = $searchModel->getDoubleEmployed(Yii::$app->request->queryParams,$id);

        return $this->render('mult_employed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDeactivateDoubleEmployed($id)
    {
	
        $model = $this->findModel($id);
        $model->scenario = 'deactivate_double_employed';
		//$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
            $datime=date("Y_m_d_H_i_s");
            $model->support_document = UploadedFile::getInstance($model, 'support_document');
            $model->support_document->saveAs('../../beneficiary_document/employment_status_support_document_'.$model->employed_beneficiary_id.'_'.$datime.'.'.$model->support_document->extension);
            $model->support_document = 'beneficiary_document/employment_status_support_document_'.$model->employed_beneficiary_id.'_'.$datime.'.'.$model->support_document->extension;
            $model->employment_end_date=date("Y-m-d");
            $model->verification_status=5;
		
        
        // here for logs
			$old_data=\yii\helpers\Json::encode($model->oldAttributes);
			//end for logs
            if($model->save()) {
                $checkInEmployedBeneficiary = EmployedBeneficiary::find()->where(['applicant_id'=>$model->applicant_id,'employment_status'=>'ONPOST'])->count();
                if($checkInEmployedBeneficiary==1){
                $detailEmployedBeneficiary = EmployedBeneficiary::findOne(['applicant_id'=>$model->applicant_id,'employment_status'=>'ONPOST']);
                $detailEmployedBeneficiary->mult_employed=0;                
                $detailEmployedBeneficiary->save();
                }
			// here for logs            
            $new_data=\yii\helpers\Json::encode($model->attributes);
            $model_logs=\common\models\base\Logs::CreateLogall($model->employed_beneficiary_id,$old_data,$new_data,"employed_beneficiary","UPDATE",1);
            //end for logs			
            $sms="<p>Information updated successful</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['mult-employed','id'=>$model->applicant_id]);
            } 
        
                        }else {
            return $this->render('deactivateDoubleEmployed', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionNewEmployeeonstudy()
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneModel= new EmployedBeneficiary();
        $employee_status=1;
        $dataProvider = $searchModel->getNewEmployedBeneficiariesFound(Yii::$app->request->queryParams,$employee_status);
        $verification_status='0,4';
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status);
        return $this->render('newEmployeeonstudy', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUnverifiedEmployees' => $results,
        ]);
    }
    
    public function actionUpdateEmployeeonstudy($id)
    {
	
        $model = $this->findModel($id);
        $model->scenario = 'employee_status_update';
		//$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
        // here for logs
			$old_data=\yii\helpers\Json::encode($model->oldAttributes);
			//end for logs
            if($model->save()) {
			// here for logs            
            $new_data=\yii\helpers\Json::encode($model->attributes);
            $model_logs=\common\models\base\Logs::CreateLogall($model->employed_beneficiary_id,$old_data,$new_data,"employed_beneficiary","UPDATE",1);
            //end for logs			
            $sms="<p>Information updated successful</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['new-employeeonstudy']);
            } 
        
                        }else {
            return $this->render('updateEmployeeonstudy', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionEmployeeMatching()
    {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $dataProvider = $searchModel->getUnmatchedEmployees(Yii::$app->request->queryParams);
        return $this->render('employeeMatching', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	public function actionLoanthroughEmployers()
    {
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneficiary = new EmployedBeneficiary();
		$employerModel = new Employer();
		$disbursed_amount=0;
		$date=date("Y-m-d");
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
                        //CREATE LOAN SUMMARY
        $getAllEmployers=\backend\modules\repayment\models\Employer::find()->all();
		if(count($getAllEmployers) > 0){
        foreach($getAllEmployers AS $allEmployersResults){
        $employer_id=$allEmployersResults->employer_id;	
    $employeesLoanSummary = \common\models\LoanBeneficiary::getAmountPerAccademicYNoReturnedGivenToApplicantThroughEmployerCreateLoanSummary($employer_id);
	if(count($employeesLoanSummary) > 0){
    foreach($employeesLoanSummary AS $employeesLoanSumResults){        
        $employer_id=$employeesLoanSumResults->employer_id;
		$disbursed_amount=$employeesLoanSumResults->disbursed_amount;
		$academic_year_id=$employeesLoanSumResults->academic_year_id;
		$applicant_id=$employeesLoanSumResults->applicant_id;
		$application_id=$employeesLoanSumResults->application_id;
        $LoanSummaryModel=new LoanSummary();
        $LoanSummaryDetailModel = new \backend\modules\repayment\models\LoanSummaryDetail();
        $resultsEmployerDetails=$employerModel->getEmployerDetails($employer_id);
        $billNumber=$resultsEmployerDetails->employer_code."-".date("Y")."-".$LoanSummaryModel->getLastBillID($employer_id);
        $tracedBy='';
        //$totalEmployees=$employedBeneficiary->getAllEmployeesUnderBillunderEmployer($employer_id);
        //$totalAcculatedLoan=$employedBeneficiary->getTotalLoanInBill($employer_id);
        //$billNote="Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
		$billNote='';
        
        
        $LoanSummaryModel->amount = 0;
        $LoanSummaryModel->created_by=Yii::$app->user->identity->user_id;
        $LoanSummaryModel->created_at=date("Y-m-d H:i:s");
        $employerID=$employer_id;
        $LoanSummaryModel->vrf_accumulated=0.00;
        $LoanSummaryModel->vrf_last_date_calculated=date("Y-m-d H:i:s");
        $LoanSummaryModel->employer_id=$employer_id;
        $LoanSummaryModel->reference_number=$billNumber;
        $LoanSummaryModel->description=$billNote;
        $LoanSummaryModel->traced_by="";  
        //check if employer has a loan_summary and it is on payment
		$employeesLoanSummaryExist = \backend\modules\repayment\models\LoanSummary::findBySql('SELECT loan_summary_detail.loan_summary_id  FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE loan_summary.employer_id="'.$employer_id.'" AND (loan_summary.status=1 OR loan_summary.status=0) AND loan_summary_detail.loan_given_to="'.$loan_given_to.'" ORDER BY loan_summary.loan_summary_id DESC')->one();
        //end check
        if(count($employeesLoanSummaryExist)==0){
          $LoanSummaryModel->save(); 
          
        $loan_summary_id=$LoanSummaryModel->loan_summary_id;
		$itemCategory="PRC";
		$LoanSummaryDetailModel->insertBeneficiariesLoanThroughEmployer($employerID,$loan_summary_id,$applicant_id,$academic_year_id,$itemCategory,$disbursed_amount,$application_id);
		$totalVRF=$LoanSummaryDetailModel->getTotalVRFOriginalGivenToApplicantTrhEmployer($applicant_id,$date,$loan_given_to);
		if($totalVRF > 0){
		$itemCategory="VRF";	
		$LoanSummaryDetailModel->insertBeneficiariesLoanThroughEmployer($employerID,$loan_summary_id,$applicant_id,$academic_year_id,$itemCategory,$totalVRF,$application_id);	
		}
        }else{
        $loan_summary_id=$employeesLoanSummaryExist->loan_summary_id;			
		$itemCategory="PRC";
		$LoanSummaryDetailModel->insertBeneficiariesLoanThroughEmployer($employerID,$loan_summary_id,$applicant_id,$academic_year_id,$itemCategory,$disbursed_amount,$application_id);	
		$totalVRF=$LoanSummaryDetailModel->getTotalVRFOriginalGivenToApplicantTrhEmployer($applicant_id,$date,$loan_given_to);
		if($totalVRF > 0){
		$itemCategory="VRF";	
		$LoanSummaryDetailModel->insertBeneficiariesLoanThroughEmployer($employerID,$loan_summary_id,$applicant_id,$academic_year_id,$itemCategory,$totalVRF,$application_id);	
		}
        //$Recent_loan_summary_id=$employeesLoanSummaryExist->loan_summary_id;
        //$LoanSummaryModel->updateCeasedAllPreviousActiveBillUnderEmployer($employer_id,$Recent_loan_summary_id);
        }              
    }
	\backend\modules\repayment\models\LoanSummary::updateLoanSummaryAmount($employerID,$loan_summary_id);
		}
	}
	}	
    }
public function actionIndexUploadEmployees($id=null) {
        $model = new \frontend\modules\repayment\models\EmployedBeneficiary();
        $employerModel = new \frontend\modules\repayment\models\EmployerSearch();
        $model->scenario = 'upload_employees';
        $loggedin = Yii::$app->user->identity->user_id;
		
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
			$employerID = $model->employer_id;
			$employerDetails=\backend\modules\repayment\models\Employer::getEmployerDetails($employerID);
			$employerSalarySource=$employerDetails->salary_source;
            $model->employeesFile = UploadedFile::getInstance($model, 'employeesFile');
            //$model->employeesFile->saveAs('uploads/' . $datime . $model->employeesFile);
            //$model->employeesFile = 'uploads/' . $datime . $model->employeesFile;
			$model->employeesFile->saveAs(Yii::$app->params['employerUploadExcelTemplate'] . $datime . $model->employeesFile);
            $model->employeesFile = Yii::$app->params['employerUploadExcelTemplate'] . $datime . $model->employeesFile;
            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $model->employeesFile,
                        'setFirstRecordAsKeys' => true,
                        'setIndexSheetByName' => true,
            ]);
            foreach ($data as $rows) {
                $model = new \frontend\modules\repayment\models\EmployedBeneficiary();
                $model->scenario = 'upload_employees2';
                $model->employer_id = $employerID;
				$model->salary_source=$salary_source;
                $model->created_by = \Yii::$app->user->identity->user_id;
                $model->employment_status = "ONPOST";
                $model->created_at = date("Y-m-d H:i:s");
                $model->employee_id = $model->formatRowData($rows['EMPLOYEE_ID']);
                $f4indexno = $applcantF4IndexNo = $model->f4indexno = $model->formatRowData($rows['FORM_FOUR_INDEX_NUMBER']);
                $model->firstname = $model->formatRowData($rows['FIRST_NAME']);
                $model->middlename = $model->formatRowData($rows['MIDDLE_NAME']);
                $model->surname = $model->formatRowData($rows['SURNAME']);
				$model->LOAN_BENEFICIARY_STATUS = $model->formatRowData($rows['LOAN_BENEFICIARY_STATUS']);
                $model->date_of_birth = '';
                $wardName = '';
                //$model->place_of_birth = $model->getWardID($wardName);
                //$wardName=$model->place_of_birth = 1;
                $phone_number = $model->phone_number = $model->formatRowData($rows['MOBILE_PHONE_NUMBER']);
                $model->current_name = '';
				
				$model->uploaded_level_of_study =$programme_level_of_study1 = $model->formatRowData($rows['STUDY_LEVEL1']);
                $model->uploaded_learning_institution_code=$institution_code = $model->formatRowData($rows['INSTITUTION_OF_STUDY1']);
				$model->uploaded_programme_studied=$programme1 = $model->formatRowData($rows['PROGRAMME_STUDIED1']);
				$entryYear = $model->programme_entry_year = $model->formatRowData($rows['ENTRY_YEAR1']);
                $completionYear = $model->programme_completion_year = $model->formatRowData($rows['COMPLETION_YEAR1']);
				$fullFilledStatus1=$model->checkCompletenessOfFields($programme_level_of_study1,$institution_code,$programme1,$entryYear,$completionYear);
				
				$startCpyear="0,";
				$endCpyear=0;
				$CompletionAcademicYearF1='';
				$EntryAcademicYearF1='';
				$studyLevelIDF1='';
				$programmeStudiedID1='';
				$learning_institution_idF1='';
				if($fullFilledStatus1 !=1){
				$STUDY_LEVELerror1="Missing study level 1 fields";	
				}else{
				$STUDY_LEVELerror1="";
				$completionYearF = substr($completionYear, 2, 4);
                $CompletionAcademicYear1 = $model->getCompletionYear($completionYearF);
				$EntryAcademicYear1 = $model->getEntryYear($entryYear);
				$programme_level_of_study = \backend\modules\application\models\ApplicantCategory::findOne(['applicant_category' => $programme_level_of_study1]);
                $studyLevel1 = $programme_level_of_study->applicant_category_id;
				$programmeID = \backend\modules\application\models\Programme::findOne(['programme_name' => $programme1]);
                $programmeStudiedID1 = $programmeID->programme_id;
				$learning_institution_id1 = $model->getLearningInstitutionID($institution_code);
				
                if($CompletionAcademicYear1 !=''){
				$CompletionAcademicYearF1=$CompletionAcademicYear1.",";				
				}
                if($EntryAcademicYear1 !=''){
                $EntryAcademicYearF1 = $EntryAcademicYear1.",";				
				}
                if($studyLevel1 !=''){
				$studyLevelIDF1=$studyLevel1.",";	
				}
                if($programmeStudiedID1 !=''){
				$programmeStudiedID1=$programmeStudiedID1.",";	
				}
                if($learning_institution_id1 !=''){
				$learning_institution_idF1=$learning_institution_id1.",";	
				}				
				}
				$model->STUDY_LEVEL2=$programme_level_of_study2 = $model->formatRowData($rows['STUDY_LEVEL2']);
                $model->INSTITUTION_OF_STUDY2=$institution_code2 = $model->formatRowData($rows['INSTITUTION_OF_STUDY2']);
				$model->PROGRAMME_STUDIED2=$programme2 = $model->formatRowData($rows['PROGRAMME_STUDIED2']);
				$entryYear2 = $model->ENTRY_YEAR2 = $model->formatRowData($rows['ENTRY_YEAR2']);
                $completionYear2 = $model->COMPLETION_YEAR2 = $model->formatRowData($rows['COMPLETION_YEAR2']);
				$fullFilledStatus2=$model->checkCompletenessOfFields($programme_level_of_study2,$institution_code2,$programme2,$entryYear2,$completionYear2);
				
				$CompletionAcademicYearF2='';
				$EntryAcademicYearF2='';
				$studyLevelIDF2='';
				$programmeStudiedID2='';
				$learning_institution_idF2='';
				if($fullFilledStatus2 !=1){
				$STUDY_LEVELerror2="Missing study level 2 fields";	
				}else{
				$STUDY_LEVELerror2="";
				$completionYearF2 = substr($completionYear2, 2, 4);
                $CompletionAcademicYear2 = $model->getCompletionYear($completionYearF2);
				$EntryAcademicYear2 = $model->getEntryYear($entryYear2);
				$programme_level_of_study2 = \backend\modules\application\models\ApplicantCategory::findOne(['applicant_category' => $programme_level_of_study2]);
                $studyLevel2 = $programme_level_of_study2->applicant_category_id;
				$programmeID2 = \backend\modules\application\models\Programme::findOne(['programme_name' => $programme2]);
                $programmeStudiedID2 = $programmeID2->programme_id;
				$learning_institution_id2 = $model->getLearningInstitutionID($institution_code2);				
				
                if($CompletionAcademicYear2 !=''){
				$CompletionAcademicYearF2=$CompletionAcademicYear2.",";				
				}
                if($EntryAcademicYear2 !=''){
                $EntryAcademicYearF2 = $EntryAcademicYear2.",";				
				}
                if($studyLevel2 !=''){
				$studyLevelIDF2=$studyLevel2.",";	
				}
                if($programmeStudiedID2 !=''){
				$programmeStudiedID2=$programmeStudiedID2.",";	
				}
                if($learning_institution_id2 !=''){
				$learning_institution_idF2=$learning_institution_id2.",";	
				}				
				}
				
				$model->STUDY_LEVEL3=$programme_level_of_study3 = $model->formatRowData($rows['STUDY_LEVEL3']);
                $model->INSTITUTION_OF_STUDY3=$institution_code3 = $model->formatRowData($rows['INSTITUTION_OF_STUDY3']);
				$model->PROGRAMME_STUDIED3=$programme3 = $model->formatRowData($rows['PROGRAMME_STUDIED3']);
				$model->ENTRY_YEAR3=$entryYear3  = $model->formatRowData($rows['ENTRY_YEAR3']);
                $model->COMPLETION_YEAR3=$completionYear3 = $model->formatRowData($rows['COMPLETION_YEAR3']);
				
				$fullFilledStatus3=$model->checkCompletenessOfFields($programme_level_of_study3,$institution_code3,$programme3,$entryYear3,$completionYear3);
				
				$CompletionAcademicYearF3='';
				$EntryAcademicYearF3='';
				$studyLevelIDF3='';
				$programmeStudiedID3='';
				$learning_institution_idF3='';
				if($fullFilledStatus3 !=1){
				$STUDY_LEVELerror3="Missing study level 3 fields";	
				}else{
				$STUDY_LEVELerror3="";
				$completionYearF3 = substr($completionYear3, 2, 4);
                $CompletionAcademicYear3 = $model->getCompletionYear($completionYearF3);
				$EntryAcademicYear3 = $model->getEntryYear($entryYear3);
				$programme_level_of_study3 = \backend\modules\application\models\ApplicantCategory::findOne(['applicant_category' => $programme_level_of_study3]);
                $studyLevel3 = $programme_level_of_study3->applicant_category_id;
				$programmeID3 = \backend\modules\application\models\Programme::findOne(['programme_name' => $programme3]);
                $programmeStudiedID3 = $programmeID3->programme_id;
				$learning_institution_id3 = $model->getLearningInstitutionID($institution_code3);
				
                if($CompletionAcademicYear3 !=''){
				$CompletionAcademicYearF3=$CompletionAcademicYear3.",";				
				}
                if($EntryAcademicYear3 !=''){
                $EntryAcademicYearF3 = $EntryAcademicYear3.",";				
				}
                if($studyLevel3 !=''){
				$studyLevelIDF3=$studyLevel3.",";	
				}
                if($programmeStudiedID3 !=''){
				$programmeStudiedID3=$programmeStudiedID3.",";	
				}
                if($learning_institution_id3 !=''){
				$learning_institution_idF3=$learning_institution_id3.",";	
				}				
				}
				
                //$model->learning_institution_id = $model->getLearningInstitutionID($institution_code);
                $NIN = $model->NID = $model->formatRowData($rows['NATIONAL_IDENTIFICATION_NUMBER']);
                $checkIsmoney = $model->basic_salary = $model->formatRowData($rows['GROSS_SALARY(TZS)']);
                $model->sex = $model->formatRowData($rows['GENDER(MALE_OR_FEMALE)']);
                
                
				$salary_source = $model->formatRowData($rows['SALARY_SOURCE']);                
                //$programme_level_of_study = \backend\modules\application\models\ApplicantCategory::findOne(['applicant_category' => $programme_level_of_study1]);
                //$studyLevel = $model->programme_level_of_study = $programme_level_of_study->applicant_category_id;
				$studyLevelGeneral = $startCpyear.$studyLevelIDF1.$studyLevelIDF2.$studyLevelIDF3.$endCpyear;
				$model->programme_level_of_study=$studyLevelGeneral;
                //$programmeID = \backend\modules\application\models\Programme::findOne(['programme_code' => $programme1]);
                //$programmeStudied = $model->programme = $programmeID->programme_id;
				$programmeStudiedGeneral = $startCpyear.$programmeStudiedID1.$programmeStudiedID2.$programmeStudiedID3.$endCpyear;
				$model->programme=$programmeStudiedGeneral;
                //$model->uploaded_learning_institution_code = $institution_code;
                //$model->uploaded_level_of_study = $programme_level_of_study1;
                //$model->uploaded_programme_studied = $programme1;
                $model->uploaded_sex = $model->sex;
                $model->verification_status = 0;				

				if($salary_source=='central government'){
					//check employer salary source
					if($employerSalarySource==1 OR $employerSalarySource==3){
						$model->salary_source=1;
					}else{
						$model->salary_source='';
					}
					//end check
							
				}else if($salary_source=='own source'){
					//check employer salary source
					if($employerSalarySource !=1){
						$model->salary_source=2;
					}else{
						$model->salary_source='';
					}
					//end check					
				}else if($salary_source=='both'){
					//check employer salary source
					if($employerSalarySource==3){
						$model->salary_source=3;
					}else{
						$model->salary_source='';
					}
					//end check					
				}else{
					$model->salary_source='';
				}
                //$EntryAcademicYear = $model->getEntryYear($entryYear);
				$EntryAcademicYearGeneral = $startCpyear.$EntryAcademicYearF1.$EntryAcademicYearF2.$EntryAcademicYearF3.$endCpyear;          
                //$CompletionAcademicYear = $model->getCompletionYear($completionYear2);
				$CompletionAcademicYearGeneral = $startCpyear.$CompletionAcademicYearF1.$CompletionAcademicYearF2.$CompletionAcademicYearF3.$endCpyear;

                //echo $EntryAcademicYear."<br/>".$CompletionAcademicYear;
                //exit;
                if ($model->sex == 'MALE') {
                    $model->sex = 'M';
                } else if ($model->sex == 'FEMALE') {
                    $model->sex = 'F';
                } else {
                    $model->sex = '';
                }
                //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
				$splitF4Indexno=explode('.',$applcantF4IndexNo);
				$f4indexnoSprit1=$splitF4Indexno[0];
				$f4indexnoSprit2=$splitF4Indexno[1];
				$f4indexnoSprit3=$splitF4Indexno[2];
				$regNo=$f4indexnoSprit1.".".$f4indexnoSprit2;
				$f4CompletionYear=$f4indexnoSprit3;
				$academicInstitutionGeneral = $startCpyear.$learning_institution_idF1.$learning_institution_idF2.$learning_institution_idF3.$endCpyear;
				//$model->learning_institution_id=$academicInstitutionGeneral;
				$firstname = $model->firstname;
                $middlename = $model->middlename;
                $surname = $model->surname;
				
                $employeeID = $model->getApplicantDetails($regNo,$f4CompletionYear,$NIN);
				//$employeeID=$model->getApplicantDetailsUsingNonUniqueIdentifiers3($regNo,$f4CompletionYear,$firstname, $middlename, $surname,$academicInstitutionGeneral,$studyLevelGeneral, $programmeStudiedGeneral,$EntryAcademicYearGeneral,$CompletionAcademicYearGeneral);
                $model->applicant_id = $employeeID->applicant_id;				
                //end check using unique identifiers
				
				
                //check using non-unique identifiers
                if (!is_numeric($model->applicant_id) && $model->applicant_id < 1 && $model->applicant_id == '') {                    
                    //$academicInstitution = $model->learning_institution_id;
                    $resultsUsingNonUniqueIdent = $model->getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $academicInstitutionGeneral,$studyLevelGeneral, $programmeStudiedGeneral,$EntryAcademicYearGeneral,$CompletionAcademicYearGeneral);
                    $model->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
                }
                // end check using unique identifiers                            
                if (!is_numeric($model->applicant_id)) {
                    $model->applicant_id = '';
                }
                $applicantId = $model->applicant_id;
                //check if employee is on study
                if ($model->applicant_id != '') {
                    $employeeOnstudyStatus = $model->getEmployeeOnStudyStatus($model->applicant_id);
                    if ($employeeOnstudyStatus != '') {
                        $model->employee_status = 1;
                    } else {
                        $model->employee_status = 0;
                    }
                } else {
                    $model->employee_status = 0;
                }
                //end check 
                // check if beneficiary exists in beneficiary table and save
                $employeeExist = $model->checkEmployeeExists($applicantId, $model->employer_id, $model->employee_id);
                if ($employeeExist == 1) {
                    $eployee_exists_status = 1;
                    $employeeExistsID = $model->getEmployeeExists($applicantId, $model->employer_id, $model->employee_id);
                    $employeeExistsId = $employeeExistsID->employed_beneficiary_id;
                } else {
                    $eployee_exists_status = 0;
                    //check if nonApplicant exists in beneficiary table
                    $nonApplicantFound = $model->checkEmployeeExistsNonApplicant($f4indexno, $model->employer_id, $model->employee_id);
                    if ($nonApplicantFound == 1) {
                        $eployee_exists_nonApplicant = 1;
                        $resultdNonApplicantExistID = $model->getEmployeeExistsNonApplicantID($f4indexno, $model->employer_id, $model->employee_id);
                        $results_nonApplicantFound = $resultdNonApplicantExistID->employed_beneficiary_id;
                    } else {
                        $eployee_exists_nonApplicant = 0;
                    }
                    //end check if nonApplicant Exists 
                }
                //validate for error recording
                $model->validate();

                $reason = '';
                if ($model->hasErrors()) {
                    $errors = $model->errors;
                    foreach ($errors as $key => $value) {
                        $reason = $reason . $value[0] . ',  ';
                    }
                }
                if ($reason != '') {
                    $model->upload_status = 0;
                    $model->upload_error = $reason.$STUDY_LEVELerror1.", ".$STUDY_LEVELerror2.", ".$STUDY_LEVELerror3;					
                } else {
                    $model->upload_status = 1;
                    $model->upload_error = '';
					$model->confirmed=1;
                }
                //end validation check
				
				//check double employed
				if($model->confirmed==1){
				$model->employment_start_date = date("Y-m-d");
            $applicantID = $model->applicant_id;
            $resultsCheckEmployed = \frontend\modules\repayment\models\EmployedBeneficiary::checkDoubleEmployed($applicantID, $employerID);
            if ($resultsCheckEmployed == 1) {
                $model->mult_employed = 1;
            } else {
                $model->mult_employed = 0;
            }
				}
				//end check double employed
				
                // check for disbursed amount to employee
                if ($model->applicant_id > 0) {
                    $resultDisbursed = $model->getIndividualEmployeesPrincipalLoan($model->applicant_id);
                    if ($resultDisbursed == 0) {
                        $model->verification_status = 4;
                    }
                }
                //end check

                if ($eployee_exists_status == 0 && $eployee_exists_nonApplicant == 0) {
                    if ($model->employee_id != 'T12XX35') {
                        $model->save(false);
                    }
                } else if ($eployee_exists_status == 1) {
                    //$model->updateBeneficiary($checkIsmoney,$employeeExistsId);
                    $model->updateEmployeeReuploaded($model->employer_id, $model->employee_id, $model->applicant_id, $model->basic_salary, $model->employment_status, $model->NID, $model->f4indexno, $model->firstname, $model->middlename, $model->surname, $model->sex, $model->date_of_birth, $model->place_of_birth, $model->learning_institution_id, $model->phone_number, $model->upload_status, $model->upload_error, $model->programme_entry_year, $model->programme_completion_year, $model->programme, $model->programme_level_of_study, $model->employee_status, $model->current_name, $model->uploaded_learning_institution_code, $model->uploaded_level_of_study, $model->uploaded_programme_studied, $model->uploaded_place_of_birth, $model->uploaded_sex, $model->verification_status, $employeeExistsId,$model->salary_source);
                } else if ($eployee_exists_status == 0 && $eployee_exists_nonApplicant == 1) {
                    //$model->updateBeneficiaryNonApplicant($checkIsmoney,$results_nonApplicantFound,$f4indexno,$firstname,$phone_number,$NIN); 

                    $model->updateEmployeeReuploaded($model->employer_id, $model->employee_id, $model->applicant_id, $model->basic_salary, $model->employment_status, $model->NID, $model->f4indexno, $model->firstname, $model->middlename, $model->surname, $model->sex, $model->date_of_birth, $model->place_of_birth, $model->learning_institution_id, $model->phone_number, $model->upload_status, $model->upload_error, $model->programme_entry_year, $model->programme_completion_year, $model->programme, $model->programme_level_of_study, $model->employee_status, $model->current_name, $model->uploaded_learning_institution_code, $model->uploaded_level_of_study, $model->uploaded_programme_studied, $model->uploaded_place_of_birth, $model->uploaded_sex, $model->verification_status, $results_nonApplicantFound,$model->salary_source);
                }

                $doneUpload = 1;
            }
            if ($doneUpload == 1) {
                unlink($model->employeesFile);
                $sms = "<p>Employees uploaded successful</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['employer/view','id'=>$employerID]);
            } else {
                $sms = "<p>Operation failed, no record saved!</p>";
                Yii::$app->getSession()->setFlash('danger', $sms);
                return $this->redirect(['index-upload-employees']);
            }
        } else {
            return $this->render('indexUploadEmployeesheslb', [
                        'model' => $model,'employerID'=>$id
            ]);
        }
    }
    
}
