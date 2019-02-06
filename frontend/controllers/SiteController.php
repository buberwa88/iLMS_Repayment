<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\modules\application\rabbit\Producer;
/**
 * Site controller
 */
class SiteController extends Controller
{
public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
    
        if (\Yii::$app->user->isGuest) {
            $this->layout = "main_public";
            return $this->redirect(['/application/default/home-page']);
        } else {
        $login_type=\Yii::$app->user->identity->login_type;
	if($login_type ==2){
        return $this->redirect(['repayment/default/index']);    
         }else if($login_type ==1){
             //application%2Fdefault%2Fmy-application-index
        $this->layout = "main_private_beneficiary";
     return $this->redirect(['application/default/index']);    
         }else if($login_type ==4){
             $this->getInstitutionsession();
        
             //echo $session['learn_institution_id'];
           //  exit();
         return $this->redirect(['disbursement/default/index']);  
         }else if($login_type ==3){
             $this->getInstitutionsession();
        
         return $this->redirect(['allocation/default/index']);  
         }else if($login_type ==2){
        //$this->layout = "main_private";
        //return $this->render('index'); 
        return $this->redirect(['repayment/default/index']);		
         }else if($login_type ==6){
		return $this->redirect(['repayment/default/index-treasury']); 
		 }else{		
            //$this->layout = "main_private";
            //return $this->render('index');
			  $this->layout = "main_public";             
              Yii::$app->user->logout();
			  Yii::$app->session->setFlash('error', 'Sorry ! You do not have enough permission contact your system administrator for help');
            return $this->redirect(['login']);
			}
        }
    }
   public function actionDashboard()
    {
       if (!\Yii::$app->user->isGuest) {
        return $this->render('dashboard');
         }  else {
     $this->layout="main_home";
      return $this->redirect(['/application/default/home-page']);            
         }
    
}
 public function actionChangePassword333() {
 //       $this->layout = "main_public_beneficiary";
     //  public $layout = "main_public_beneficiary"PasswordChangeForm;
     $model = new \common\models\PasswordChangeForm();    
       if ($model->load(Yii::$app->request->post())) {
              $id = Yii::$app->user->identity->user_id;
              $surname = strtoupper(trim(Yii::$app->user->identity->surname));
                
        $model =  \common\models\User::find()->where([
                    'user_id' => $id
                ])->one();
        $oldpasswd = $model->password_hash;
            if ((Yii::$app->getSecurity()->validatePassword($model->password, $oldpasswd)) != TRUE) {
                $surname = strtoupper(trim(Yii::$app->user->identity->surname));
                $lastname=strtoupper(trim($model->lastName));
                if($surname==$lastname){
                $new_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->password_hash = $new_password_hash;
                if ($model->save(false)) {
                    $model->is_default_password = 0;
                    if ($model->save(false)) {
                      $sms="<p>You have successfully recovered your password,Click the Login Tab to login.Thanks!!!</p>";
                       Yii::$app->getSession()->setFlash('success', $sms);
                        return $this->redirect(['application/default/home-page']);
                    }
                } else {
                    return $this->render('change_password', ['model' => $model]);
                }
                }else{
                    Yii::$app->user->logout();
                //    return $this->goHome();
    $sms="<p>Sorry! You have successfully recovered your password</p>";
    Yii::$app->getSession()->setFlash('errors', $sms);
    return $this->redirect(['application/default/home-page']);
                }
            } else {
                \Yii::$app->session->setFlash('errorMessage', 'Please enter new password!');
                $model->addError('password', 'New Password can not be the same as default password!');
                return $this->render('change_password', ['model' => $model]);
            }
        } else {
            return $this->render('change_password', ['model' => $model]);
       }
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
//    public function actionLogin()
//    {
//          $this->layout="main_public";
//        if (!Yii::$app->user->isGuest) {
//              $this->layout="main_home";
//            return $this->goHome();
//        }
//
//        $model = new LoginForms();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            return $this->render('login_all', [
//                'model' => $model,
//            ]);
//        }
//    }
// 
    public function actionLogin()
    {
          $this->layout="main_public";
        if (!Yii::$app->user->isGuest) {
              $this->layout="main_home";
            return $this->goHome();
        }

        $model = new \common\models\LoginForms();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login_all', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

       return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
 
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
 
 function getInstitutionsession(){
     //find the institution Id 
      $model=  \common\models\Staff::findOne(["user_id"=>Yii::$app->user->identity->user_id]);
     
     //end 
     /*
      * Set global
      */
       $session = Yii::$app->session;
        if (isset($session['learn_institution_id'])){
          $session->remove('learn_institution_id');
          unset($session['learn_institution_id']);
               if(count($model)>0){
        $session['learn_institution_id'] =$model->learning_institution_id;  
              }
        }
        else{
                    if(count($model)>0){
        $session['learn_institution_id'] =$model->learning_institution_id;  
              }
        }
 
 }
public function actionChangePassword3(){
  $model = new \common\models\PasswordChangeForm();
 return $this->render('change_password', ['model' => $model]);

}
 public function actionChangePassword22() {
        $this->layout = "main_public_beneficiary";
        //  public $layout = "main_public_beneficiary";
        $id = Yii::$app->user->identity->user_id;
        $model =  \common\models\User::find()->where([
                    'user_id' => $id
                ])->one();
        $oldpasswd = $model->password_hash;
        if ($model->load(Yii::$app->request->post())) {
            if ((Yii::$app->getSecurity()->validatePassword($model->password, $oldpasswd)) != TRUE) {
                $new_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->password_hash = $new_password_hash;
                if ($model->save(false)) {
                    $model->is_default_password = 0;
                    if ($model->save(false)) {
                      $sms="<p>You have successfully recovered your password,Click the Login Tab to login.Thanks!!!</p>";
                       Yii::$app->getSession()->setFlash('success', $sms);
                        return $this->redirect(['application/default/home-page']);
                    }
                } else {
                    return $this->render('change_password', ['model' => $model]);
                }
            } else {
                \Yii::$app->session->setFlash('errorMessage', 'Please enter new password!');
                $model->addError('password', 'New Password can not be the same as default password!');
                return $this->render('change_password', ['model' => $model]);
            }
        } else {
            return $this->render('change_password', ['model' => $model]);
        }
    }
 public function actionChangePassword() {
 //         $this->layout = "main_public_beneficiary";
        $id = Yii::$app->user->identity->user_id;
        $modeluser =  \common\models\User::find()->where([
                    'user_id' => $id
                ])->one();
//    print_r($modeluser);
  //                   exit();
        $oldpasswd = $modeluser->password_hash;
        $model = new \common\models\PasswordChangeForm();
        if ($model->load(Yii::$app->request->post())) {
            if ((Yii::$app->getSecurity()->validatePassword($model->newpass, $oldpasswd)) != TRUE) {
                $surname=strtoupper($model->lastName);
                $lastname=Yii::$app->user->identity->surname;
                   if($surname==$lastname){
                $new_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->newpass);
                $modeluser->password_hash = $new_password_hash;
                if ($modeluser->save(false)) {
                    $modeluser->is_default_password = 0;
                    if ($modeluser->save(false)) {
                        return $this->redirect(['/site/login']);
                    }
                } else {
                    return $this->render('change_password', ['model' => $model]);
                }
                   }
                   else{
                       $sms="<p>Sorry! You have successfully recovered your password</p>";
                       Yii::$app->getSession()->setFlash('errors', $sms);
                       Yii::$app->user->logout();
                         return $this->goHome();
                      
                     //  return $this->redirect(['application/default/home-page']);
                   }
            } else {
                \Yii::$app->session->setFlash('errorMessage', 'Please enter new password!');
                $model->addError('newpass', 'New Password can not be the same as default password!');
                return $this->render('change_password', ['model' => $model]);
            }
           } else {
                      //    print_r($model);
                    // exit();

           return $this->render('change_password', ['model' => $model]);
        }
    }
       ##GePG issues  Start here     
    public function actionPostBillResponse() {
    
             $post_bill_response = file_get_contents("php://input");


$queryg6 = "insert into gepg_bill6(response_message,date_created) value "
                . "('{$post_bill_response}','".date('Y-m-d H:i:s')."')";
            Yii::$app->db->createCommand($queryg6)->execute();

            //new start here
            $datatag = "gepgBillSubResp";
			if($this->verifyContent($post_bill_response,$datatag)){
			//end new

             $xml = (array)simplexml_load_string($post_bill_response);
             
             Producer::queue("GePGControllNumberQueue", $xml);
             
              // echo '<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>';
              $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
              if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])){
              $content = "<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>";
              openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
              $signature = base64_encode($signature);
             
              $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
              
              echo $response;
            }


            //new start
			}else{
			
			// echo '<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>';
              $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
              if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])){
              $content = "<gepgBillSubRespAck><TrxStsCode>7201</TrxStsCode> </gepgBillSubRespAck>";
              openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
              $signature = base64_encode($signature);
             
              $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
              
              echo $response;
            }
			
			}
			//end new


        //exit();
    }

      public function actionPostReceipt() {
           
            $post_receipt = file_get_contents("php://input");

/*
$queryg5 = "insert into gepg_bill5(response_message,date_created) value "
                . "('{$post_receipt}','".date('Y-m-d H:i:s')."')";
            Yii::$app->db->createCommand($queryg5)->execute();
*/

$date_createdsc=date("Y-m-d H:i:s");
			Yii::$app->db->createCommand()
        ->insert('gepg_bill5', [
        'response_message' =>$post_receipt,
        'date_created' =>$date_createdsc,   
        ])->execute();


            // new start here
            $datatag = "gepgPmtSpInfo";
			if($this->verifyContent($post_receipt,$datatag)){
			//end new


            $xml = (array)simplexml_load_string($post_receipt);
     
            Producer::queue("GePGReceiptQueue", $xml);
            
            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
          
            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])){
              $content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
              openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
              $signature = base64_encode($signature);
              $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
              echo $response;
            }


           //new start
			}else{
			
			$cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
          
            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])){
              $content = "<gepgPmtSpInfoAck><TrxStsCode>7201</TrxStsCode> </gepgPmtSpInfoAck>";
              openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
              $signature = base64_encode($signature);
              $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
              echo $response;
            }
			
			}
			//end new

        //exit();
    }

    
