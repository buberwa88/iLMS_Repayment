<?php

namespace frontend\modules\repayment\controllers;
use Yii;
//use yii\web\Controller;
use \common\components\Controller;
use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\ResetPassword;
use \common\models\LoanBeneficiary;
use \common\models\User;
use frontend\modules\repayment\models\Employer;
use frontend\modules\repayment\models\EmployedBeneficiary;

/**
 * Default controller for the `repayment` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
	 
	  public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['captcha','index','notification','notification-beneficiary','password-reset-beneficiary','password-reset-category','view-beneficiary-details','password-reset-employer','view-employer-details','recover-password-employer','password-recover','recover-password','confirmed-details-beneficiary','index-beneficiary','index-treasury'],
                        'allow' => true,
                    ],
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
/*
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(setting::ADMIN_EMAIL_ADDRESS)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
*/
	 
	 
	 
	 
	 
    public function actionIndex()
    {
        $this->layout="main_private";
        return $this->render('index');
    }
	public function actionIndexBeneficiary()
    {
        $this->layout="main_private_beneficiary";
        return $this->render('indexBeneficiary');
    }
	public function actionIndexTreasury()
    {
        $this->layout="main_private_treasury";
        return $this->render('indexTreasury');
    }
    public function actionNotification()
    {  
        $this->layout="main_private";
  return $this->render('notification');
    }
    public function actionNotificationBeneficiary()
    {  
        $this->layout="main_private_beneficiary";
  return $this->render('notification');
    }
    public function actionControlNumberConfirm($controlNumber,$amount)
    {  
        $this->layout="main_private";
        $model = new LoanRepayment();
        $model->updatePaymentAfterGePGconfirmPaymentDone($controlNumber,$amount);
  //return $this->render('notification');
    }
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
	public function actionConfirmedSendEmail($user_id)
    {
        $this->layout="main_public";
		$model = new ResetPassword();
		
		$modelLoanBeneficiary = new LoanBeneficiary();
		if($id !=0){
		$applicantDetail=$modelLoanBeneficiary->getApplicantDetailsUsingApplicantID($id);
		$applicantLearningInstitution=$modelLoanBeneficiary->getApplicantLearningInstitution($id);
		return $this->render('viewBeneficiaryDetails', [
            'model' =>$model,'applicantDetail'=>$applicantDetail,'id'=>$id,'email'=>$email,'applicantLearningInstitution'=>$applicantLearningInstitution,
        ]);
		}else{
		return $this->render('viewBeneficiaryDetails', [
            'model' =>$model,'id' =>$id,'email'=>'',
        ]);
		}
    }
	public function actionPasswordResetCategory()
    {
           $this->layout="main_public";
           $model = new ResetPassword();		   

            return $this->render('passwordResetCategory', [
                'model' => $model,
            ]);
        
    }
	public function actionPasswordRecover()
    {
           $this->layout="main_public";
           $modelUser = new User();	
           $modelLoanBeneficiary = new LoanBeneficiary();		   
		   //$userModel = $modelUser->findModel($id); 
		   $modelUser->scenario='recover_password';
        if ($modelUser->load(Yii::$app->request->post())) {
        $username=$modelUser->recover_password;
		$results=$modelLoanBeneficiary->getUserDetailsGeneral($username);
		if($results !=0){
		    $employerIdN=$results->user_id;
		    $encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$plaintext = "$employerIdN";
			$output = openssl_encrypt($plaintext, $encrypt_method, $key, 0, $iv);
			$variableToget=base64_encode($output);
		//email notification
		$url = 'http://localhost/ilmsR/frontend/web/index.php?r=repayment/default/recover-password&id='.$variableToget;
          $message = "Dear ".$results->firstname." ".$results->middlename." ".$results->surname.",\r\nClick the link below to recover your password.\r\n".$url."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "Recover iLMS password";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($results->email_address, $subject, $message, $headers)) {
		    $sms="<p>Kindly login into your email to recover your iLMS password</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
			return $this->redirect(['/site/login']);
        /*			
		return $this->render('viewRecoveryResults', [
            'model' =>$modelUser,'sms'=>$sms,'id' =>$results->user_id,
			]);
			*/
		}else{
			echo "FAILED";
		}
		}else{
		$sms="<p>Error: Failed to match with the record available!</p>";
            Yii::$app->getSession()->setFlash('error', $sms);
			return $this->redirect(['/site/login']);
		/*
		return $this->render('viewRecoveryResults', [
            'model' =>$modelUser,'id'=>0,
			]);
		*/	
		}
        } else {
            return $this->render('passwordRecover', [
                'model' => $modelUser,
            ]);
        }
    }
	public function actionViewEmployerDetails($id)
    {
        $this->layout="main_public";
		$modelEmployer = new Employer();
		$modelLoanBeneficiary = new LoanBeneficiary();
		if($id !=0){
		$employerDetail=$modelEmployer->getEmployerDetaisUsingEmployerID($id);
		$user_id=$employerDetail->user_id;
		$userDetails=$modelLoanBeneficiary->getUserDetailsFromUserID($user_id);
		//email notification
		$url = 'http://localhost/ilmsR/frontend/web/index.php?r=repayment/default/recover-password-employer&id='.$employerDetail->user_id;
          $message = "Dear ".$employerDetail->employer_name.",\r\nClick the link below to recover your password.\r\n".$url."\r\n \r\n Sincerely,\r\nHigher Education Students' Loan Board\r\nPlot No. 8, Block No. 46, Sam Nujoma Road, Mwenge,\r\nP. O. Box 76068\r\nDar es Salaam.\r\nTanzania.";
          $subject = "HESLB-Employer Account";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($userDetails->email_address, $subject, $message, $headers)) {		
		$sms="Kindly visit your email to recover your password";
		return $this->render('viewEmployerDetails', [
            'model' =>$modelEmployer,'sms'=>$sms,'id' =>$id,
			]);
			}
			//end email notification
		}else{
		return $this->render('viewEmployerDetails', [
            'model' =>$modelEmployer,'id' =>$id,'email'=>'',
        ]);
		}
    }
	public function actionRecoverPassword($id)
    {
	    $this->layout="main_public";		 
        $modelUser = new EmployedBeneficiary();
        //decode
			$encrypt_method = "aes128";
			$secret_key = 'ucc2018';
			$secret_iv = 'ilms-ucc';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$resutds=$id;
			$loan_beneficiary_id = openssl_decrypt(base64_decode($resutds), $encrypt_method,   $key, 0, $iv);
	    //end decode
		$loggedin=$loan_beneficiary_id;		
		$userModel = $modelUser->findModel($loan_beneficiary_id);
		$userModel->scenario='employer_change_password';	

        if ($userModel->load(Yii::$app->request->post())){
		$password=$userModel->password;               
        $userModel->password_hash=Yii::$app->security->generatePasswordHash($password);
        $userModel->auth_key = Yii::$app->security->generateRandomString();
		$password_hash=$userModel->password_hash;$auth_key=$userModel->auth_key;
		$modelUser->updateUserRecoverPassword($loggedin,$password_hash,$auth_key);
        if($userModel->save()){
            $sms="<p>Password successful recovered, kindly login!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);		
            return $this->redirect(['/site/login']);
			//return $this->redirect(['/site/login','activated_successful'=>2]);
			}
        } else {
            return $this->render('recoverPassword', [
                'modelUser' => $userModel,'id' => $loan_beneficiary_id,
            ]);
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
}
