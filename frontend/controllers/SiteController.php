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
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
    public function actions() {
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
    public function actionIndex() {

        if (\Yii::$app->user->isGuest) {
            $this->layout = "main_public";
            return $this->redirect(['/application/default/home-page']);
        } else {
            $login_type = \Yii::$app->user->identity->login_type;
            if ($login_type == 2) {
                return $this->redirect(['repayment/default/index']);
            } else if ($login_type == 1) {
                //application%2Fdefault%2Fmy-application-index
                $this->layout = "main_private_beneficiary";
                return $this->redirect(['application/default/index']);
            } else if ($login_type == 4) {
                $this->getInstitutionsession();

                //echo $session['learn_institution_id'];
                //  exit();
                return $this->redirect(['disbursement/default/index']);
            } else if ($login_type == 3) {
                $this->getInstitutionsession();

                return $this->redirect(['allocation/default/index']);
            } else if ($login_type == 2) {
                //$this->layout = "main_private";
                //return $this->render('index'); 
                return $this->redirect(['repayment/default/index']);
            } else if ($login_type == 6) {
                return $this->redirect(['repayment/default/index-treasury']);
            } else {
                //$this->layout = "main_private";
                //return $this->render('index');
                $this->layout = "main_public";
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Sorry ! You do not have enough permission contact your system administrator for help');
                return $this->redirect(['login']);
            }
        }
    }

    public function actionDashboard() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('dashboard');
        } else {
            $this->layout = "main_home";
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

            $model = \common\models\User::find()->where([
                        'user_id' => $id
                    ])->one();
            $oldpasswd = $model->password_hash;
            if ((Yii::$app->getSecurity()->validatePassword($model->password, $oldpasswd)) != TRUE) {
                $surname = strtoupper(trim(Yii::$app->user->identity->surname));
                $lastname = strtoupper(trim($model->lastName));
                if ($surname == $lastname) {
                    $new_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                    $model->password_hash = $new_password_hash;
                    if ($model->save(false)) {
                        $model->is_default_password = 0;
                        if ($model->save(false)) {
                            $sms = "<p>You have successfully recovered your password,Click the Login Tab to login.Thanks!!!</p>";
                            Yii::$app->getSession()->setFlash('success', $sms);
                            return $this->redirect(['application/default/home-page']);
                        }
                    } else {
                        return $this->render('change_password', ['model' => $model]);
                    }
                } else {
                    Yii::$app->user->logout();
                    //    return $this->goHome();
                    $sms = "<p>Sorry! You have successfully recovered your password</p>";
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
    public function actionLogin() {
        $this->layout = "main_public";
        if (!Yii::$app->user->isGuest) {
            $this->layout = "main_home";
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
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
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
    public function actionSignup() {
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
    public function actionRequestPasswordReset() {
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
    public function actionResetPassword($token) {
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

    function getInstitutionsession() {
        //find the institution Id 
        $model = \common\models\Staff::findOne(["user_id" => Yii::$app->user->identity->user_id]);

        //end 
        /*
         * Set global
         */
        $session = Yii::$app->session;
        if (isset($session['learn_institution_id'])) {
            $session->remove('learn_institution_id');
            unset($session['learn_institution_id']);
            if (count($model) > 0) {
                $session['learn_institution_id'] = $model->learning_institution_id;
            }
        } else {
            if (count($model) > 0) {
                $session['learn_institution_id'] = $model->learning_institution_id;
            }
        }
    }

    public function actionChangePassword3() {
        $model = new \common\models\PasswordChangeForm();
        return $this->render('change_password', ['model' => $model]);
    }

    public function actionChangePassword22() {
        $this->layout = "main_public_beneficiary";
        //  public $layout = "main_public_beneficiary";
        $id = Yii::$app->user->identity->user_id;
        $model = \common\models\User::find()->where([
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
                        $sms = "<p>You have successfully recovered your password,Click the Login Tab to login.Thanks!!!</p>";
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
        $modeluser = \common\models\User::find()->where([
                    'user_id' => $id
                ])->one();
//    print_r($modeluser);
        //                   exit();
        $oldpasswd = $modeluser->password_hash;
        $model = new \common\models\PasswordChangeForm();
        if ($model->load(Yii::$app->request->post())) {
            if ((Yii::$app->getSecurity()->validatePassword($model->newpass, $oldpasswd)) != TRUE) {
                $surname = strtoupper($model->lastName);
                $lastname = Yii::$app->user->identity->surname;
                if ($surname == $lastname) {
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
                } else {
                    $sms = "<p>Sorry! You have successfully recovered your password</p>";
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
                . "('{$post_bill_response}','" . date('Y-m-d H:i:s') . "')";
        Yii::$app->db->createCommand($queryg6)->execute();

        //new start here
        $datatag = "gepgBillSubResp";
        if ($this->verifyContent($post_bill_response, $datatag)) {
            //end new

            $xml = (array) simplexml_load_string($post_bill_response);

            Producer::queue("GePGControllNumberQueue", $xml);

            // echo '<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>';
            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])) {
                $content = "<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>";
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                $signature = base64_encode($signature);

                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";

                echo $response;
            }


            //new start
        } else {

            // echo '<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>';
            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])) {
                $content = "<gepgBillSubRespAck><TrxStsCode>7201</TrxStsCode> </gepgBillSubRespAck>";
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                $signature = base64_encode($signature);

                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";

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

        $date_createdsc = date("Y-m-d H:i:s");
        Yii::$app->db->createCommand()
                ->insert('gepg_bill5', [
                    'response_message' => $post_receipt,
                    'date_created' => $date_createdsc,
                ])->execute();


        // new start here
        $datatag = "gepgPmtSpInfo";
        if ($this->verifyContent($post_receipt, $datatag)) {
            //end new


            $xml = (array) simplexml_load_string($post_receipt);

            Producer::queue("GePGReceiptQueue", $xml);

            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);

            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])) {
                $content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                $signature = base64_encode($signature);
                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
                echo $response;
            }


            //new start
        } else {

            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);

            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])) {
                $content = "<gepgPmtSpInfoAck><TrxStsCode>7201</TrxStsCode> </gepgPmtSpInfoAck>";
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                $signature = base64_encode($signature);
                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
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
      } */

    public function getDataString($inputstr, $datatag) {
        $datastartpos = strpos($inputstr, $datatag);
        $dataendpos = strrpos($inputstr, $datatag);
        $data = substr($inputstr, $datastartpos - 1, $dataendpos + strlen($datatag) + 2 - $datastartpos);
        return $data;
    }

// new added
    public function getSignatureString($inputstr, $sigtag) {
        $sigstartpos = strpos($inputstr, $sigtag);
        $sigendpos = strrpos($inputstr, $sigtag);
        $signature = substr($inputstr, $sigstartpos + strlen($sigtag) + 1, $sigendpos - $sigstartpos - strlen($sigtag) - 3);
        return $signature;
    }

    public function verifyContent($resultCurlPost, $datatag) {
        //$datatag = "gepgBillSubReqAck";
        $sigtag = "gepgSignature";
        $vdata = self::getDataString($resultCurlPost, $datatag);
        $vsignature = self::getSignatureString($resultCurlPost, $sigtag);

        if (!$pcert_store = file_get_contents(Yii::$app->params['gepg_content_verif_key'])) {
            return false;
        } else {

            //Read Certificate
            if (openssl_pkcs12_read($pcert_store, $pcert_info, "gepg@2018")) {
                //Decode Received Signature String
                $rawsignature = base64_decode($vsignature);

                //Verify Signature and state whether signature is okay or not
                $ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0']);
                if ($ok == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
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
        if ($this->verifyContent($post_reconciliation, $datatag)) {
            //end new

            $xml = (array) simplexml_load_string($post_reconciliation);

            Producer::queue("GePGReconciliationResponseQueue", $xml);

            //$query = "insert into gepg_payment_reconciliation2(response_message,date_created) value "
            // . "('{$post_reconciliation}','".date('Y-m-d H:i:s')."')";
            //Yii::$app->db->createCommand($query)->execute();
            //$cert_store = file_get_contents("/var/www/html/demo/web/sign/gepgclientprivatekey.pfx");
            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])) {
                //$content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
                $content = "<gepgSpReconcRespAck><ReconcStsCode>7101</ReconcStsCode></gepgSpReconcRespAck>";
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                $signature = base64_encode($signature);
                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
                echo $response;
            }


            //new start
        } else {

            $cert_store = file_get_contents(Yii::$app->params['auth_certificate']);
            if (openssl_pkcs12_read($cert_store, $cert_info, Yii::$app->params['auth_certificate_pswd'])) {
                //$content = "<gepgPmtSpInfoAck><TrxStsCode>7101</TrxStsCode> </gepgPmtSpInfoAck>";
                $content = "<gepgSpReconcRespAck><ReconcStsCode>7201</ReconcStsCode></gepgSpReconcRespAck>";
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                $signature = base64_encode($signature);
                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
                echo $response;
            }
        }
        //end new
        //exit();
        //return 7101;
    }

    ##end for GePG issues

    public function actionPasswordRecover() {
        $this->layout = "main_public";
        $model = new User();
        $model->scenario = 'recover_password';
        if ($model->load(Yii::$app->request->post())) {
            $email = $model->recover_password;
            $results = $model::find()->where(['email_address' => $email])->one();
            if ($results != 0) {
                $encrypt_method = "aes128";
                $secret_key = 'ucc2018';
                $secret_iv = 'ilms-ucc';
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16);
                $plaintext = $results->user_id;
                $output = openssl_encrypt($plaintext, $encrypt_method, $key, 0, $iv);
                $variableToget = base64_encode($output);
                $password = '';
                //$password = str_shuffle($results->email_address);
                //$url = 'http://olas.heslb.go.tz/index.php?r=site/recover-password&id='.$results->user_id;
                $url = 'http://olas.heslb.go.tz/index.php?r=site/recover-password&hashed_key=' . $variableToget;

                //email notification
                $message = "Dear " . $results->firstname . " " . $results->middlename . " " . $results->surname . ",\r\n\r\nYou have asked to reset your Account Password,Please find the below new password:- \r\n\r\n" . $url . "\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
                $subject = "Recover iLMS password";
                $headers = '';
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "From: iLMS ";
                if (mail($results->email_address, $subject, $message, $headers)) {
                    $results->password_hash = $model->setPassword($password);
                    $results->save();
                    $sms = "<p>Password has been sent to your email,Kindly login into your email to recover your iLMS password</p>";
                    Yii::$app->getSession()->setFlash('success', $sms);
                    return $this->redirect(['/application/default/home-page']);
                } else {
                    $sms = "<p>Sorry: We are experiencing Mail problems,please try again after some time...!</p>";
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['/application/default/home-page']);
                }
            } else {
                $sms = "<p>Sorry: No Details found for the email address you provided!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['/application/default/home-page']);
            }
        } else {
            return $this->render('passwordRecover', [
                        'model' => $model,
            ]);
        }
    }

    public function actionRecoverPassword($hashed_key) {
        $this->layout = "main_public";

        $encrypt_method = "aes128";
        $secret_key = 'ucc2018';
        $secret_iv = 'ilms-ucc';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $user_id = openssl_decrypt(base64_decode($hashed_key), $encrypt_method, $key, 0, $iv);

        $model = \common\models\User::find()->where([
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
                        $sms = "<p>You have successfully recovered your password,Click the Login Tab to login.Thanks!!!</p>";
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

    public function actionRefundRegister() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundClaimant();
        $modelRefundApplication = new \frontend\modules\repayment\models\RefundApplication();
        $modelRefundContactPerson = new \frontend\modules\repayment\models\RefundContactPerson();
        $model->scenario = 'refundRegistration';
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->validate()){
            $todate = date("Y-m-d H:i:s");
            $model->created_at = $todate;
            $model->updated_at = $todate;
            if ($model->firstname == 'YUSUPH') {
                $model->applicant_id = 30;
            }
            $model->phone_number = str_replace(" ", "", $model->phone_number);

            if ($model->save(false)) {
                //return $this->redirect(['list-steps', 'id' => $model->refund_claimant_id]);
                $modelRefundApplication->refund_claimant_id = $model->refund_claimant_id;
                $code = strtotime($todate);
                $modelRefundApplication->application_number = $code;
                $modelRefundApplication->trustee_firstname = $model->firstname;
                $modelRefundApplication->trustee_midlename = $model->middlename;
                $modelRefundApplication->trustee_surname = $model->surname;
                $modelRefundApplication->refund_type_id = $model->refund_type;
                $modelRefundApplication->created_at = $todate;
                $modelRefundApplication->updated_at = $todate;

                $modelRefundApplication->finaccial_year_id = \frontend\modules\repayment\models\LoanRepaymentDetail::getCurrentFinancialYear()->financial_year_id;
                $modelRefundApplication->academic_year_id = \frontend\modules\repayment\models\LoanRepaymentDetail::getActiveAcademicYear()->academic_year_id;
                $modelRefundApplication->trustee_phone_number = $model->phone_number;
                $modelRefundApplication->trustee_email = $model->email;
                $modelRefundApplication->refund_type_confirmed = $model->refund_type_confirmed_nonb;
                $modelRefundApplication->save(false);

                if ($model->refund_type == 3) {
                    $detailsClaimant = \frontend\modules\repayment\models\RefundClaimant::findOne($model->refund_claimant_id);
                    $detailsClaimant->firstname = null;
                    $detailsClaimant->middlename = null;
                    $detailsClaimant->surname = null;
                    $detailsClaimant->save(false);
                }

                $modelRefundContactPerson->firstname = $model->firstname;
                $modelRefundContactPerson->middlename = $model->middlename;
                $modelRefundContactPerson->surname = $model->surname;
                $modelRefundContactPerson->email_address = $model->email;
                $modelRefundContactPerson->phone_number = $model->phone_number;
                $modelRefundContactPerson->created_at = $todate;
                $modelRefundContactPerson->updated_at = $todate;
                $modelRefundContactPerson->refund_application_id = $modelRefundApplication->refund_application_id;
                $modelRefundContactPerson->save(false);

                ####################here send email#####################
                $headers = '';
                if (fsockopen("www.google.com", 80)) {
                    //$url = Yii::$app->params['emailReturnUrl'].'employer-activate-account&id='.$variableToget;
                    $message = "Dear " . $model->firstname . " " . $model->middlename . " " . $model->surname . ",\nYour loan refund application code is:\r\n" . $modelRefundApplication->application_number . "\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
                    $subject = "iLMS loan refund application";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "From: iLMS ";

                    if (mail($modelRefundApplication->trustee_email, $subject, $message, $headers)) {
                        return $this->redirect(['confirm-applicationno', 'id' => $model->refund_claimant_id]);
                    } else {
                        $sms = "<p>Email not sent!<br/>
                   Kindly contact HESLB for assistance. </p>";
                        Yii::$app->getSession()->setFlash('danger', $sms);
                        return $this->redirect(['confirm-applicationno', 'id' => $model->refund_claimant_id]);
                    }
                } else {
                    echo '<p class="messageSuccessFailed"><em>YOU HAVE NO INTERNET CONNECTION: Can not send  SMS!</em></p>';
                    $sms = "<p>Kindly Contact HESLB to complete registration. </p>";
                    Yii::$app->getSession()->setFlash('success', $sms);
                    return $this->redirect(['confirm-applicationno', 'id' => $model->refund_claimant_id]);
                }
                ##################################end send email##################################

                return $this->redirect(['confirm-applicationno', 'id' => $model->refund_claimant_id]);
            }
        }
            //var_dump($model->errors);
        } else {
            return $this->render('refundRegister', [
                        'model' => $model,
            ]);
        }
    }

    public function actionConfirmApplicationno($id) {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundClaimant();
        $model->scenario = 'refundApplicationCodeVerification';
        if ($model->load(Yii::$app->request->post())) {
            //set session	
            $session = Yii::$app->session;
            $refundClaimantid = $session->get('refund_claimant_id');
            $refund_application_id = $session->get('refund_application_id');
            //end set session
            $refundType = $model->getRefuntTypePerClaimant($refund_application_id)->refund_type_id;
            if ($refundType == 1) {
                return $this->redirect(['list-steps-nonbeneficiary', 'id' => $refund_application_id]);
            } else if ($refundType == 2) {
                return $this->redirect(['list-steps-overdeducted', 'id' => $refund_application_id]);
            } else if ($refundType == 3) {
                return $this->redirect(['list-steps-deceased', 'id' => $refund_application_id]);
            }
        } else {
            return $this->render('confirmApplicationno', [
                        'model' => $model, 'id' => $id,
            ]);
        }
    }

    public function actionRefundListsteps() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundClaimant();
        $model->scenario = 'refundApplicationCodeVerification';
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $refundType = $model->getRefuntTypePerClaimant($refund_application_id)->refund_type_id;
        if ($refundType == 1) {
            return $this->redirect(['list-steps-nonbeneficiary', 'id' => $refundClaimantid]);
        } else if ($refundType == 2) {
            return $this->redirect(['list-steps-overdeducted', 'id' => $refundClaimantid]);
        } else if ($refundType == 3) {
            return $this->redirect(['list-steps-deceased', 'id' => $refundClaimantid]);
        }
    }

    public function actionListStepsNonbeneficiary() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        $refundClaimantid = \Yii::$app->session->get('refund_claimant_id');
        $application_id = \Yii::$app->session->get('refund_application_id');
        $model = \frontend\modules\repayment\models\RefundApplication::getRefundApplicationDetailsById($application_id);

        return $this->render('listStepsNonbeneficiary', [
                    'model' => $model
        ]);
    }

    public function actionListStepsOverdeducted() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        $refundClaimantid = \Yii::$app->session->get('refund_claimant_id');
        $application_id = \Yii::$app->session->get('refund_application_id');
        $model = \frontend\modules\repayment\models\RefundApplication::getRefundApplicationDetailsById($application_id);

        return $this->render('listStepsOverdeducted', [
                    'model' => $model,
        ]);
    }

    public function actionListStepsDeceased() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        $refundClaimantid = \Yii::$app->session->get('refund_claimant_id');
        $application_id = \Yii::$app->session->get('refund_application_id');
        $model = \frontend\modules\repayment\models\RefundApplication::getRefundApplicationDetailsById($application_id);

        return $this->render('listStepsDeceased', [
                    'model' => $model,
        ]);
    }

    public function actionCreateRefundf4education() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $model = \frontend\modules\repayment\models\RefundClaimant::findOne($refundClaimantid);
        $model->scenario = 'refundf4education';
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
            $model->f4_certificate_document = UploadedFile::getInstance($model, 'f4_certificate_document');
            if($model->validate()){
            $model->f4_certificate_document->saveAs(Yii::$app->params['refundAttachments'] . "f4_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->f4_certificate_document->extension);
            $model->f4_certificate_document = Yii::$app->params['refundAttachments'] . "f4_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->f4_certificate_document->extension;

            if ($refundClaimantid != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundClaimant::findOne($refundClaimantid);
                $modelRefundresults->f4indexno = $model->f4indexno;
                $modelRefundresults->f4_completion_year = $model->f4_completion_year;
                $modelRefundresults->necta_firstname = $model->firstname;
                $modelRefundresults->necta_middlename = $model->middlename;
                $modelRefundresults->necta_surname = $model->surname;
                $modelRefundresults->firstname = $model->firstname;
                $modelRefundresults->middlename = $model->middlename;
                $modelRefundresults->surname = $model->surname;
                $modelRefundresults->f4_certificate_document = $model->f4_certificate_document;
                if ($modelRefundresults->save(false)) {
                    //$attachment_code='F4CERT';
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::F4_CERTIFICATE_DOCUMENT;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $modelRefundresults->f4_certificate_document);
                    return $this->redirect(['indexf4educationdetails']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['indexf4educationdetails']);
            }
        }
            //var_dump($model->errors);
        } else {
            return $this->render('createRefundf4education', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreateEducationgeneral() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $model = \frontend\modules\repayment\models\RefundClaimant::findOne($refundClaimantid);
        $model->scenario = 'refundf4education';
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
            if($model->educationAttained==1) {
                $model->f4_certificate_document = UploadedFile::getInstance($model, 'f4_certificate_document');
            }else if($model->educationAttained==2){
                $model->employer_letter_document = UploadedFile::getInstance($model, 'employer_letter_document');
            }
            if($model->validate()){
                if($model->educationAttained==1) {
                    $model->f4_certificate_document->saveAs(Yii::$app->params['refundAttachments'] . "f4_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->f4_certificate_document->extension);
                    $model->f4_certificate_document = Yii::$app->params['refundAttachments'] . "f4_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->f4_certificate_document->extension;
                }
                if($model->educationAttained==2) {
                    $model->employer_letter_document->saveAs(Yii::$app->params['refundAttachments'] . "employer_letter_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->employer_letter_document->extension);
                    $model->employer_letter_document = Yii::$app->params['refundAttachments'] . "employer_letter_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->employer_letter_document->extension;
                }

                if ($refundClaimantid != '') {
                    if($model->educationAttained==1) {
                        $modelRefundresults = \frontend\modules\repayment\models\RefundClaimant::findOne($refundClaimantid);
                        $modelRefundresults->f4indexno = $model->f4indexno;
                        $modelRefundresults->f4_completion_year = $model->f4_completion_year;
                        $modelRefundresults->necta_firstname = $model->firstname;
                        $modelRefundresults->necta_middlename = $model->middlename;
                        $modelRefundresults->necta_surname = $model->surname;
                        $modelRefundresults->firstname = $model->firstname;
                        $modelRefundresults->middlename = $model->middlename;
                        $modelRefundresults->surname = $model->surname;
                        $modelRefundresults->f4_certificate_document = $model->f4_certificate_document;
                        $modelRefundresults->save(false);
                        $savedF4Education=1;
                        $modelRefundApplication_n = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                        $modelRefundApplication_n->educationAttained=$model->educationAttained;
                        $modelRefundApplication_n->save(false);
                    }
                    if($model->educationAttained==2) {
                        $modelRefundApplication = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                        $modelRefundApplication->employer_letter_document = $model->employer_letter_document;
                        $modelRefundApplication->educationAttained=$model->educationAttained;
                        $modelRefundApplication->save(false);
                        $savedEmployerLetter=1;
                    }
                    if ( $savedF4Education==1 || $savedEmployerLetter==1) {
                        //$attachment_code='F4CERT';
                        if($model->educationAttained==1) {
                            $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::F4_CERTIFICATE_DOCUMENT;
                            \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $modelRefundresults->f4_certificate_document);
                        }
                        if($model->educationAttained==2) {
                            $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Employer_letter_Document;
                            \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $modelRefundApplication->employer_letter_document);
                        }
                        return $this->redirect(['indexf4educationdetails']);
                    }
                } else {
                    $sms = "<p>Session Expired!</p>";
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['indexf4educationdetails']);
                }
            }
            //var_dump($model->errors);
        } else {
            return $this->render('createEducationgeneral', [
                'model' => $model,
            ]);
        }
    }

    public function actionF4educationPreview($id) {
        $this->layout = "main_public";
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $model = \frontend\modules\repayment\models\RefundClaimant::findOne($refundClaimantid);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($refundClaimantid != '') {
                $sms = "<p>Information updated successful!</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['f4education-preview', 'id' => $refundClaimantid]);
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['f4education-preview', 'id' => $refundClaimantid]);
            }
        } else {
            return $this->render('f4educationPreview', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreateTertiary() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundClaimantEducationHistory();
        $model->scenario = 'refundTresuryEducation';
        if ($model->load(Yii::$app->request->post())) {
            //set session
            $session = Yii::$app->session;
            $refundClaimantid = $session->get('refund_claimant_id');
            $refund_application_id = $session->get('refund_application_id');
            //end set session

            $datime = date("Y_m_d_H_i_s");
            $model->certificate_document = UploadedFile::getInstance($model, 'certificate_document');
            $model->certificate_document->saveAs(Yii::$app->params['refundAttachments'] . "certificate_document_tertiary_educ" . "_" . $refund_application_id . "_" . $datime . '.' . $model->certificate_document->extension);
            $model->certificate_document = Yii::$app->params['refundAttachments'] . "certificate_document_tertiary_educ" . "_" . $refund_application_id . "_" . $datime . '.' . $model->certificate_document->extension;

            if ($refundClaimantid != '' && $refund_application_id != '') {
                $model->refund_application_id = $refund_application_id;
                if ($model->save()) {
                    if ($model->study_level == 1) {
                        $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Bachelor_Education_Certificate_Document;
                    } else if ($model->study_level == 2) {
                        $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Masters_Education_Certificate_Document;
                    } else if ($model->study_level == 3) {
                        $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::College_Education_Certificate_Document;
                    } else {
                        $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::College_Education_Certificate_Document;
                    }
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->certificate_document);
                    return $this->redirect(['index-tertiary-education']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['create-tertiary', 'id' => $refundClaimantid]);
            }
        } else {
            return $this->render('createTertiary', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndexTertiaryEducation() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEducationHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexTertiaryEducation', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateEmploymentDetails() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundClaimantEmployment();
        $model->scenario = 'refundEmploymentDetails';
        if ($model->load(Yii::$app->request->post())) {
            //set session
            $session = Yii::$app->session;
            $refundClaimantid = $session->get('refund_claimant_id');
            $refund_application_id = $session->get('refund_application_id');
            //end set session
            $datime = date("Y_m_d_H_i_s");
            $model->first_slip_document = UploadedFile::getInstance($model, 'first_slip_document');
            $model->second_slip_document = UploadedFile::getInstance($model, 'second_slip_document');
            /*
              $model->support_document->saveAs('../../vframework_document/verification_support_document_'.$model->verification_framework_id.'_'.$datime.'.'.$model->support_document->extension);
              $model->support_document = 'vframework_document/verification_support_document_'.$model->verification_framework_id.'_'.$datime.'.'.$model->support_document->extension;
             */
            $model->first_slip_document->saveAs(Yii::$app->params['refundAttachments'] . "first_slip_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->first_slip_document->extension);
            $model->first_slip_document = Yii::$app->params['refundAttachments'] . "first_slip_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->first_slip_document->extension;

            $model->second_slip_document->saveAs(Yii::$app->params['refundAttachments'] . "second_slip_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->second_slip_document->extension);
            $model->second_slip_document = Yii::$app->params['refundAttachments'] . "second_slip_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->second_slip_document->extension;


            if ($refundClaimantid != '' && $refund_application_id != '') {
                $model->refund_application_id = $refund_application_id;
                if ($model->save()) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Salary_PAY_Slip;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->first_slip_document);
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->second_slip_document);
                    return $this->redirect(['index-employment-details']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-employment-details', 'id' => $refundClaimantid]);
            }
        } else {
            return $this->render('createEmploymentDetails', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndexEmploymentDetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexEmploymentDetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionContactDetailsPreview($id) {
        $this->layout = "main_public";
        $session = Yii::$app->session;
        $refund_application_id = $session->get('refund_application_id');
        $resultsContacts = \frontend\modules\repayment\models\RefundContactPerson::find()->where(['refund_application_id' => $refund_application_id])->orderBy(['refund_contact_person_id' => SORT_DESC])->one();
        $refund_contact_person_id = $resultsContacts->refund_contact_person_id;
        $model = \frontend\modules\repayment\models\RefundContactPerson::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($refund_application_id != '') {
                $sms = "<p>Information updated successful!</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['index-contactdetails']);
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-contactdetails']);
            }
        } else {
            return $this->render('contactDetailsPreview', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreateRefundBankdetails() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refundBankDetailsAdd';
        if ($model->load(Yii::$app->request->post())) {

            $datime = date("Y_m_d_H_i_s");
            $model->bank_card_document = UploadedFile::getInstance($model, 'bank_card_document');
            $model->bank_card_document->saveAs(Yii::$app->params['refundAttachments'] . "bank_card_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->bank_card_document->extension);
            $model->bank_card_document = Yii::$app->params['refundAttachments'] . "bank_card_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->bank_card_document->extension;

            if ($refund_application_id != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                $modelRefundresults->bank_name = $model->bank_name;
                $modelRefundresults->bank_account_number = $model->bank_account_number;
                $modelRefundresults->bank_account_name = $model->bank_account_name;
                $modelRefundresults->branch = $model->branch;
                $modelRefundresults->bank_card_document = $model->bank_card_document;
                if ($modelRefundresults->save(false)) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Bank_Card;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->bank_card_document);
                    return $this->redirect(['index-bankdetails']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-bankdetails']);
            }
        } else {
            return $this->render('createRefundBankdetails', [
                        'model' => $model,
            ]);
        }
    }

    public function actionBankDetailspreview($id) {
        $this->layout = "main_public";
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        $model = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
        $model->scenario = 'refundBankDetailsAdd';
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
            $model->bank_card_document = UploadedFile::getInstance($model, 'bank_card_document');
            $model->bank_card_document->saveAs(Yii::$app->params['refundAttachments'] . "bank_card_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->bank_card_document->extension);
            $model->bank_card_document = Yii::$app->params['refundAttachments'] . "bank_card_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->bank_card_document->extension;
            if ($model->save(false)) {
                if ($refund_application_id != '') {
                    $sms = "<p>Information updated successful!</p>";
                    Yii::$app->getSession()->setFlash('success', $sms);
                    return $this->redirect(['bank-detailspreview', 'id' => $refund_application_id]);
                } else {
                    $sms = "<p>Session Expired!</p>";
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['bank-detailspreview', 'id' => $refund_application_id]);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['bank-detailspreview', 'id' => $refund_application_id]);
            }
        } else {
            return $this->render('bankDetailspreview', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreateSecurityfund() {
        $this->layout = "main_public";
        //$model = new \frontend\modules\repayment\models\RefundClaimant();
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refundSocialFundDetails';
        if ($model->load(Yii::$app->request->post())) {

            $datime = date("Y_m_d_H_i_s");
            if ($model->social_fund_status == 1 && $model->soccialFundDocument == 1) {
                $model->social_fund_document = UploadedFile::getInstance($model, 'social_fund_document');
                $model->social_fund_receipt_document = UploadedFile::getInstance($model, 'social_fund_receipt_document');

                $model->social_fund_document->saveAs(Yii::$app->params['refundAttachments'] . "social_fund_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_document->extension);
                $model->social_fund_document = Yii::$app->params['refundAttachments'] . "social_fund_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_document->extension;

                $model->social_fund_receipt_document->saveAs(Yii::$app->params['refundAttachments'] . "social_fund_receipt_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_receipt_document->extension);
                $model->social_fund_receipt_document = Yii::$app->params['refundAttachments'] . "social_fund_receipt_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_receipt_document->extension;
            } else {
                $model->social_fund_document = null;
                $model->social_fund_receipt_document = null;
            }

            if ($refund_application_id != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                $modelRefundresults->social_fund_status = $model->social_fund_status;
                $modelRefundresults->social_fund_document = $model->social_fund_document;
                $modelRefundresults->social_fund_receipt_document = $model->social_fund_receipt_document;
                $modelRefundresults->soccialFundDocument = $model->soccialFundDocument;
                if ($modelRefundresults->save(false)) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::RECEIPT_FROM_SOCIAL_FUND;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->social_fund_receipt_document);
                    return $this->redirect(['index-socialfund']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-socialfund']);
            }
        } else {
            return $this->render('createSecurityfund', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSocialFundpreview($id) {
        $this->layout = "main_public";
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        $model = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
        $model->scenario = 'refundBankDetailsAdd';
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
            if ($model->social_fund_status == 1) {
                $model->social_fund_document = UploadedFile::getInstance($model, 'social_fund_document');
                $model->social_fund_receipt_document = UploadedFile::getInstance($model, 'social_fund_receipt_document');

                $model->social_fund_document->saveAs(Yii::$app->params['refundAttachments'] . "social_fund_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_document->extension);
                $model->social_fund_document = Yii::$app->params['refundAttachments'] . "social_fund_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_document->extension;

                $model->social_fund_receipt_document->saveAs(Yii::$app->params['refundAttachments'] . "social_fund_receipt_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_receipt_document->extension);
                $model->social_fund_receipt_document = Yii::$app->params['refundAttachments'] . "social_fund_receipt_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->social_fund_receipt_document->extension;
            } else {
                $model->social_fund_document = null;
                $model->social_fund_receipt_document = null;
            }
            if ($model->save(false)) {
                if ($refund_application_id != '') {
                    $sms = "<p>Information updated successful!</p>";
                    Yii::$app->getSession()->setFlash('success', $sms);
                    return $this->redirect(['social-fundpreview', 'id' => $refund_application_id]);
                } else {
                    $sms = "<p>Session Expired!</p>";
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['social-fundpreview', 'id' => $refund_application_id]);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['social-fundpreview', 'id' => $refund_application_id]);
            }
        } else {
            return $this->render('socialFundpreview', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndexSocialfund() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexSocialfund', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexBankdetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexBankDetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexContactdetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexContactDetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexf4educationdetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexf4educationdetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateRepaymentdetails() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refundEmploymentDetails';
        if ($model->load(Yii::$app->request->post())) {
            //set session
            $session = Yii::$app->session;
            $refundClaimantid = $session->get('refund_claimant_id');
            $refund_application_id = $session->get('refund_application_id');
            //end set session
            $datime = date("Y_m_d_H_i_s");
            $model->liquidation_letter_document = UploadedFile::getInstance($model, 'liquidation_letter_document');

            $model->liquidation_letter_document->saveAs(Yii::$app->params['refundAttachments'] . "liquidation_letter_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->liquidation_letter_document->extension);
            $model->liquidation_letter_document = Yii::$app->params['refundAttachments'] . "liquidation_letter_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->liquidation_letter_document->extension;


            if ($refundClaimantid != '' && $refund_application_id != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                $modelRefundresults->liquidation_letter_number = $model->liquidation_letter_number;
                $modelRefundresults->liquidation_letter_document = $model->liquidation_letter_document;
                if ($modelRefundresults->save(false)) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Liquidation_letter;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->liquidation_letter_document);
                    return $this->redirect(['index-repaymentdetails']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-repaymentdetails']);
            }
        } else {
            return $this->render('createRepaymentdetails', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndexRepaymentdetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexRepaymentdetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateDeathdetails() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refundDeathDetails';
        if ($model->load(Yii::$app->request->post())) {
            //set session
            $session = Yii::$app->session;
            $refundClaimantid = $session->get('refund_claimant_id');
            $refund_application_id = $session->get('refund_application_id');
            //end set session
            $datime = date("Y_m_d_H_i_s");
            $model->death_certificate_document = UploadedFile::getInstance($model, 'death_certificate_document');

            $model->death_certificate_document->saveAs(Yii::$app->params['refundAttachments'] . "death_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->death_certificate_document->extension);
            $model->death_certificate_document = Yii::$app->params['refundAttachments'] . "death_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->death_certificate_document->extension;


            if ($refundClaimantid != '' && $refund_application_id != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                $modelRefundresults->death_certificate_document = $model->death_certificate_document;
                $modelRefundresults->death_certificate_number = $model->death_certificate_number;
                if ($modelRefundresults->save(false)) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Death_Certificate_Document;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->death_certificate_document);
                    return $this->redirect(['index-deathdetails']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-deathdetails']);
            }
        } else {
            return $this->render('createDeathdetails', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndexDeathdetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexDeathdetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateCourtdetails() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refundCourtDetails';
        if ($model->load(Yii::$app->request->post())) {
            //set session
            $session = Yii::$app->session;
            $refundClaimantid = $session->get('refund_claimant_id');
            $refund_application_id = $session->get('refund_application_id');
            //end set session
            $datime = date("Y_m_d_H_i_s");
            $model->court_letter_certificate_document = UploadedFile::getInstance($model, 'court_letter_certificate_document');

            $model->court_letter_certificate_document->saveAs(Yii::$app->params['refundAttachments'] . "court_letter_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->court_letter_certificate_document->extension);
            $model->court_letter_certificate_document = Yii::$app->params['refundAttachments'] . "court_letter_certificate_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->court_letter_certificate_document->extension;


            if ($refundClaimantid != '' && $refund_application_id != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                $modelRefundresults->court_letter_certificate_document = $model->court_letter_certificate_document;
                $modelRefundresults->court_letter_number = $model->court_letter_number;
                if ($modelRefundresults->save(false)) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Letter_from_court;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->court_letter_certificate_document);
                    return $this->redirect(['index-courtdetails']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-courtdetails']);
            }
        } else {
            return $this->render('createCourtdetails', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndexCourtdetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexCourtdetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateFamilysessiondetails() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refundFamilySessionDetails';
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        if ($model->load(Yii::$app->request->post())) {

            $datime = date("Y_m_d_H_i_s");
            $model->letter_family_session_document = UploadedFile::getInstance($model, 'letter_family_session_document');
            $model->letter_family_session_document->saveAs(Yii::$app->params['refundAttachments'] . "letter_family_session_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->letter_family_session_document->extension);
            $model->letter_family_session_document = Yii::$app->params['refundAttachments'] . "letter_family_session_document" . "_" . $refund_application_id . "_" . $datime . '.' . $model->letter_family_session_document->extension;


            if ($refundClaimantid != '' && $refund_application_id != '') {
                $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id);
                $modelRefundresults->letter_family_session_document = $model->letter_family_session_document;
                $modelRefundresults->trustee_firstname = $model->trustee_firstname;
                $modelRefundresults->trustee_midlename = $model->trustee_midlename;
                $modelRefundresults->trustee_surname = $model->trustee_surname;
                if ($modelRefundresults->save(false)) {
                    $attachment_code = \backend\modules\repayment\models\RefundClaimantAttachment::Letter_of_family_session;
                    \backend\modules\repayment\models\RefundClaimantAttachment::insertClaimantAttachment($refund_application_id, $attachment_code, $model->letter_family_session_document);
                    return $this->redirect(['index-familysessiondetails']);
                }
            } else {
                $sms = "<p>Session Expired!</p>";
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['index-familysessiondetails']);
            }
        } else {
            return $this->render('createFamilysessiondetails', [
                        'model' => \frontend\modules\repayment\models\RefundApplication::findOne($refund_application_id),
            ]);
        }
    }

    public function actionIndexFamilysessiondetails() {
        $this->layout = "main_public";
        //set session
        $session = Yii::$app->session;
        $refundClaimantid = $session->get('refund_claimant_id');
        $refund_application_id = $session->get('refund_application_id');
        //end set session
        $searchModel = new \frontend\modules\repayment\models\RefundClaimantEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexFamilysessiondetails', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRefundApplicationview($refundApplicationID) {
        $this->layout = "main_public";
        if (\Yii::$app->session->has('refund_claimant_id') && \Yii::$app->session->get('refund_claimant_id') > 0) {
            $model = \frontend\modules\repayment\models\RefundApplication::getRefundApplicationDetailsById($refundApplicationID);
            return $this->render('refund_application_details', [
                        'model' => $model,
            ]);
        } else {
            $this->redirect(['site/view-refund']);
        }
    }

    public function actionLogoutRefund($id) {
        $session = Yii::$app->session;
        /*
          $this->layout="main_public";
          $session = Yii::$app->session;
          // close a session
          $session->close();
          // destroys all data registered to a session.
          $session->destroy();
          return $this->redirect(['confirm-applicationno', 'id' =>$id]);
         */
        $session->remove('refund_claimant_id');
        unset($session['refund_claimant_id']);
        unset($_SESSION['refund_claimant_id']);
        $session->remove('refund_application_id');
        unset($session['refund_application_id']);
        unset($_SESSION['refund_application_id']);
        $session->destroy();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRefundConfirm($id) {
        $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($id);
        $modelRefundresults->submitted = 2;
        if ($modelRefundresults->save(false))
            ;
        //return $this->redirect(['list-steps-nonbeneficiary', 'id' => $id]);
        return $this->redirect(['refund-liststeps']);
    }

    public function actionRefundSubmitapplication($id) {
        $modelRefundresults = \frontend\modules\repayment\models\RefundApplication::findOne($id);
        $modelRefundresults->submitted = 3;
        if ($modelRefundresults->save(false))
            ;
        //return $this->redirect(['list-steps-nonbeneficiary', 'id' => $id]);
        return $this->redirect(['refund-liststeps']);
    }

    public function actionViewRefund() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'view-status';
        if ($_POST['RefundApplication']) {
            $model->attributes = $_POST['RefundApplication'];
            //  $model->social_fund_receipt_document = $model->social_fund_document = 1;
            if ($model->validate()) {
                $refund_application = \frontend\modules\repayment\models\RefundApplication::getDetailsByApplicationNo($model->application_number);
                $trustee_firstname = $refund_application->trustee_firstname;
                $trustee_midlename = $refund_application->trustee_midlename;
                $trustee_surname = $refund_application->trustee_surname;
                $trustee_phone_number = $refund_application->trustee_phone_number;
                $trustee_email = $refund_application->trustee_email;
                $refund_claimant_id = $refund_application->refund_claimant_id;
                $refund_application_id = $refund_application->refund_application_id;

                //set session
                $session = Yii::$app->session;
                $session->set('refund_claimant_id', $refund_claimant_id);
                $session->set('refund_application_id', $refund_application_id);
                //end set session

                if (!empty($trustee_phone_number)) {
///sending SMS with a passward tocken
                    $user_otp = rand(1000, 9999); ///creating a rondom tocke for session password
                    \Yii::$app->session->set('user_otp', $user_otp);
                    \Yii::$app->session->set('user_otp_time', date('Y-m-d H:i:s', time()));
                    \Yii::$app->session->set('enter_otp', TRUE);
                    \Yii::$app->session->set('reference_no', $model->application_number);
                    $config = [
                        'url' => \Yii::$app->params['SMSGateway']['url'],
                        'channel' => \Yii::$app->params['SMSGateway']['channel'],
                        'source_sender' => \Yii::$app->params['SMSGateway']['source_sender'],
                        'password' => \Yii::$app->params['SMSGateway']['password'],
                        'method' => \Yii::$app->params['SMSGateway']['method'],
                    ];
                    $sms_gateway = New \common\components\SMSGateway($config);
                    $sms_gateway->sendSMS($trustee_phone_number, 'Refund request access code ' . $user_otp);
                }
                //sending email
                /*
                  if (!empty($trustee_email)) {
                  //sending email to receipient
                  $mail_client = new \common\components\MailClient();
                  $mail_client->from = Yii::$app->params['mail']['messageConfig']['from'];
                  $mail_client->to = $trustee_email;
                  $mail_client->mail_body = 'Refund request access code ' . $user_otp;
                  $mail_client->subject = 'HESLB: Loan Refund Access Token';
                  $mail_client->sendMail();
                  }
                 */

                ####################here send email#####################
                $headers = '';
                if (fsockopen("www.google.com", 80)) {
                    //$url = Yii::$app->params['emailReturnUrl'].'employer-activate-account&id='.$variableToget;
                    $message = "Dear " . $trustee_firstname . " " . $trustee_midlename . " " . $trustee_surname . ",\nYour Loan Refund Access Token is:\r\n" . $user_otp . "\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
                    $subject = "HESLB: Loan Refund Access Token";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "From: HESLB ";

                    if (mail($trustee_email, $subject, $message, $headers)) {
                        return $this->redirect(['refund-login']);
                    } else {
                        $sms = "<p>Email not sent!<br/>
                   Kindly contact HESLB for assistance. </p>";
                        Yii::$app->getSession()->setFlash('danger', $sms);
                        return $this->redirect(['view-refund']);
                    }
                } else {
                    echo '<p class="messageSuccessFailed"><em>YOU HAVE NO INTERNET CONNECTION: Can not send  SMS!</em></p>';
                    $sms = "<p>Token not Sent, Kindly Contact HESLB for Assistance. </p>";
                    Yii::$app->getSession()->setFlash('success', $sms);
                    return $this->redirect(['view-refund']);
                }
                ##################################end send email##################################

                $this->redirect(['/site/refund-login']);
            }
            //var_dump($model->errors);
        }
        return $this->render('viewRefund', [
                    'model' => $model,
        ]);
    }

    public function actionRefundLogin() {
        $this->layout = "main_public";
        $model = new \frontend\modules\repayment\models\RefundApplication();
        $model->scenario = 'refund-login';
        $model->application_number = \Yii::$app->session->get('reference_no');

        if (!\Yii::$app->session->has('enter_otp')) {
            ///redirect to  ViewRefund
            $this->redirect(['/site/view-refund']);
            $otp_time = \Yii::$app->session->get('user_otp_time');
            if ((time() - strtotime($otp_time)) > (60)) {
                $sms == 'Your PIN has already Expired, Please generate a new PIN';
                Yii::$app->session->setFlash('sms', $sms);
                $this->redirect(['/site/view-refund']);
            }
        }
//        \Yii::$app->session->set('user_otp', $user_otp);
//        \Yii::$app->session->set('user_otp_time', date('Y-m-d H:i:s', time()));
//        \Yii::$app->session->set('enter_otp', TRUE);
//        \Yii::$app->session->set('reference_no', $model->application_number);


        if ($_POST['RefundApplication']) {
            $model->attributes = $_POST['RefundApplication'];
            if ($model->validate()) {
                $refund = \frontend\modules\repayment\models\RefundApplication::getDetailsByApplicationNo($model->application_number);
                \Yii::$app->session->set('refund_claimant_id', $refund->refund_claimant_id);
                $this->redirect(['/site/claimant-refunds']);
            }
        }
        return $this->render('viewOtp', [
                    'model' => $model,
        ]);
    }

    public function actionClaimantRefunds() {
        $this->layout = "main_public";
        if (Yii::$app->session->has('refund_claimant_id')) {
            $claimant_id = Yii::$app->session->get('refund_claimant_id');
            $params = ['refund_claimant_id' => $claimant_id];
            $model = new \frontend\modules\repayment\models\RefundApplicationSearch($params);
            $dataProvider = $model->search($params);
            return $this->render('view_claimant_refunds', [
                        'model' => $model, 'dataProvider' => $dataProvider
            ]);
        } else {
            $this->redirect(['site/view-refund']);
        }
    }

}
