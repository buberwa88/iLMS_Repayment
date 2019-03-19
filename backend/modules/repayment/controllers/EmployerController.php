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
        $employerID=$id;
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
   /* 
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
	*/
	public function actionWardName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $districtId = $parents[0];
                $out = \frontend\modules\repayment\models\Employer::getWardName($districtId);
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
        $headers='';
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
        $headers='';
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
			
        }else{
            $model = \backend\modules\repayment\models\Employer::findOne($employerID);
            //deactivate employer
            //$model = new Employer(['scenario' => 'employer_rejection']);
            $model->scenario='employer_rejection';
            $modelLoanBeneficiary = new LoanBeneficiary();
            $headers = '';
            $actionID = '3';
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                $employerID = $model->employerID;
                $rejectionReason = $model->rejection_reason;
                if ($rejectionReason != '') {
                    $model->updateEmployerVerificationStatus2($employerID, $actionID, $rejectionReason);
                    $userID = $modelLoanBeneficiary->getUserIDFromEmployer($employerID);
                    $userDetails = $modelLoanBeneficiary->getUserDetailsFromUserID($userID->user_id);
                    $statusD = 0;
                    $updatedBy = $loggedin = Yii::$app->user->identity->user_id;

                    $contactPerson = \frontend\modules\repayment\models\EmployerContactPerson::find()->where(['employer_id' => $employerID])->all();
                    foreach ($contactPerson AS $contactPersonRes) {
                        $varuser_id=$contactPersonRes->user_id;
                        $modelLoanBeneficiary->deactivateUser($varuser_id, $statusD, $updatedBy);
                    }


                    //email notification
                    $message = "Dear " . $userID->employer_name . ",\r\nYour iLMS account has been deactivate due to the following reason:" . "\r\n" . $model->rejection_reason . "\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
                    $subject = "iLMS Account Deactivation";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "From: iLMS ";
                    if (mail($userDetails->email_address, $subject, $message, $headers)) {
                        //end email notification
                        $sms = '<p>Employer Deactivated!</p>';
                        Yii::$app->getSession()->setFlash('success', $sms);
                    }
                } else {
                    $sms = '<p>Operation failed,deactivation reason can not be empty!</p>';
                    Yii::$app->getSession()->setFlash('error', $sms);
                }
                return $this->redirect(['index']);
            }else {
                    return $this->render('employerDeactivate', [
                        'model' => $model, 'id' => $employerID,
                    ]);
                }

            } //end deactivate employer

            else {
            return $this->render('employerDeactivate', [
                'model' => $model, 'id' => $employerID,
            ]);
        }
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
		if($results->status==0) {
            //generate employer code for accepted employer
            //$employer_code_format="000000";
            $employer_code_format = \frontend\modules\repayment\models\Employer::EMPLOYER_CODE_FORMAT;
            $employerIdLength = strlen($employerID);
            $remained = substr($employer_code_format, $employerIdLength);
            $employerCode = $remained . $employerID;
            \backend\modules\repayment\models\Employer::updateEmployerCode($employerID, $employerCode);
            $userID = \common\models\LoanBeneficiary::getUserIDFromEmployer($employerID);
            $contactPerson = \frontend\modules\repayment\models\EmployerContactPerson::find()->where(['employer_id' => $employerID])->all();
            foreach ($contactPerson AS $contactPersonRes) {
                $varuser_id=$contactPersonRes->user_id;
            $userDetails = \common\models\LoanBeneficiary::getUserDetailsFromUserID($varuser_id);
            //end
            $verification_status = 0;
            \common\models\LoanBeneficiary::updateEmployerVerifiedEmail($employerID, $verification_status);
            \common\models\LoanBeneficiary::updateUserActivateAccount($varuser_id);
            \common\models\LoanBeneficiary::updateUserVerifyEmail($varuser_id);
        }
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
	
	public function actionCreateEmployerheslb()
    {
        $model1 = new \frontend\modules\repayment\models\Employer();
        $model2 = new \frontend\modules\repayment\models\User();
        $model2->scenario = 'heslb_employer_registration';
        $model1->scenario = 'employer_details';
        $model1->created_at=date("Y-m-d H:i:s");
        $model2->created_at=date("Y-m-d H:i:s");  
        $model2->last_login_date=date("Y-m-d H:i:s");
        if($model1->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())){
			if($model2->email_address !=''){
			$model2->username=$model2->email_address;	
			}else{
			$model2->username=strtolower($model2->firstname).mt_rand(10,1000);
			}

            $password=$model2->password;
            $model2->password_hash=Yii::$app->security->generatePasswordHash($password);
            $model2->auth_key = Yii::$app->security->generateRandomString();
            $model2->status=0;
            $model2->login_type=2;
            if($model2->validate()){

            $model1->financial_year_id=\frontend\modules\repayment\models\LoanRepaymentDetail::getCurrentFinancialYear()->financial_year_id;
            $model1->academic_year_id=\frontend\modules\repayment\models\LoanRepaymentDetail::getActiveAcademicYear()->academic_year_id;
		$employerName=$model2->employerName;
		$model1->verification_status=1;
        $loggedin=Yii::$app->user->identity->user_id;        
		$model1->employer_type_id=$model2->employer_type_id;
               
                if($model1->sector !=''){
                 $model1->nature_of_work_id=$model1->sector;   
                }
                if($model1->industry !=''){
                 $model1->nature_of_work_id=$model1->industry;   
                }
		$model1->phone_number=$model2->phone_number_employer;	
		$model1->TIN=$model2->TIN;
		$model1->employer_name = preg_replace('/\s+/', ' ',$employerName); 
        $model1->region=$model2->region;
        $model1->district=$model2->district;
        $model1->ward_id=$model2->ward_id;		

		//check if employer exist
          /*
		$results=$model1->checkEmployerExists($model1->employer_name);
		if($results>0){
		$sms = "<p>Sorry!<br/>
                   The employer exist, kindly login or contact HESLB. </p>";
            Yii::$app->getSession()->setFlash('error', $sms);	
            return $this->redirect(['/application/default/home-page']);
		//return $this->redirect(['view-employer-success', 'id' =>$results,'employer_status' =>2]);
		}
		*/
		//end check
        /*
        $password=$model2->password;        
        $model2->password_hash=Yii::$app->security->generatePasswordHash($password);
        $model2->auth_key = Yii::$app->security->generateRandomString();
        $model2->status=10;
        $model2->login_type=2;
        */
        $model2->created_by=$loggedin;		
        
		
		/*
		$model2->validate();
                            $reason1 = '';
                            if ($model2->hasErrors()) {
                                $errors = $model2->errors;
                                foreach ($errors as $key => $value) {
                                    $reason1 = $reason1 . $value[0] . '  ';
                                }
							}
		$model1->validate();
                            $reason = '';
                            if ($model1->hasErrors()) {
                                $errors = $model1->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason . $value[0] . '  ';
                                }
							}
            echo $reason1."<br/>".$reason;exit;
			*/
        //}
        //var_dump($model2->errors);exit;
        if ($model2->load(Yii::$app->request->post()) && $model2->save(false)) {
            $model1->user_id=$model2->user_id;
			//$model1->email_verification_code=589;
			$model1->email_verification_code=mt_rand(10,1000);
            if($model1->load(Yii::$app->request->post())){
             $model1->created_by=$loggedin;
		if($model1->save(false)){
			 #################create employer role #########
                                    $date=strtotime(date("Y-m-d"));
   //Yii::$app->db->createCommand("INSERT  INTO auth_assignment(item_name,user_id,created_at) VALUES('Repayment',$model2->user_id,$date)")->execute();
   Yii::$app->db->createCommand("INSERT IGNORE INTO  auth_assignment(item_name,user_id,created_at) VALUES('Repayment',$model2->user_id,$date)")->execute();
                //end
		   //end authentication insert
		   
		   $employerID=$model1->employer_id;
		   $employer_code_format=\frontend\modules\repayment\models\Employer::EMPLOYER_CODE_FORMAT;
               $employerIdLength=strlen($employerID);
               $remained=substr($employer_code_format,$employerIdLength);
                $employerCode=$remained.$employerID;
                \backend\modules\repayment\models\Employer::updateEmployerCode($employerID,$employerCode);
				$userID=\common\models\LoanBeneficiary::getUserIDFromEmployer($employerID);
				$userDetails=\common\models\LoanBeneficiary::getUserDetailsFromUserID($userID->user_id);
		   //end 
		   $verification_status=1;		   
           \common\models\LoanBeneficiary::updateEmployerVerifiedEmail($employerID,$verification_status);
		   \common\models\LoanBeneficiary::updateUserActivateAccount($userID->user_id);
           \common\models\LoanBeneficiary::updateUserVerifyEmail($userID->user_id);
		   
   //create contact person
   $modelEmployerContactPerson = new \frontend\modules\repayment\models\EmployerContactPerson();
   $modelEmployerContactPerson->employer_id=$model1->employer_id;
   $modelEmployerContactPerson->user_id=$model2->user_id;
   $modelEmployerContactPerson->role=\frontend\modules\repayment\models\EmployerContactPerson::ROLE_PRIMARY;
   $modelEmployerContactPerson->created_by=$model2->user_id;
   $modelEmployerContactPerson->created_at=$model1->created_at;
   $modelEmployerContactPerson->save(false);

                        
		    $sms = "<p>Employer Registration Successful!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);	
            return $this->redirect(['index']);
		  }
            //return $this->redirect(['view-employer-success', 'id' => $model1->employer_id]);			
            }            
        }}else {
                return $this->render('createEmployerheslb', [
                    'model1' => $model1,'model2' => $model2,
                ]);
        }}else {
            return $this->render('createEmployerheslb', [
                'model1' => $model1,'model2' => $model2,
            ]);
        }
    }
	public function actionDistrictName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $RegionId = $parents[0];
                $out = \frontend\modules\repayment\models\Employer::getDistrictName($RegionId);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }
public function actionAddContactPerson($employer_id=NULL){
        $modelUser = new \frontend\modules\repayment\models\User();	
	$modelUser->scenario = 'employer_contact_person';	
	$loggedin=Yii::$app->user->identity->user_id;
        if ($modelUser->load(Yii::$app->request->post()) && $modelUser->validate()){
	    $modelUser->username=$modelUser->email_address;		
        $password=$modelUser->password;        
        $modelUser->password_hash=Yii::$app->security->generatePasswordHash($password);
        $modelUser->auth_key = Yii::$app->security->generateRandomString();
        $modelUser->status=10;
        $modelUser->login_type=2;
		//$model->created_by =Yii::$app->user->identity->user_id;
		$modelUser->created_at =strtotime(date("Y-m-d"));
		$modelUser->updated_at =strtotime(date("Y-m-d"));
		$modelUser->last_login_date =date("Y-m-d H:i:s");
		$modelUser->date_password_changed=date("Y-m-d");
        $modelUser->created_by=Yii::$app->user->identity->user_id;		
            if($modelUser->save()) {
                
    //create contact person
   $modelEmployerContactPerson = new \frontend\modules\repayment\models\EmployerContactPerson();
   $modelEmployerContactPerson->employer_id=$employer_id;
   $modelEmployerContactPerson->user_id=$modelUser->user_id;
   $modelEmployerContactPerson->role=\frontend\modules\repayment\models\EmployerContactPerson::ROLE_SECONDARY;
   $modelEmployerContactPerson->created_by=$modelUser->created_by =Yii::$app->user->identity->user_id;
   $modelEmployerContactPerson->created_at=date("Y-m-d H:i:s");
   $modelEmployerContactPerson->save();
   //end create contact person
                
                #################create staff role #########
                                    $date=strtotime(date("Y-m-d"));
        Yii::$app->db->createCommand("INSERT  INTO auth_assignment(item_name,user_id,created_at) VALUES('Repayment',$modelUser->user_id,$date)")->execute();
                //end
				
				// here for logs
                        $old_data=\yii\helpers\Json::encode($modelUser->attributes);						
						$new_data=\yii\helpers\Json::encode($modelUser->attributes);
						$model_logs=\common\models\base\Logs::CreateLogall($modelUser->user_id,$old_data,$new_data,"user","CREATE",1);
				//end for logs
				
		    $sms="<p>Information successful added</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view','id'=>$employer_id]);
       }
		} else {
            return $this->render('addContactPerson', [
                'model' => $modelUser,'employer_id'=>$employer_id,
            ]);
        }
    }
