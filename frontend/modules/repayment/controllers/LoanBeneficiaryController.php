<?php

namespace frontend\modules\repayment\controllers;

use Yii;
//use frontend\modules\repayment\models\LoanBeneficiary;
//use frontend\modules\repayment\models\LoanBeneficiarySearch;
use \common\models\LoanBeneficiary;
use \common\models\LoanBeneficiarySearch;
use frontend\modules\repayment\models\ContactForm;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\ResetPassword;
use \common\models\User;
use frontend\modules\repayment\models\EmployerSearch;

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
          $model->applicant_id=$applicantID;
          
          if ($model->save()) {
		    $fullName=$model->firstname." ".$model->middlename." ".$model->surname;
			$loan_beneficiary_id=$model->loan_beneficiary_id;
		  //generate encoded variable   
			$encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$plaintext = "$loan_beneficiary_id";
			$output = openssl_encrypt($plaintext, $encrypt_method, $key, 0, $iv);
			$variableToget=base64_encode($output);
			//end generating encoded variable
		
		  $url = 'http://localhost/ilms/frontend/web/index.php?r=repayment/loan-beneficiary/verify-beneficiaryemail&id='.$variableToget;
          $message = "Dear ".$fullName.",\r\nClick the link below to verify your email account.\r\n".$url."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS email verification";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($model->email_address, $subject, $message, $headers)) {	
            $sms = '<p>To complete registration!<br/>Kindly login in your email to verify your account.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
		    return $this->redirect(['/site/login']);
            //$notification='';
            //return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'1','activateNotification'=>$notification]);
          }
		  /*
		  if(!is_numeric($applicantID)){
		  
          }else{
          $results_loanee=$model->getUser($applicantID);
          $user_id=$results_loanee->user_id;
          $username=$model->email_address;
          $password=Yii::$app->security->generatePasswordHash($model->password);
          $auth_key=Yii::$app->security->generateRandomString();
          $model->updateUserBasicInfo($username,$password,$auth_key,$user_id);
          $notification="Kindly click the link below to activate your iLMS account<br/>".'<a href=activate.php?user_id="'.$user_id.'" target="_blank"><font style="color: #cc0000">Click here to activate account</font></a>';		  
		  
			}
		  
		  
            return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'2','activateNotification'=>$notification]);  
			*/
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_beneficiary_id]);
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
	public function actionVerifyBeneficiaryemail($id)
    {
        $this->layout="main_public";
		$modelLoanBeneficiary=new LoanBeneficiary();

        //decode
			$encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$resutds=$id;
			$loan_beneficiary_id = openssl_decrypt(base64_decode($resutds), $encrypt_method,   $key, 0, $iv);
	    //end decode
		$results=$modelLoanBeneficiary->getBeneficiaryDetails($loan_beneficiary_id);
		if($results !=0){
		if($results->email_verified==0){
		   $verification_status=1;
		   $modelLoanBeneficiary->updateBeneficiaryVerifiedEmail($loan_beneficiary_id,$verification_status);
           //$username=$results->email_address;		   
           $password12=$results->password;	
           $applicantID=$results->applicant_id;	
		   $fullName=$results->firstname." ".$results->middlename." ".$results->surname;
           if($applicantID > 0){
          $results_loanee=$modelLoanBeneficiary->getUser($applicantID);
          $user_id=$results_loanee->user_id;
		  $results_user=$modelLoanBeneficiary->getUserDetailsFromUserID($user_id);
		  $username=$results_user->username;
          //$username=$model->email_address;
          $password=Yii::$app->security->generatePasswordHash($password12);
          $auth_key=Yii::$app->security->generateRandomString();
          $modelLoanBeneficiary->updateUserBasicInfo3($username,$password,$auth_key,$user_id);
		  
          $message = "Dear ".$fullName.",\r\nKindly use the following credentials for login in iLMS.\r\nUsername: ".$username."\r\nPassword: ".$password12."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS login credentials";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($results->email_address, $subject, $message, $headers)) {	
            $sms = '<p>Email account successful verified, kindly login in your email to get credentials for login in iLMS.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
		    return $this->redirect(['/site/login']);
            //$notification='';
            //return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'1','activateNotification'=>$notification]);
          }
		  
		   //$sms = '<p>Email account successful verified,kindly login in your email account to get username and password for iLMS login credentials!</p>';
            //Yii::$app->getSession()->setFlash('success', $sms);
			}else{
			$sms = '<p>Email account successful verified, you will get notification in your email after your iLMS account being verified by HESLB!</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
			}
		   }else if($results->email_verified==1){
		   $sms = '<p>Email account already verified!</p>';
		   Yii::$app->getSession()->setFlash('warning', $sms);
		   }else{
		   $sms = '<p>Error: Unable to recognize your iLMS account!</p>';
            Yii::$app->getSession()->setFlash('error', $sms);	
		   }
		   }else{
		   $sms = '<p>Error: Unable to recognize your iLMS account!</p>';
            Yii::$app->getSession()->setFlash('error', $sms);		   
		   }
		return $this->redirect(['/site/login']);
		
    }
	/*
	public function actionPasswordResetBeneficiary()
    {
           $this->layout="main_public";
           $model = new ResetPassword();
		   $model->scenario='beneficiary_reset_password';
           $modelLoanBeneficiary = new LoanBeneficiary();		   
		   
        if ($model->load(Yii::$app->request->post())) {
        $f4indexno=$model->f4indexno;
		$dateofbirth=$model->dateOfBirth;
		$placeofbirth=$model->ward;
		$learningInstitution=$model->learningInstitution;
		$currentEmail=$model->beneficiaryCurrentEmail;
		$applicantID=$modelLoanBeneficiary->getApplicantDetailsUsingNonUniqueIdentifiers($f4indexno, $dateofbirth, $placeofbirth, $learningInstitution);
		return $this->redirect(['view-beneficiary-details', 'id' =>$applicantID,'email'=>$currentEmail]);
        } else {
            return $this->render('passwordResetBeneficiary', [
                'model' => $model,
            ]);
        }
    }
	*/
	public function actionPasswordResetBeneficiary()
    {
           $this->layout="main_public";
           $model = new ResetPassword();
		   $model->scenario='beneficiary_reset_password';
           $modelLoanBeneficiary = new LoanBeneficiary();		   
		   
        if ($model->load(Yii::$app->request->post())) {
        $f4indexno=$model->f4indexno;
		$dateofbirth=$model->dateOfBirth;
		$placeofbirth=$model->ward;
		$learningInstitution=$model->learningInstitution;
		$currentEmail=$model->beneficiaryCurrentEmail;
		$applicantID=$modelLoanBeneficiary->getApplicantDetailsUsingNonUniqueIdentifiers($f4indexno, $dateofbirth, $placeofbirth, $learningInstitution);
		return $this->redirect(['view-beneficiary-details', 'id' =>$applicantID,'email'=>$currentEmail]);
        } else {
            return $this->render('passwordResetBeneficiary', [
                'model' => $model,
            ]);
        }
    }
	public function actionViewBeneficiaryDetails($id,$email)
    {
        $this->layout="main_public";
		$model = new ResetPassword();
		
		$modelLoanBeneficiary = new LoanBeneficiary();
		if($id !=0){
		$applicantDetail=$modelLoanBeneficiary->getApplicantDetailsUsingApplicantID($id);
		$applicantLearningInstitution=$modelLoanBeneficiary->getApplicantLearningInstitution($id);
		//$user_id=$applicantDetail->user_id;
		//$modelLoanBeneficiary->updateUserBasicInfo3($username,$password,$auth_key,$user_id);
		return $this->render('viewBeneficiaryDetails', [
            'model' =>$model,'applicantDetail'=>$applicantDetail,'id'=>$id,'email'=>$email,'applicantLearningInstitution'=>$applicantLearningInstitution,
        ]);
		}else{
		       $sms = "<p>Sorry: No matching is found! </p>";
            Yii::$app->getSession()->setFlash('error', $sms);	
            return $this->redirect(['/site/login']);
			/*
		return $this->render('viewBeneficiaryDetails', [
            'model' =>$model,'id' =>$id,'email'=>'',
        ]);
		*/
		}
    }
	public function actionConfirmedDetailsBeneficiary($id,$email)
    {
           $this->layout="main_public";
           $modelUser = new User();	
           $modelLoanBeneficiary = new LoanBeneficiary();		   
		$results=$modelLoanBeneficiary->getUserDetailsFromUserID($id);
		if($results !=0){		
		//echo $email;
		//exit;
		$email_address=trim($email);
		//encode
		    $encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$resutds=$results->user_id;
			$loan_beneficiary_id = openssl_decrypt(base64_decode($resutds), $encrypt_method,   $key, 0, $iv);
	    //end decode
		  $user_id=$results->user_id;
		  $password12=$results->username;
		  $username=$results->username;
          $password=Yii::$app->security->generatePasswordHash($password12);
          $auth_key=Yii::$app->security->generateRandomString();
          $modelLoanBeneficiary->updateUserBasicInfo3($username,$password,$auth_key,$user_id);
		  $fullName=$results->firstname." ".$results->middlename." ".$results->surname;
		  
          $message = "Dear ".$fullName.",\r\nKindly use the following credentials for login in iLMS.\r\nUsername: ".$username."\r\nPassword: ".$password12."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "iLMS login credentials";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
		  echo $email_address;
		  exit;
          if (mail($email_address, $subject, $message, $headers)) {	
            $sms = '<p>Your iLMS account successful activated, kindly login in your email to get credentials for login in iLMS.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
		    return $this->redirect(['/site/login']);
            //$notification='';
            //return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'1','activateNotification'=>$notification]);
          }	
		
		//email notification
		}else{
		return $this->render('viewActivationResults', [
            'model' =>$modelUser,'id'=>0,
			]);
		}        
    }
	public function actionViewloanStatementBeneficiary()
    {
        $this->layout="main_private_beneficiary";	
	    $loggedin=Yii::$app->user->identity->user_id;
        $applicant=EmployerSearch::getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;	    
        return $this->render('../employed-beneficiary/viewLoanStatement', [
            'applicantID'=>$applicantID,
        ]);
    }
	public function actionTestxml()
    {
        $book = fluidxml();

     $book->add('title', 'The Theory Of Everything')
     ->add('author', 'S. Hawking')
     ->add('chapters', true)
         ->add('chapter', 'Ideas About The Universe', ['id' => 1])
         ->add('chapter', 'The Expanding Universe',   ['id' => 2]);
		 echo $book;
    }
}
