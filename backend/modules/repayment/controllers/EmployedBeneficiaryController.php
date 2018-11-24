<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\repayment\models\EmployedBeneficiarySearch;
use backend\modules\repayment\models\EmployerSearch;
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
			if($doubleEmployed==0){                        
                        //CREATE LOAN SUMMARY
    $employeesLoanSummary = \backend\modules\repayment\models\EmployedBeneficiary::findBySql('SELECT employed_beneficiary.employer_id,employer.employer_name,employer.employer_code  FROM employed_beneficiary INNER JOIN employer ON employer.employer_id=employed_beneficiary.employer_id WHERE employer.employer_id=employed_beneficiary.employer_id AND  employed_beneficiary.employment_status="ONPOST" AND (employed_beneficiary.loan_summary_id IS NULL OR employed_beneficiary.loan_summary_id="") AND employed_beneficiary.verification_status=1 GROUP BY employed_beneficiary.employer_id')->all();
    foreach($employeesLoanSummary AS $employeesLoanSumResults){
        
        $employer_id=$employeesLoanSumResults->employer_id;
        $LoanSummaryModel=new LoanSummary();
        $LoanSummaryDetailModel = new \backend\modules\repayment\models\LoanSummaryDetail();
        $resultsEmployer=$LoanSummaryModel->getEmployerDetails($employer_id);
        $billNumber=$employeesLoanSumResults->employer_code."-".date("Y")."-".$LoanSummaryModel->getLastBillID($employer_id);
        $tracedBy=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;
        //$totalEmployees=$employedBeneficiary->getAllEmployeesUnderBillunderEmployer($employer_id);
        $totalAcculatedLoan=$employedBeneficiary->getTotalLoanInBill($employer_id);
        $billNote="Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
        
        
        $LoanSummaryModel->amount = $totalAcculatedLoan;
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
        $employeesLoanSummaryExist = \backend\modules\repayment\models\LoanSummary::findBySql('SELECT loan_summary_id  FROM loan_summary WHERE employer_id="'.$employer_id.'" AND (status=1 OR status=0) ORDER BY loan_summary_id DESC')->one();
        //end check
        if(count($employeesLoanSummaryExist)==0){
          $LoanSummaryModel->save(); 
          
        $loan_summary_id=$LoanSummaryModel->loan_summary_id;            
        $LoanSummaryDetailModel->insertAllBeneficiariesUnderBill($employer_id,$loan_summary_id);
        $LoanSummaryModel->updateCeasedBill($employer_id);
        //$Recent_loan_summary_id=$LoanSummaryModel->loan_summary_id;
        //$LoanSummaryModel->updateCeasedAllPreviousActiveBillUnderEmployer($employer_id,$Recent_loan_summary_id);
        }else{
         $totalAcculatedLoan=$employedBeneficiary->getTotalLoanInBill($employer_id);   
         $LoanSummaryModelUpdate=new LoanSummary();
         $amountLoanSummary=\backend\modules\repayment\models\LoanSummary::findOne(['loan_summary_id'=>$employeesLoanSummaryExist->loan_summary_id]);
         $amountLoanSummary->amount +=$totalAcculatedLoan;
         $amountLoanSummary->updated_at=date("Y-m-d H:i:s");
         $amountLoanSummary->save();
         
        $loan_summary_id=$employeesLoanSummaryExist->loan_summary_id;        
        $loan_summary_id=$employeesLoanSummaryExist->loan_summary_id;            
        $LoanSummaryDetailModel->insertAllBeneficiariesUnderBill($employer_id,$loan_summary_id);        
        $LoanSummaryModel->updateCeasedBill($employer_id);
        //$Recent_loan_summary_id=$employeesLoanSummaryExist->loan_summary_id;
        //$LoanSummaryModel->updateCeasedAllPreviousActiveBillUnderEmployer($employer_id,$Recent_loan_summary_id);
        }              
    }   
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
        //$searchModel = new EmployedBeneficiarySearch();
        //$employedBeneficiary = new EmployedBeneficiary();        
        //$resul=$employedBeneficiary->getEmployerFromSubmittedBeneficiaries();
        //$employedBeneficiary->submitEmployeesInBulk();
        //$dataProvider = $searchModel->getAllBeneficiaries(Yii::$app->request->queryParams);
/*
        return $this->render('AllBeneficiaries', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
*/		
		
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
    /*
    public function actionNewEmployerWaitingBill()
    {
        $searchModel = new EmployedBeneficiarySearch();
        $dataProvider = $searchModel->getEmployersWaitingBill(Yii::$app->request->queryParams);
        return $this->render('newEmployerWaitingBill', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	*/
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
    
    
}