/*    public function actionPostReceipt() {
           $post_receipt = file_get_contents("php://input");

            $xml = (array)simplexml_load_string($post_receipt);
              $bill_number = (array)$xml['gepgPmtSpInfo']->PymtTrxInf->BillId;
              $bill_number = $bill_number[0];
              $amount = (array)$xml['gepgPmtSpInfo']->PymtTrxInf->BillAmt;
              $amount = $amount[0];
              $receipt_number = (array)$xml['gepgPmtSpInfo']->PymtTrxInf->BillAmt;
              $receipt_number = $receipt_number[0];
              $transaction_date = (array)$xml['gepgPmtSpInfo']->PymtTrxInf->TrxDtTm;
              $transaction_date = $transaction_date[0];

              $payment_setup = \backend\modules\application\models\Application::findOne(['bill_number' => $bill_number]);
              $payment_setup->receipt_number =  $receipt_number;
              $payment_setup->date_receipt_received = date('Y-m-d'.'\T'.'h:i:s');
              $payment_setup->save();


          $cert_store = file_get_contents("/var/www/html/olams/frontend/web/sign/gepgclientprivatekey.pfx");
          if (openssl_pkcs12_read($cert_store, $cert_info, "passpass")){
              $content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
              openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
              $signature = base64_encode($signature);
              $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
              echo $response;
            }
        exit();
    }*/

    public function getDataString($inputstr,$datatag){
	$datastartpos = strpos($inputstr, $datatag);
	$dataendpos = strrpos($inputstr, $datatag);
	$data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
	return $data;
}



