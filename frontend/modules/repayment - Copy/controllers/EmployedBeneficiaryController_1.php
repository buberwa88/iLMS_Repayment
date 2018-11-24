<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\EmployedBeneficiarySearch;
use frontend\modules\repayment\models\EmployerSearch;
use yii\web\Controller;
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

    /**
     * Displays a single EmployedBeneficiary model.
     * @param integer $id
     * @return mixed
     */
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
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
        $model = $this->findModel($id);
        $model->scenario = 'update_employee';
        if ($model->load(Yii::$app->request->post())) {
        $applicantId=$model->applicant_id;
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
        $model->updateEmployeeNane($current_name,$applicant_id,$NIN);
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
    
}
