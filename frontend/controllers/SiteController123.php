<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use \common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
        $this->layout = "main_private_employer";
        return $this->render('index');     
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
         }else{		
            //$this->layout = "main_private";
            return $this->render('index');
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
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
          $this->layout="main_public";
        if (!Yii::$app->user->isGuest) {
              $this->layout="main_home";
            return $this->goHome();
        }

        $model = new LoginForm();
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
 public function actionChangePassword() {
          $this->layout = "main_public_beneficiary";
        $id = Yii::$app->user->identity->user_id;
        $modeluser =  \common\models\User::find()->where([
                    'user_id' => $id
                ])->one();
        $oldpasswd = $modeluser->password_hash;
        $model = new \common\models\PasswordChangeForm();
        if ($model->load(Yii::$app->request->post())) {
            if ((Yii::$app->getSecurity()->validatePassword($model->newpass, $oldpasswd)) != TRUE) {
                $new_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->newpass);
                $modeluser->password_hash = $new_password_hash;
                if ($modeluser->save(false)) {
                    $modeluser->is_default_password = 0;
                    if ($modeluser->save(false)) {
                        return $this->redirect(['/site/login']);
                    }
                } else {
                    return $this->render('changepassword', ['model' => $model]);
                }
            } else {
                \Yii::$app->session->setFlash('errorMessage', 'Please enter new password!');
                $model->addError('newpass', 'New Password can not be the same as default password!');
                return $this->render('changepassword', ['model' => $model]);
            }
        } else {
            return $this->render('changepassword', ['model' => $model]);
        }
    }
  public function actionPasswordRecover()
    {
       $this->layout = "main_public";
     $model = new User();       
     $model->scenario='recover_password';
     if ($model->load(Yii::$app->request->post())) {
        $email=$model->recover_password;
        $results = $model::find()->where(['email_address' => $email])->one();
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
       $url = 'http://localhost/loanboard/frontend/web/index.php?r=repayment/default/recover-password&id='.$variableToget;
          $message = "Dear ".$results->firstname." ".$results->middlename." ".$results->surname.",\r\nClick the link below to recover your password.\r\n".$url."\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
          $subject = "Recover iLMS password";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($results->email_address, $subject, $message, $headers)) {
        $sms="<p>Kindly login into your email to recover your iLMS password</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
      return $this->redirect(['/application/default/home-page']);
    }
    }else{
    $sms="<p>Sorry: No Details found for the email address you provided!</p>";
            Yii::$app->getSession()->setFlash('error', $sms);
      return $this->redirect(['/application/default/home-page']);
    /*
    return $this->render('viewRecoveryResults', [
            'model' =>$modelUser,'id'=>0,
      ]);
    */  
    }
        } else {
            return $this->render('passwordRecover', [
                'model' => $model,
            ]);
        }
    }

}
