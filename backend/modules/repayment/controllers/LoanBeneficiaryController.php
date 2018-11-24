<?php

namespace backend\modules\repayment\controllers;


use Yii;
//use frontend\modules\repayment\models\LoanBeneficiary;
//use frontend\modules\repayment\models\LoanBeneficiarySearch;
use common\models\LoanBeneficiary;
use backend\modules\repayment\models\LoanBeneficiarySearch;
use frontend\modules\repayment\models\ContactForm;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\application\models\ApplicationSearch;

/**
 * LoanBeneficiaryController implements the CRUD actions for LoanBeneficiary model.
 */
class LoanBeneficiaryController extends Controller
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
     * Lists all LoanBeneficiary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoanBeneficiarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanBeneficiary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoanBeneficiary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout="main_public";
        $model = new LoanBeneficiary();
        $model3 = new ContactForm();
        $modelEmpBenf = new EmployedBeneficiary();
        $model->scenario='loanee_registration';
        
        if ($model->load(Yii::$app->request->post())) {
        //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
        $model->created_at=date("Y-m-d H:i:s");    
        $applcantF4IndexNo=$model->f4indexno;
        $NIN=$model->NID;        
          $applicantDetails=$modelEmpBenf->getApplicantDetails($applcantF4IndexNo,$NIN);
          $applicantID=$applicantDetails->applicant_id;
          //end check using unique identifiers
          
          //check using non-unique identifiers
          if(!is_numeric($applicantID)){
          $firstname=$model->firstname;$middlename=$model->middlename;$surname=$model->surname;
          $dateofbirth=$model->date_of_birth;$placeofbirth=$model->place_of_birth;$academicInstitution=$model->learning_institution_id;
          $resultsUsingNonUniqueIdent=$modelEmpBenf->getApplicantDetailsUsingNonUniqueIdentifiers2($firstname,$middlename,$surname,$dateofbirth,$placeofbirth,$academicInstitution);
          $applicantID=$resultsUsingNonUniqueIdent->applicant_id;  
          }
          // end check using non-unique identifiers
          
          if(!is_numeric($applicantID)){
          if ($model->save()) {
            $notification='';
            return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'1','activateNotification'=>$notification]);
          }
          }else{
          $results_loanee=$model->getUser($applicantID);
          $user_id=$results_loanee->user_id;
          $username=$model->email_address;
          $password=Yii::$app->security->generatePasswordHash($model->password);
          $auth_key=Yii::$app->security->generateRandomString();
          $model->updateUserBasicInfo($username,$password,$auth_key,$user_id);
          $notification="Kindly click the link below to activate your iLMS account<br/>".'<a href=activate.php?user_id="'.$user_id.'" target="_blank"><font style="color: #cc0000">Click here to activate account</font></a>';
            return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'2','activateNotification'=>$notification]);  
          }
        } else {
            return $this->render('create', [
                'model' => $model,'model3' => $model3,
            ]);
        }
    }
    
     public function actionViewLoaneeSuccessRegistered($loaneeStatus,$activateNotification)
    {
        $this->layout="main_public";
        return $this->render('viewLoaneeSuccessRegistered', [
            'loaneeStatus'=>$loaneeStatus,'activateNotification'=>$activateNotification,
        ]);
    }

    /**
     * Updates an existing LoanBeneficiary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	    $modelLoanBeneficiary = new LoanBeneficiary();
        $model = $this->findModel($id);
		
		if($model->load(Yii::$app->request->post())){
		$NIN='';
		$applcantF4IndexNo=$model->f4indexno;
		$employeeID=$modelLoanBeneficiary->getApplicantDetails($applcantF4IndexNo,$NIN);
		$model->applicant_id=$employeeID->applicant_id;
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		  if($model->applicant_id > 0){		  
		  $applicantDetail=$modelLoanBeneficiary->getApplicantDetailsUsingApplicantID($model->applicant_id);
		  $user_id=$applicantDetail->user_id;
		  $password12=$model->password;
		  $username=$model->email_address;
          $password=Yii::$app->security->generatePasswordHash($password12);
          $auth_key=Yii::$app->security->generateRandomString();
          $modelLoanBeneficiary->updateUserBasicInfo3($username,$password,$auth_key,$user_id);
		  $fullName=$model->firstname." ".$model->middlename." ".$model->surname;
		  
          $message = "Dear ".$fullName.",\r\nKindly use the following credentials for login in iLMS.\r\nUsername: ".$username."\r\nPassword: ".$password12."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS login credentials";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($model->email_address, $subject, $message, $headers)) {	
            $sms = '<p>Information updated successful.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
          }
		}else{
		$sms = '<p>Error: Incorrect form IV index number.</p>';
        Yii::$app->getSession()->setFlash('error', $sms);
		}
		
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanBeneficiary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LoanBeneficiary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanBeneficiary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanBeneficiary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionAllLoanees()
    {
        $searchModel = new LoanBeneficiarySearch();
        $dataProvider = $searchModel->searchRepaymentInitiate(Yii::$app->request->queryParams);
		if ($searchModel->check_search=='CheckSearch') {
        $dataProvider = $searchModel->getAllLoanees(Yii::$app->request->queryParams);
		
         }		

        return $this->render('allLoanees', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionViewLoaneeDetails($id)
    {
            /*
	    $modelLoanBeneficiary = new LoanBeneficiary();
        return $this->render('viewLoaneeDetails', [
            'model' => $modelLoanBeneficiary->findApplicant($id),'applicant_id'=>$id,'modelLoanBeneficiary'=>$modelLoanBeneficiary,
        ]);
             * 
             */
        $applicant_id=$id;
        $searchModel = new ApplicationSearch();
        $searchModelLoanBeneficiary = new LoanBeneficiarySearch();
                $searchModelApplicantAssociate=new \frontend\modules\application\models\ApplicantAssociateSearch();
                $searchModelApplicantAttachment=new \frontend\modules\application\models\ApplicantAttachmentSearch();
                $searchModeleducation=new \frontend\modules\application\models\EducationSearch();
                $searchModelAllocatedLoan = new \backend\modules\allocation\models\AllocationSearch();
                $searchModelDisbursement=new \backend\modules\disbursement\models\DisbursementSearch();
        $dataProvider = $searchModel->searchHelpDesk(Yii::$app->request->queryParams);
	    $model =\backend\modules\application\models\Application::find()
                    ->where(['application.applicant_id'=>$applicant_id])
                    ->JoinWith('applicant')
                    ->joinwith(["applicant","applicant.user"])
                    ->orderBy(['application.application_id' => SORT_DESC])
                    ->one();
            $application_id=$model->application_id;
    $dataProviderApplicantAssociate = $searchModelApplicantAssociate->searchHelpDesk(Yii::$app->request->queryParams,$application_id);
    $dataProviderApplicantAttachment = $searchModelApplicantAttachment->searchAttachments(Yii::$app->request->queryParams,$application_id);
    $dataProviderEducation = $searchModeleducation->searchHelpDesk(Yii::$app->request->queryParams,$applicant_id);
    $dataProviderAllocatedLoan = $searchModelAllocatedLoan->searchAllocatedLoanHelpDesk(Yii::$app->request->queryParams,$application_id);
    $dataProviderDisbursement = $searchModelDisbursement->searchDisbursedLoan(Yii::$app->request->queryParams,$applicant_id);
        return $this->render('viewLoaneeDetails', [
                    'model' => $model,
		    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'application_id'=>$application_id,
                    'searchModelApplicantAssociate'=>$searchModelApplicantAssociate,
                    'dataProviderApplicantAssociate'=>$dataProviderApplicantAssociate,
                    'dataProviderApplicantAttachment'=>$dataProviderApplicantAttachment,
                    'searchModelApplicantAttachment'=>$searchModelApplicantAttachment,
                    'dataProviderEducation'=>$dataProviderEducation,
                    'searchModeleducation'=>$searchModeleducation,
                    'searchModelAllocatedLoan'=>$searchModelAllocatedLoan,
                    'dataProviderAllocatedLoan'=>$dataProviderAllocatedLoan,
                    'searchModelLoanBeneficiary' =>$searchModelLoanBeneficiary,
                    'dataProviderDisbursement'=>$dataProviderDisbursement,
                    'searchModelDisbursement' =>$searchModelDisbursement,
                    
        ]);
        
        
        
        
        
    }
	public function actionViewApplicationsDetails($applicant_id)
    {
	    $this->layout="default_main";
        return $this->render('viewApplicationsDetails', [
            'applicant_id' => $applicant_id,
        ]);
    }
	public function actionPrintOperations()
    {
	    $this->layout="default_main";
		$model = new LoanBeneficiary();
		if($model->load(Yii::$app->request->post())){
		$category=$model->operation;
		$applicantID=$model->applicant_id;
        return $this->render('printOperations', [
            'category' => $category,'applicant_id'=>$applicantID,
        ]);
		}
    }
	public function actionViewLoaneeDetailsRefund($id)
    {
	    $modelLoanBeneficiary = new LoanBeneficiary();
        return $this->render('viewLoaneeDetailsRefund', [
            'model' => $modelLoanBeneficiary->findApplicant($id),'applicant_id'=>$id,'modelLoanBeneficiary'=>$modelLoanBeneficiary,
        ]);
    }
	public function actionNewRefundClaim()
    {
        $searchModel = new LoanBeneficiarySearch();
        $dataProvider = $searchModel->getAllLoanees(Yii::$app->request->queryParams);

        return $this->render('newRefundClaim', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