// new added
public function getSignatureString($inputstr,$sigtag){
	$sigstartpos = strpos($inputstr, $sigtag);
	$sigendpos = strrpos($inputstr, $sigtag);
	$signature=substr($inputstr,$sigstartpos + strlen($sigtag)+1,$sigendpos - $sigstartpos -strlen($sigtag)-3);
	return $signature;
}

 public function verifyContent($resultCurlPost,$datatag){
		//$datatag = "gepgBillSubReqAck";
		$sigtag = "gepgSignature";
		$vdata = self::getDataString($resultCurlPost,$datatag);
		$vsignature = self::getSignatureString($resultCurlPost,$sigtag);
		
		if (!$pcert_store = file_get_contents(Yii::$app->params['gepg_content_verif_key'])) {
			return false;
		}else{

			//Read Certificate
			if (openssl_pkcs12_read($pcert_store,$pcert_info,"gepg@2018")) {
				//Decode Received Signature String
				$rawsignature = base64_decode($vsignature);

				//Verify Signature and state whether signature is okay or not
				$ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0']);
				if ($ok == 1) {
					return true;					
				} else{
					return false;
				} 
			}else{
			return false;
			}  
		}
    }

//end new added



public function actionPostReconciliationInfo() {
    
             $post_reconciliation = file_get_contents("php://input");

/*
$query = "insert into gepg_payment_reconciliation2(response_message,date_created) value "
                . "('{$post_reconciliation}','".date('Y-m-d H:i:s')."')";
            Yii::$app->db->createCommand($query)->execute();


$date_createdsc=date("Y-m-d H:i:s");
			Yii::$app->db->createCommand()
        ->insert('gepg_payment_reconciliation2', [
        'response_message' =>$post_reconciliation,
        'date_created' =>$date_createdsc,   
        ])->execute();

*/

                   // new start here
            $datatag = "gepgSpReconcResp";
			if($this->verifyContent($post_reconciliation,$datatag)){
			//end new

		     $xml = (array)simplexml_load_string($post_reconciliation);

			 Producer::queue("GePGReconciliationResponseQueue", $xml);
			 
			 //$query = "insert into gepg_payment_reconciliation2(response_message,date_created) value "
               // . "('{$post_reconciliation}','".date('Y-m-d H:i:s')."')";
            //Yii::$app->db->createCommand($query)->execute();
             
              //$cert_store = file_get_contents("/var/www/html/demo/web/sign/gepgclientprivatekey.pfx");
	   $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
       if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])){
           //$content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
            $content = "<gepgSpReconcRespAck><ReconcStsCode>7101</ReconcStsCode></gepgSpReconcRespAck>";
           openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
           $signature = base64_encode($signature);
           $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
           echo $response;
         }


        //new start
			}else{
			
			$cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
       if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])){
           //$content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
            $content = "<gepgSpReconcRespAck><ReconcStsCode>7201</ReconcStsCode></gepgSpReconcRespAck>";
           openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
           $signature = base64_encode($signature);
           $response = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
           echo $response;
         }
			
			}
			//end new


     //exit();
       //return 7101;
}

	##end for GePG issues

