<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\Employer;
use backend\modules\repayment\models\EmployerSearch;
use frontend\modules\application\models\User;
use frontend\modules\repayment\models\ContactForm;
use backend\modules\application\models\Ward;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \common\models\LoanBeneficiary;
use backend\modules\repayment\models\EmployedBeneficiarySearch;
use \common\components\Controller;
use frontend\modules\repayment\models\EmployerPenaltySearch;
use frontend\modules\repayment\models\EmployerPenaltyPaymentSearch;

/**
 * EmployerController implements the CRUD actions for Employer model.
 */
class EmployerController extends Controller
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
     * Lists all Employer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployerSearch();
        $dataProvider = $searchModel->searchEmployerConfirmedEmail(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionIndexNotification()
    {
        $searchModel = new EmployerSearch();
        $dataProvider = $searchModel->searchEmployerConfirmedEmail(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionNewEmployer()
    {
        $searchModel = new EmployerSearch();
        $dataProvider = $searchModel->searchNewEmployer(Yii::$app->request->queryParams);

        return $this->render('newemployer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Employer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
	    $modelEmployer = new Employer();
		$searchModelEmployedBeneficiaries = new EmployedBeneficiarySearch();
        $dataProvider = $searchModelEmployedBeneficiaries->getEmployeesUnderEmployer(Yii::$app->request->queryParams,$employerID);
        return $this->render('view', [
            'model' =>$this->findModel($id),
			'id'=>$id,
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModelEmployedBeneficiaries,
        ]);
    }
	public function actionViewEmployerDetails($id)
    {
        return $this->render('viewEmployerDetails', [
            'model' => $this->findModel($id),'id'=>$id,
        ]);
    }
    public function actionViewNewEmployer($id)
    {
        return $this->render('viewNewEmployer', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewEmployerSuccess($id)
    {
        $this->layout="main_home";
        return $this->render('viewEmployerSuccess', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Employer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
    public function actionCreate()
    {
        $model = new Employer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
     * 
     */
    public function actionCreate()
    {
        $this->layout="main_home";
        $model1 = new Employer();
        $model2 = new User();
		$model3 = new ContactForm();
        $model2->scenario = 'employer_registration';
        $model1->scenario = 'employer_details';
        $model1->created_at=date("Y-m-d");
        $model2->created_at=date("Y-m-d H:i:s");  
        $model2->last_login_date=date("Y-m-d H:i:s");
       if($model1->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())){
        $model1->email_address=$model2->email_address;   
        $model2->username=$model2->email_address; 
        //$model1->employer_code='wsed215';
        $model1->physical_address=$model1->postal_address;
        $password=$model2->password1;
        $model2->password_hash=Yii::$app->security->generatePasswordHash($password);
        $model2->auth_key = Yii::$app->security->generateRandomString();
        $model2->status=10;
        $model2->login_type=5;       
        
        } 
        //if ($model1->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post()) && $model1->save() && $model2->save()) {
        if ($model2->load(Yii::$app->request->post()) && $model2->save()) {
            $model1->user_id=$model2->user_id;
            if($model1->load(Yii::$app->request->post()) &&  $model1->save()){                
            return $this->redirect(['view-employer-success', 'id' => $model1->employer_id]);
            }            
        } else {
            return $this->render('create', [
                'model1' => $model1,'model2' => $model2,'model3'=>$model3,
            ]);
        }
    }

    /**
     * Updates an existing Employer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Employer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionWardName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $districtId = $parents[0];
                $out = Ward::getWardName($districtId);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    /**
     * Finds the Employer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionEmployerVerificationStatus($employerID,$actionID)
    {
        $model = new Employer();   
        $modelLoanBeneficiary = new LoanBeneficiary();		
        if($actionID==1){
		$model->updateEmployerVerificationStatus($employerID,$actionID);
		//generate employer code for accepted employer
		       $employer_code_format="000000";
               $employerIdLength=strlen($employerID);
               $remained=substr($employer_code_format,$employerIdLength);
                $employerCode=$remained.$employerID;
                $model->updateEmployerCode($employerID,$employerCode);
				$userID=$modelLoanBeneficiary->getUserIDFromEmployer($employerID);
				$userDetails=$modelLoanBeneficiary->getUserDetailsFromUserID($userID->user_id);
		        //$userID_id=$userID->user_id;
		//end 
		    //generate encoded variable   
			$encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$plaintext = "$employerID";
			$output = openssl_encrypt($plaintext, $encrypt_method, $key, 0, $iv);
			$variableToget=base64_encode($output);
			//end generating encoded variable
		
		$url = 'http://localhost/ilmsR/frontend/web/index.php?r=repayment/employer/employer-activate-account&id='.$variableToget;
          $message = "Dear ".$userID->employer_name.",\r\nClick the link below to activate your HESLB account.\r\n".$url."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS activate account";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($userDetails->email_address, $subject, $message, $headers)) {	
            $sms = '<p>Employer Accepted!</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
			}
        }
        if($actionID==2){
		$model->updateEmployerVerificationStatus($employerID,$actionID);
            $sms = '<p>Employer Pending Verification!</p>';
            Yii::$app->getSession()->setFlash('warning', $sms);
        }
        if($actionID==3){		
            return $this->render('rejectEmployer', [
            'model' => $this->findModel($employerID),'id'=>$employerID,
        ]);
        }
           
            return $this->redirect(['index']);
      }
	 /* 
	public function actionEmployerDeactivate($id)
    {
	    $model=$this->findModel($id);
		$model->scenario='employer_rejection';
		$modelLoanBeneficiary = new LoanBeneficiary();
		$actionID='3';
		//$model->rejection_reason='';
		//if($model->load(Yii::$app->request->post())){
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		$employerID=$id;
		$rejectionReason=$model->rejection_reason;	
		
		if($rejectionReason !=''){
		$model->updateEmployerVerificationStatus2($employerID,$actionID,$rejectionReason);
		$userID=$modelLoanBeneficiary->getUserIDFromEmployer($employerID);
	    $userDetails=$modelLoanBeneficiary->getUserDetailsFromUserID($userID->user_id);
          //email notification
          $message = "Dear ".$userID->employer_name.",\r\nYour iLMS account has been deactivate due to the following reason:"."\r\n".$model->rejection_reason."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS Account Deactivation";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($userDetails->email_address, $subject, $message, $headers)) {	
         //end email notification		  
		$sms = '<p>Employer Rejected!</p>';
		Yii::$app->getSession()->setFlash('success', $sms);
		}
		}else{
		$sms = '<p>Operation Failed,Rejection Reason can not be empty!</p>';
		Yii::$app->getSession()->setFlash('error', $sms);
		}
		   //$sms = '<p>Employer Deactivated!</p>';
		   //Yii::$app->getSession()->setFlash('success', $sms);
			return $this->redirect(['index']);
			}else{
			return $this->render('employerDeactivate', [
            'model' => $this->findModel($id),
        ]);
		}
    }
	*/
	public function actionEmployerDeactivate()
    {
		$model = new Employer(['scenario' => 'employer_rejection']);
		$modelLoanBeneficiary = new LoanBeneficiary();
		
		$actionID='3';
		if ($model->load(Yii::$app->request->post())) {
		$employerID=$model->employerID;
		$rejectionReason=$model->rejection_reason;
		if($rejectionReason !=''){
		$model->updateEmployerVerificationStatus2($employerID,$actionID,$rejectionReason);
		$userID=$modelLoanBeneficiary->getUserIDFromEmployer($employerID);
	    $userDetails=$modelLoanBeneficiary->getUserDetailsFromUserID($userID->user_id);
		$statusD=0;
		$updatedBy=$loggedin=Yii::$app->user->identity->user_id;
		$modelLoanBeneficiary->deactivateUser($userID->user_id,$statusD,$updatedBy);
          //email notification
          $message = "Dear ".$userID->employer_name.",\r\nYour iLMS account has been deactivate due to the following reason:"."\r\n".$model->rejection_reason."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS Account Deactivation";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($userDetails->email_address, $subject, $message, $headers)) {	
         //end email notification		  
		$sms = '<p>Employer Deactivated!</p>';
		Yii::$app->getSession()->setFlash('success', $sms);
		}
		}else{
		$sms = '<p>Operation failed,deactivation reason can not be empty!</p>';
		Yii::$app->getSession()->setFlash('error', $sms);
		}
			return $this->redirect(['index']);
			}
    }

    public function actionEmployerConfirmheslb($employerID,$actionID)
    {
        $model = new Employer();   		
        if($actionID==1){
		$model->updateEmployerVerificationStatus($employerID,$actionID);
            $sms = '<p>Employer Confirmed!</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
			
        }
        if($actionID==3){		
            return $this->render('employerDeactivate', [
            'model' => $this->findModel($employerID),'id'=>$employerID,
        ]);
        }		
            return $this->redirect(['index']);
      }
	  public function actionActivateAccountheslb($employerID)
    {
        $this->layout="main_public";
		$modelLoanBeneficiary=new LoanBeneficiary();

        //decode
		/*
			$encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$resutds=$id;
			$employerID = openssl_decrypt(base64_decode($resutds), $encrypt_method,   $key, 0, $iv);
			*/
	    //end decode
		$userID=\common\models\LoanBeneficiary::getUserIDFromEmployer($employerID);
		$results=\common\models\LoanBeneficiary::getUserDetailsFromUserID($userID->user_id);
		if($userID !=0){
		if($results->status==0){
		   //generate employer code for accepted employer
		       $employer_code_format="000000";
               $employerIdLength=strlen($employerID);
               $remained=substr($employer_code_format,$employerIdLength);
                $employerCode=$remained.$employerID;
                \backend\modules\repayment\models\Employer::updateEmployerCode($employerID,$employerCode);
				$userID=\common\models\LoanBeneficiary::getUserIDFromEmployer($employerID);
				$userDetails=\common\models\LoanBeneficiary::getUserDetailsFromUserID($userID->user_id);
		   //end 
		   $verification_status=0;		   
           \common\models\LoanBeneficiary::updateEmployerVerifiedEmail($employerID,$verification_status);
		   \common\models\LoanBeneficiary::updateUserActivateAccount($userID->user_id);
           \common\models\LoanBeneficiary::updateUserVerifyEmail($userID->user_id);		   
		   $sms = '<p>Account activated successful!</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
		   }else if($results->status==10){
		   $sms = '<p>Account already activated!</p>';
		   Yii::$app->getSession()->setFlash('warning', $sms);
		   }else{
		   $sms = '<p>Error: Unable to recognize iLMS account!</p>';
            Yii::$app->getSession()->setFlash('error', $sms);	
		   }
		   }else{
		   $sms = '<p>Error: Unable to recognize iLMS account!</p>';
            Yii::$app->getSession()->setFlash('error', $sms);		   
		   }
		return $this->redirect(['view','id'=>$employerID]);
		
    }
    /*
	 public function actionRejectEmployer($id)
    {	    
        return $this->render('rejectEmployer', [
            'model' => $this->findModel($id),'employerID'=>$id,
        ]);
    }
	*/
	public function actionEmployerPenalty()
    {
        $searchModel = new EmployerPenaltySearch();
        $dataProvider = $searchModel->searchPenaltyheslb(Yii::$app->request->queryParams);

        return $this->render('employerPenalty', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionEmployerPenaltyPayment()
    {
        $searchModel = new EmployerPenaltyPaymentSearch();
        $dataProvider = $searchModel->searchPenaltyPaymentheslbPaid(Yii::$app->request->queryParams);

        return $this->render('employerPenaltyPayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionEmployerPenaltyBill()
    {
		$this->layout="default_main";
        $searchModel = new EmployerPenaltyPaymentSearch();
        $dataProvider = $searchModel->searchPenaltyBillsheslb(Yii::$app->request->queryParams);

        return $this->render('employerPenaltyBill', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionCancelPenalty($id)
    {
		$model = \frontend\modules\repayment\models\EmployerPenalty::findOne($id);
        $model->scenario = 'Cancell_employer_penalty2';		
        

        if ($model->load(Yii::$app->request->post())){
        $model->is_active=0;
		$model->canceled_by=Yii::$app->user->identity->user_id;
		$model->canceled_at=date("Y-m-d H:i:s");
        }
		if($model->load(Yii::$app->request->post()) && $model->save()) {
			$sms = '<p>Penalty Cancelled successful!</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
         return $this->redirect(['employer-penalty']);
        } else {
            return $this->render('cancelPenalty', [
                'model' => $model
            ]);
        }
    }
		  
}
