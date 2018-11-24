<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\EmployedBeneficiarySearch;
use frontend\modules\repayment\models\EmployerSearch;
use frontend\modules\repayment\models\LoanSummary;
use backend\modules\allocation\models\LearningInstitution;
use backend\modules\allocation\models\LearningInstitutionSearch;
use common\components\Controller;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
	 /*
	 public function actionIndex()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
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
	*/
	 
    public function actionIndex()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
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
        $dataProvider = $searchModel->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);
		$dataProviderNonBeneficiary = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams,$employerID);
        
        return $this->render('AllBeneficiaries', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary,
        ]);
    }
	
	public function actionUnconfirmedBeneficiariesView()
    {
        //$this->layout="default_main";
		$user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $searchModel = new EmployedBeneficiarySearch();
		$employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;        
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider = $searchModel->getUnconfirmedBeneficiaries(Yii::$app->request->queryParams,$employerID);        
        return $this->render('unconfirmedBeneficiariesView', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionUnVerifiedUploadedEmployees()
    {
        //$this->layout="default_main";
		$user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $searchModel = new EmployedBeneficiarySearch();
		$employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;        
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams,$employerID);        
        return $this->render('unVerifiedUploadedEmployees', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionUnconfirmedBeneficiariesList()
    {
        $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
		$employerModel = new EmployerSearch();
		$employedBeneModel= new EmployedBeneficiary();
        $loggedin=Yii::$app->user->identity->user_id;        
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider = $searchModel->getUnconfirmedBeneficiaries(Yii::$app->request->queryParams,$employerID); 
		$verification_status=3;
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status,$employerID);		
        return $this->render('unconfirmedBeneficiariesList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'totalUnverifiedEmployees' => $results,
        ]);
    }
	public function actionUnVerifiedUploadedEmployeesList()
    {
        $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
		$employerModel = new EmployerSearch();
		$employedBeneModel= new EmployedBeneficiary();
        $loggedin=Yii::$app->user->identity->user_id;        
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        //$dataProvider = $searchModel->getUnconfirmedBeneficiaries(Yii::$app->request->queryParams,$employerID); 
		$dataProvider = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams,$employerID);
		$verification_status=3;
        $results=$employedBeneModel->getUnverifiedEmployees($verification_status,$employerID);		
        return $this->render('unVerifiedUploadedEmployeesList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'totalUnverifiedEmployees' => $results,
        ]);
    }
	public function actionLearningInstitutionsCodes()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $searchModelLearningInstitutionSearch = new LearningInstitutionSearch();
        $dataProvider = $searchModelLearningInstitutionSearch->search(Yii::$app->request->queryParams);
        
        return $this->render('learningInstitutionsCodes', [
            'searchModel' => $searchModelLearningInstitutionSearch,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployedBeneficiary model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewBeneficiary($id)
    {
        $this->layout="default_main"; 	
        return $this->render('viewBeneficiary', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionView($id)
    {
        	
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
	
	
	public function actionViewLoanNonConfirmedBeneficiaries($id)
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        return $this->render('viewLoanNonConfirmedBeneficiaries', [
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
	public function actionCreate()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
           $modelEmployedBeneficiary = new EmployedBeneficiary();
		   $searchModelEmployedBeneficiarySearch = new EmployedBeneficiarySearch();
		   $modelEmployedBeneficiary->scenario='additionalEmployee';
		   $employerModel = new EmployerSearch();	   
		   $modelEmployedBeneficiary->created_by=\Yii::$app->user->identity->user_id;
           $loggedin=$modelEmployedBeneficiary->created_by;
           $employer2=$employerModel->getEmployer($loggedin);
		   $modelEmployedBeneficiary->employer_id=$employer2->employer_id;
           $modelEmployedBeneficiary->created_at=date("Y-m-d H:i:s");
		   $employerID=$employer2->employer_id;
		   
        if ($modelEmployedBeneficiary->load(Yii::$app->request->post()) && $modelEmployedBeneficiary->save()) {
		
		$dataProvider = $searchModelEmployedBeneficiarySearch->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);
		$dataProviderNonBeneficiary = $searchModelEmployedBeneficiarySearch->getNonVerifiedEmployees(Yii::$app->request->queryParams,$employerID);
		    $sms="Employee Added Successful!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->render('AllBeneficiaries', [
            'searchModel' => $searchModelEmployedBeneficiarySearch,
            'dataProvider' => $dataProvider,
			'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary,
        ]);
        } else {
            return $this->render('create', [
                'model' => $modelEmployedBeneficiary,
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
                          $inputFiles1=UploadedFile::getInstance($modelHeader, 'employeesFile');
                          $modelHeader->employeesFile=UploadedFile::getInstance($modelHeader, 'employeesFile');
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
 
       
        if(strcmp($highestColumn,"N")==0 && $highestRow >=4){        
                  
  $s1=1;
  
                  for ($row = 4; $row <= $highestRow; ++$row) {

          $rowData = $sheet ->rangeToArray('A'.$row. ':' .$highestColumn.$row, NULL, TRUE, FALSE);

          $modelHeader = new EmployedBeneficiary();

          $modelHeader->employer_id = $employerID;
          $modelHeader->created_by=\Yii::$app->user->identity->user_id;
          $modelHeader->employment_status = "ONPOST";
          $modelHeader->created_at = date("Y-m-d H:i:s");
		  $sn = $rowData[0][0];
		  $modelHeader->employee_check_number = EmployedBeneficiary::formatRowData($rowData[0][1]);
          $modelHeader->employee_f4indexno = EmployedBeneficiary::formatRowData($rowData[0][2]);
          $modelHeader->employee_FIRST_NAME = EmployedBeneficiary::formatRowData($rowData[0][3]);
          $modelHeader->employee_MIDDLE_NAME = EmployedBeneficiary::formatRowData($rowData[0][4]);
          $modelHeader->employee_SURNAME = EmployedBeneficiary::formatRowData($rowData[0][5]);
          $modelHeader->employee_DATE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][6]);
          $modelHeader->employee_PLACE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][7]);
          $modelHeader->employee_mobile_phone_no = EmployedBeneficiary::formatRowData($rowData[0][8]);
          $modelHeader->employee_current_nameifchanged = EmployedBeneficiary::formatRowData($rowData[0][9]);
          $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY = EmployedBeneficiary::formatRowData($rowData[0][10]);
          $modelHeader->employee_NIN = EmployedBeneficiary::formatRowData($rowData[0][11]);
          $modelHeader->basic_salary = EmployedBeneficiary::formatRowData($rowData[0][12]);
          $modelHeader->sex = EmployedBeneficiary::formatRowData($rowData[0][13]);
		  if($modelHeader->sex=='MALE'){
		  $modelHeader->sex='M';
		  }else if($modelHeader->sex=='FEMALE'){
		  $modelHeader->sex='F';
		  }
		  
		  // added 13-02-2018 
		  $modelHeader->f4indexno=$modelHeader->employee_f4indexno;
		  $modelHeader->firstname=$modelHeader->employee_FIRST_NAME;
		  $modelHeader->middlename=$modelHeader->employee_MIDDLE_NAME;
		  $modelHeader->surname=$modelHeader->employee_SURNAME;
		  $modelHeader->date_of_birth=$modelHeader->employee_DATE_OF_BIRTH;
		  $wardName=$modelHeader->employee_PLACE_OF_BIRTH;
		  $modelHeader->ward_id=$modelHeader->getWardID($wardName);
		  $modelHeader->phone_number=$modelHeader->employee_mobile_phone_no;
		  $institution_code=$modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
		  $modelHeader->learning_institution_id=$modelHeader->getLearningInstitutionID($institution_code);
		  $modelHeader->NID=$modelHeader->employee_NIN;
		  
		  // end 13-02-2018
		  
		  
          $modelHeader->firstname=trim($modelHeader->employee_FIRST_NAME);
          $checkIsmoney=$modelHeader->basic_salary;
          $applcantF4IndexNo=$modelHeader->employee_f4indexno;
          $NIN=$modelHeader->employee_NIN;
          //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
          $employeeID=$modelHeader->getApplicantDetails($applcantF4IndexNo,$NIN);
          $modelHeader->applicant_id=$employeeID->applicant_id;
          //end check using unique identifiers
          
          //check using non-unique identifiers
          if(!is_numeric($modelHeader->applicant_id)){
          $firstname=$modelHeader->employee_FIRST_NAME;$middlename=$modelHeader->employee_MIDDLE_NAME;$surname=$modelHeader->employee_SURNAME;
          $dateofbirth=$modelHeader->employee_DATE_OF_BIRTH;$placeofbirth=$modelHeader->employee_PLACE_OF_BIRTH;$academicInstitution=$modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
          $resultsUsingNonUniqueIdent=$modelHeader->getApplicantDetailsUsingNonUniqueIdentifiers($firstname,$middlename,$surname,$dateofbirth,$placeofbirth,$academicInstitution);
          $modelHeader->applicant_id=$resultsUsingNonUniqueIdent->applicant_id;  
          }
          // end check using unique identifiers
          
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
            $firstname=$modelHeader->firstname;  
          }else{
            $firstname=$modelHeader->employee_current_nameifchanged;  
          }
          $phone_number=$modelHeader->employee_mobile_phone_no;
          $NID=$modelHeader->employee_NIN;
          
          if($sn !='' AND (!is_numeric($checkIsmoney) OR $modelHeader->employee_check_number=='' OR $modelHeader->firstname=='' OR
                  $modelHeader->employee_mobile_phone_no=='' OR $modelHeader->employee_FIRST_NAME=='' OR 
                  $modelHeader->employee_MIDDLE_NAME=='' OR $modelHeader->employee_SURNAME=='' OR $modelHeader->employee_DATE_OF_BIRTH=='' OR
                  $modelHeader->employee_PLACE_OF_BIRTH=='' OR $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY=='')){
				  unlink('uploads/'.$date_time.$inputFiles1);
           $sms = '<p>Operation did not complete, Please check the information in the excel you are trying to upload.'
                   . '<br/><i>The following columns are compulsory.</i>'
                   . '<ul><li>CHECK NUMBER</li><li>FIRST NAME</li><li>MIDDLE NAME</li><li>SURNAME</li>'
                   . '<li>DATE OF BIRTH</li><li>PLACE OF BIRTH</li><li>MOBILE PHONE NUMBER</li>'
                   . '<li>NAME OF INSTITUTION OF STUDY</li>'
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
          
          // check if beneficiary exists in beneficiary table and save
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
              $modelHeader->firstname=$modelHeader->firstname;    
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
              //$modelHeader->getindexNoApplicant($applcantF4IndexNo);
              $current_name=$modelHeader->employee_current_nameifchanged;
              $applicant_id=$applicantId;
              $NIN=$modelHeader->employee_NIN;
              if($NIN !=''){
              $modelHeader->updateEmployeeNane($current_name,$applicant_id,$NIN);
              }
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
	 /*
    public function actionUpdate($id)
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        $model = $this->findModel($id);
        $model->scenario = 'update_employee';
        $LoanSummaryModel = new LoanSummary();
        if ($model->load(Yii::$app->request->post())) {
        $applicantId=$model->applicant_id;
        if($model->employment_status !='ONPOST'){
         $LoanSummaryID=$model->loan_summary_id;
         $employerID=$model->employer_id;
        $LoanSummaryModel->ceaseBillIfEmployedBeneficiaryDisabled($LoanSummaryID,$employerID);    
        }
        if($applicantId !=''){
        $employeeID=$model->getEmployeeUserId($applicantId);
        $applicant_user_id=$employeeID->user_id;
        }
        $phoneNumber=$model->employee_mobile_phone_no;
        $current_name=$model->employee_current_nameifchanged;
        $applicant_id=$model->applicant_id;
        $NIN=$model->employee_NIN;
        if($applicantId !=''){
        $model->updateUserPhone($phoneNumber,$applicant_user_id);
        if($NIN !=''){
        $model->updateEmployeeNane($current_name,$applicant_id,$NIN);
        }
        }
        if($applicantId ==''){
            $checkIsmoney=$model->basic_salary;
            $employeeExistsId=$model->employed_beneficiary_id;
            $f4indexno=$model->f4indexno;
            $firstname=$model->employee_current_nameifchanged;
            $phone_number=$model->employee_mobile_phone_no;
            $NID=$model->employee_NIN;
            $model->updateBeneficiaryNonApplicant($checkIsmoney,$employeeExistsId,$f4indexno,$firstname,$phone_number,$NID);
        }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->employed_beneficiary_id]);
            $sms="Information Updated Successful!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	*/
	
	
	 public function actionUpdate($id)
    {
	    $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
		
        $model = $this->findModel($id);
        $model->scenario = 'update_employee';
		//$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
        //$modelLoanBeneficiary = new LoanBeneficiary();
		//$employeeID=$modelLoanBeneficiary->getApplicantDetails($applcantF4IndexNo,$NIN);
		//$model->applicant_id=$employeeID->applicant_id;
		
		//echo $model->applicant_id;
        
        if ($model->save()) {
		   //if($model->applicant_id !=''){
            $sms="Information Updated Successful!";
			Yii::$app->getSession()->setFlash('success', $sms);
			//}else{
			//$sms="Operation failed, form IV index number is invalid";
			//Yii::$app->getSession()->setFlash('error', $sms);
			//}            
            return $this->redirect(['employed-beneficiary/un-verified-uploaded-employees']);
        } }else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdateBeneficiary($id)
    {
	    $this->layout="default_main";
		$LoanSummaryModel = new LoanSummary();
		//$model2 = new LoanSummaryDetail();
        $model = $this->findModel($id);
        $model->scenario = 'update_beneficiary';
		//$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
		   if($model->applicant_id !=''){
		   //disable and generate new loan summary
		   if($model->employment_status !='ONPOST' AND $model->employmentStatus2=='ONPOST' AND $model->loan_summary_id !=''){
			 $LoanSummaryID=$model->loan_summary_id;
			 $employerID=$model->employer_id;
			$LoanSummaryModel->ceaseBillIfEmployedBeneficiaryDisabled($LoanSummaryID,$employerID);
            // start generating loan summary
			$totalAcculatedLoan=\backend\modules\repayment\models\EmployedBeneficiary::getTotalLoanInBill($employerID);
			$resultsEmployer=\backend\modules\repayment\models\LoanSummary::getEmployerDetails($employerID);
			$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".\backend\modules\repayment\models\LoanSummary::getLastBillID($employerID);
			$status=0;
			$description="Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
			$created_by=Yii::$app->user->identity->user_id;
			$created_at=date("Y-m-d H:i:s");
			$vrf_accumulated=0.00;
			$vrf_last_date_calculated=$created_at;
			\backend\modules\repayment\models\LoanSummary::insertNewValuesAfterTermination($employerID,$totalAcculatedLoan,$billNumber,$status,$description,$created_by,$created_at,$vrf_accumulated,$vrf_last_date_calculated);			
			$New_loan_summary_id=\backend\modules\repayment\models\LoanSummary::getLastLoanSummaryID($employerID);  		
            \backend\modules\repayment\models\LoanSummaryDetail::insertAllBeneficiariesUnderBill($employerID,$New_loan_summary_id);
            \backend\modules\repayment\models\LoanSummary::updateCeasedBill($employerID);
            //here end generate new loan summary			
			}
		   //end
            $sms="Information Updated Successful!";
			Yii::$app->getSession()->setFlash('success', $sms);
			}else{
			$sms="Operation failed, form IV index number is invalid";
			Yii::$app->getSession()->setFlash('error', $sms);
			}            
            return $this->redirect(['employed-beneficiary/beneficiaries-verified']);
        } }else {
            return $this->render('updateBeneficiary', [
                'model' => $model,
            ]);
        }
    }
	
	
	/*
	public function actionUpdate($id)
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        $model = $this->findModel($id);
        $model->scenario = 'update_employee';
        $LoanSummaryModel = new LoanSummary();
        if ($model->load(Yii::$app->request->post())) {
        $applicantId=$model->applicant_id;
        if($model->employment_status !='ONPOST'){
         $LoanSummaryID=$model->loan_summary_id;
         $employerID=$model->employer_id;
        $LoanSummaryModel->ceaseBillIfEmployedBeneficiaryDisabled($LoanSummaryID,$employerID);    
        }
        if($applicantId !=''){
        $employeeID=$model->getEmployeeUserId($applicantId);
        $applicant_user_id=$employeeID->user_id;
        }
        $phoneNumber=$model->employee_mobile_phone_no;
        $current_name=$model->employee_current_nameifchanged;
        $applicant_id=$model->applicant_id;
        $NIN=$model->employee_NIN;
        if($applicantId !=''){
        $model->updateUserPhone($phoneNumber,$applicant_user_id);
        if($NIN !=''){
        $model->updateEmployeeNane($current_name,$applicant_id,$NIN);
        }
        }
		// 13-02-2018
        if($applicantId ==''){
            $checkIsmoney=$model->basic_salary;
            $employeeExistsId=$model->employed_beneficiary_id;
            $f4indexno=$model->f4indexno;
            $firstname=$model->employee_current_nameifchanged;
            $phone_number=$model->employee_mobile_phone_no;
            $NID=$model->employee_NIN;
            $model->updateBeneficiaryNonApplicant($checkIsmoney,$employeeExistsId,$f4indexno,$firstname,$phone_number,$NID);
        }
		//-----
        }
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->employed_beneficiary_id]);
            $sms="Information Updated Successful!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	*/
    
    public function actionDownload()
{
    $path=Yii::getAlias('@webroot'). '/dwload';
    $file=$path. '/employed_loan_beneficiaries_template.xlsx';
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
    echo "TELE";
    exit;
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
	public function actionConfirmBeneficiariesEmployer()
    {	
	   $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
	
		   $searchModel = new EmployedBeneficiarySearch();
		   $employerModel = new EmployerSearch();
		   $employedBeneficiary = new EmployedBeneficiary();
           $loggedin=Yii::$app->user->identity->user_id;        
           $employer2=$employerModel->getEmployer($loggedin);
           $employerID=$employer2->employer_id;	
		   $employedBeneficiary->confirmBeneficiaryByEmployer($employerID);
		   $sms="Beneficiaries confirmed!";
		   Yii::$app->getSession()->setFlash('success', $sms);
		   return $this->redirect(['unconfirmed-beneficiaries-list']);
    }
	
	public function actionBeneficiariesVerified()
    {
	    $this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;        
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider = $searchModel->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);
        
        return $this->render('beneficiariesVerified', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
}