public function actionPasswordRecover()
    {
     $this->layout="main_public";
     $model = new User();       
     $model->scenario='recover_password';
     if ($model->load(Yii::$app->request->post())) {
        $email=$model->recover_password;
        $results = $model::find()->where(['email_address' => $email])->one();
        if($results !=0){
            $encrypt_method = "aes128";
            $secret_key = 'ucc2018';
            $secret_iv = 'ilms-ucc';
            $key = hash('sha256', $secret_key);
            $iv = substr(hash('sha256', $secret_iv), 0, 16);
            $plaintext = $results->user_id;
            $output = openssl_encrypt($plaintext, $encrypt_method, $key, 0, $iv);
            $variableToget=base64_encode($output);
            //$password = str_shuffle($results->email_address);
            
            //$url = 'http://olas.heslb.go.tz/index.php?r=site/recover-password&id='.$results->user_id;
            $url = 'http://olas.heslb.go.tz/index.php?r=site/recover-password&hashed_key='.$variableToget;

    //email notification
          $message = "Dear ".$results->firstname." ".$results->middlename." ".$results->surname.",\r\n\r\nYou have asked to reset your Account Password,Please find the below new password:- \r\n\r\n".$url."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "Recover iLMS password";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($results->email_address, $subject, $message, $headers)) {
           $results->password_hash = $model->setPassword($password);
           $results->save();
           $sms="<p>Password has been sent to your email,Kindly login into your email to recover your iLMS password</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
      return $this->redirect(['/application/default/home-page']);
    }
    else{
            $sms="<p>Sorry: We are experiencing Mail problems,please try again after some time...!</p>";
            Yii::$app->getSession()->setFlash('error', $sms);
           return $this->redirect(['/application/default/home-page']);
       }
    }else{
    $sms="<p>Sorry: No Details found for the email address you provided!</p>";
            Yii::$app->getSession()->setFlash('error', $sms);
      return $this->redirect(['/application/default/home-page']);
    }
        } else {
            return $this->render('passwordRecover', [
                'model' => $model,
            ]);
        }
    }
 public function actionRecoverPassword($hashed_key)
    {
        $this->layout = "main_public";

        $encrypt_method = "aes128";
        $secret_key = 'ucc2018';
        $secret_iv = 'ilms-ucc';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $user_id = openssl_decrypt(base64_decode($hashed_key), $encrypt_method,   $key, 0, $iv);
        
        $model =  \common\models\User::find()->where([
                    'user_id' => $user_id
                ])->one();
        $oldpasswd = $model->password_hash;
        if ($model->load(Yii::$app->request->post())) {
            if ((Yii::$app->getSecurity()->validatePassword($model->password, $oldpasswd)) != TRUE) {
                $new_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->password_hash = $new_password_hash;
                if ($model->save(false)) {
                    $model->is_default_password = 0;
                    if ($model->save(false)) {
                      $sms="<p>You have successfully recovered your password,Click the Login Tab to login.Thanks!!!</p>";
                       Yii::$app->getSession()->setFlash('success', $sms);
                        return $this->redirect(['application/default/home-page']);
                    }
                } else {
                    return $this->render('changepassword', ['model' => $model]);
                }
            } else {
                \Yii::$app->session->setFlash('errorMessage', 'Please enter new password!');
                $model->addError('password', 'New Password can not be the same as default password!');
                return $this->render('changepassword', ['model' => $model]);
            }
        } else {
            return $this->render('changepassword', ['model' => $model]);
        }

    }

    public function actionRefundRegister()
    {
        $this->layout="main_public";
        $model = new \frontend\modules\repayment\models\RefundClaimant();
        $model->scenario='refundRegistration';
        if ($model->load(Yii::$app->request->post())) {

        } else {
            return $this->render('refundRegister', [
                'model' => $model,
            ]);
        }
    }
	
}