public function actionUpdateInformation($id)
    {	
	    $loggedin=Yii::$app->user->identity->user_id;
	    
        //$employerModel = $this->findModel($id);
        $employerModel =\frontend\modules\repayment\models\Employer::findOne($id);
        $employerModel->scenario='employer_update_details';
		if($employerModel->load(Yii::$app->request->post()) && $employerModel->save()){
		    $sms="Information Updated!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view', 'id' => $employerModel->employer_id]);
	
        } else {
            return $this->render('updateInformation', [
                'employerModel' => $employerModel,
            ]);
        }
    }
	
	public function actionUpdateContactperson($id=null,$emploID=null)
    {	

        $userModel = \frontend\modules\repayment\models\User::findOne($id);
		$userModel->scenario='update_contact_person';
		if($userModel->load(Yii::$app->request->post()) && $userModel->validate()){
			$userModel1 = \frontend\modules\repayment\models\User::findOne($id);
			$userModel1->firstname=$userModel->firstname;
			$userModel1->middlename=$userModel->middlename;
			$userModel1->surname=$userModel->surname;
			$userModel1->phone_number=$userModel->phone_number;
			$userModel1->email_address=$userModel->email_address;
            $userModel1->status=$userModel->status;
			if($userModel1->save()){
			    if($userModel1->status==0){
    $contactPersDetails = \frontend\modules\repayment\models\EmployerContactPerson::find()->where(['user_id'=>$id])->one();
    $contactPersDetails->is_active=2;
    $contactPersDetails->save();
                }else{
    $contactPersDetailsx = \frontend\modules\repayment\models\EmployerContactPerson::find()->where(['user_id'=>$id])->one();
    $contactPersDetailsx->is_active=1;
    $contactPersDetailsx->save();
                }
		    $sms="Information Updated!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view', 'id' => $emploID]);
			}
        } else {
            return $this->render('updateContactperson', [
                'model' => $userModel,'employer_id'=>$emploID
            ]);
        }
    }
	
	public function actionChangePasswordContactp($id=null,$emploID=null)
    {	
	    
        $userModel = \frontend\modules\repayment\models\User::findOne($id);
		$userModel->scenario='change_pwd_contact_person';
		if($userModel->load(Yii::$app->request->post()) && $userModel->validate()){			
			$userModel1 = \frontend\modules\repayment\models\User::findOne($id);
			$password=$userModel->password;        
            $userModel1->password_hash=Yii::$app->security->generatePasswordHash($password);
            $userModel1->auth_key = Yii::$app->security->generateRandomString();
			if($userModel1->save()){			
		    $sms="Information Updated!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view', 'id' => $emploID]);
			}
        } else {
            return $this->render('changePasswordContactp', [
                'model' => $userModel,'employer_id'=>$emploID
            ]);
        }
    }
	public function actionProgrammeName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $InstitutionId = $parents[0];
                $out = \frontend\modules\repayment\models\Employer::getProgrammes($InstitutionId);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }
	public function actionSettingReasons() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $status = $parents[0];
                $out = \backend\modules\repayment\models\RefundStatusReasonSetting::getRefundStatusReasonSett($status);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }
    public function actionVerificationResponse($refund_type_id,$retired_status) {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $status = $parents[0];
                $out = \backend\modules\repayment\models\RefundVerificationResponseSetting::getRefundStatusResponseSetting($status,$refund_type_id,$retired_status);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }
}
