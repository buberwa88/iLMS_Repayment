<?php

namespace frontend\modules\application\controllers;
//use yii\web\Controller;
use frontend\modules\application\models\Cnotification;
use common\models\LoginForm;
use frontend\modules\application\models\ApplicantAttachment;
use Yii;
use yii\helpers\Url;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Education;
use backend\modules\application\models\Application;
use backend\modules\application\models\ApplicationSearch;
use backend\modules\allocation\models\base\LearningInstitution;
use yii\web\UploadedFile;
use frontend\modules\application\rabbit\Producer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//use backend\modules\application\models\Applicant;
use common\components\Controller;
use backend\modules\application\models\ApplicationCycle;
use common\models\AcademicYear;
/**
 * Default controller for the `application` module
 */
class DefaultController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction'
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = "main_public_beneficiary";

    public function actionIndex() {
        //$this->layout = "main_application";
        return $this->render('index');
    }
    public function actionLogin1($activeTab = 'home_page_contents_id', $message_type = NULL) {

        if (!\Yii::$app->user->isGuest) {

            if ((\Yii::$app->user->identity->status == 0)) {
//                if (!(\Yii::$app->controller->id == 'site' && \Yii::$app->controller->action->id = 'login' )) {
//                    $this->redirect(['site/login']);
//                }
            }

            return $this->redirect(['/application/default/index']);
        }


        $modelUser = new \frontend\modules\application\models\User();

        if ($modelUser->load(Yii::$app->request->post())) {
            if (false) {

                die('Registrations are currently closed');
            }
            $modelUser->username = $modelUser->email_address;
            $modelUser->is_default_password = 0;
            $modelUser->status = 10;
            $modelUser->login_type = 1;
            $modelUser->created_at = time();


            if ($modelUser->validate()) {
                $modelUser->password_hash = Yii::$app->getSecurity()->generatePasswordHash($modelUser->password_hash);

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$modelUser->save(false)) {
                        die('Technical Error 03, consult your system administrator');
                    }

                    $modelApplicant = new \frontend\modules\application\models\Applicant;
                    $modelApplicant->user_id = $modelUser->user_id;
//                    $modelApplicant->firstname = $modelUser->firstname;
//                    $modelApplicant->othernames = $modelUser->middlename;
//                    $modelApplicant->surname = $modelUser->surname;
                    $modelApplicant->save(false);
                    $modelApplication = new \frontend\modules\application\models\Application();
                    $modelApplication->applicant_id = $modelApplicant->applicant_id;
                    $modelApplication->academic_year_id = \frontend\modules\application\models\AcademicYear::find()->where("is_current = 1")->one()->academic_year_id;
                    $modelApplication->save(false);
                    $url = Url::to(['activate-account', 'id' => md5(sha1('300' . $modelUser->user_id . '300'))], true);
                    //$emailMessage = 'Please click the link below to activate your account and get reference number for application fee payment '.$url;
                    //$message = 'Account created. An email has been sent to '.$modelUser->email_address.', please login to to activate your account. '.$emailMessage;
                    //\Yii::$app->getSession()->setFlash('success',$message);
                    $account_created = [
                        'email' => $modelUser->email_address,
                        'activation_link' => $url,
                    ];


                    $fullname = $modelUser->firstname . " " . $modelUser->surname;
                    $subject = $fullname . " - Activate your account";

                    $activateAccEmail = Cnotification::find()->where("type = 'ACCOUNT_CREATED' ")->one()->notification;
                    $message = strip_tags($activateAccEmail, '<p><br><b><strong><em><i><u><sup><sub><ol><ul><li><a>');
                    $message = str_replace('{fullname}', $fullname, $message);
                    $message = str_replace('{url}', $url, $message);
                    /** Pending..
                      Yii::$app->mailer->compose()
                      ->setFrom(['info@heslb.org' => 'HESLB Loans Application System'])
                      ->setTo($modelUser->email_address)
                      ->setSubject($subject)
                      ->setHtmlBody($message)
                      ->send();
                     * 
                     */
                    Yii::$app->session->setFlash('account_created', $account_created);
                    $transaction->commit();
                    return $this->redirect(['login', 'activeTab' => 'register']);
                } catch (\Swift_TransportException $exep) {
                    $transaction->rollBack();
                    $modelUser->addError('email_address', 'Unable to send email, please try again later ' . $exep->getMessage());
                    $modelUser->password = NULL;
                    $modelUser->confirm_password = NULL;
                }
            } else {
                $modelUser->password = NULL;
                $modelUser->confirm_password = NULL;
            }

            $activeTab = 'register';
        }



        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

//            $loginsModel = new \common\models\Logs();
//            $loginsModel->user_id = \yii::$app->user->identity->id;
//            $loginsModel->ip_address = Yii::$app->getRequest()->getUserIP();
//            $loginsModel->details = Yii::$app->getRequest()->getUserAgent();
//            $loginsModel->datecreated = date('Y-m-d H:i:s');
//            $loginsModel->save();
            return $this->redirect(['/application/default/index']);
            //return $this->goBack();
        }
        if ($model->hasErrors()) {
            $activeTab = 'login_tab_id';
        }

        $username = Yii::$app->session->get('username_af');
        Yii::$app->session->set('username_af', NULL);
        if ($username !== NULL) {
            $model->username = $username;
        }


        return $this->render('home_main', [
                    'model' => $model,
                    'modelUser' => $modelUser,
                    'activeTab' => $activeTab,
                    'username' => $username,
                    'message_type' => $message_type,
        ]);
    }

    public function actionActivateAccount($id) {
        $modelUser = \app\models\ApplicantUser::find()->where("md5(sha1(concat('300',user_id,'300'))) = :id", [':id' => $id])->one();

        if ($modelUser == NULL) {
            return 'Error! Account not found. Please create a new one or contact our support team! ';
        }

        if ($modelUser->is_active == 1) {
            return $this->redirect(['/site/login', 'activeTab' => 'login_tab_id', 'message_type' => 'ACCOUNT_ACTIVATED']);
        }

        $modelApplicant = \app\models\Applicants::find()->where("user_id = {$modelUser->user_id}")->one();
//       
//       
//       $modelRefNo = new \app\models\RefNo();
//       $modelRefNo->applicant_id = $modelApplicant->applicant_id;
//       $modelRefNo->save(false);
//       
//       $ref_no = '1'. str_pad($modelRefNo->ref_no_id, 5, '0', STR_PAD_LEFT).'0';
//       $modelRefNo->ref_no = $ref_no;
//       $modelRefNo->date_generated = date('Y-m-d H:i:s');
        // if($modelRefNo->save()){
        $modelUser->is_active = 1;
        $modelUser->email_verified = 1;
        $modelUser->save(false);
        Yii::$app->session->setFlash('username_af', $modelUser->username);


        $modelInst = \app\models\Institution::findOne(1);
        $fullname = $modelApplicant->firstname . " " . $modelApplicant->surname;
        $subject = $fullname . " - Your Account has been activated";
        $message = strip_tags($modelInst->account_activated_message, '<p><br><b><strong><em><i><u><sup><sub><ol><ul><li><a>');
        $message = str_replace('{fullname}', $fullname, $message);
        $message = str_replace('{url}', $url, $message);

        Yii::$app->mailer->compose()
                ->setFrom(['info@admission.ac.tz' => $modelInst->institution_code . ' Admission'])
                ->setTo($modelUser->email_address)
                ->setSubject($subject)
                ->setHtmlBody($message)
                ->send();
        $modelNot = new \app\models\Notification();
        $modelNot->subject = $subject;
        $modelNot->notification = $message;
        $modelNot->date_created = date('Y-m-d H:i:s');
        $modelNot->user_id = $modelUser->user_id;
        $modelNot->is_read = 0;
        $modelNot->sent_notification_id = 0;
        $modelNot->save();


        return $this->redirect(['/site/login', 'activeTab' => 'login_tab_id']);
//       } else {
//           return 'Error occured';
//       }
    }

    public function actionMyApplicationIndex() {
        if (!\Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);

            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
			
			$applicationDetails = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->orderBy(['application_id'=>SORT_DESC])->one();
            $applicationCount = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->count();
            $applicationCyleDetails = ApplicationCycle::find()->where("academic_year_id = {$applicationDetails->academic_year_id}")->one();
            
            ###check current active academic year####
          $currentAcademicYear = AcademicYear::find()->where("is_current = '1'")->one();
          //$applicationCyle2 = ApplicationCycle::find()->where("academic_year_id = {$currentAcademicYear->academic_year_id}")->exists();
          if(ApplicationCycle::find()->where("academic_year_id = {$applicationDetails->academic_year_id}")->exists()){
            $exists=1;  
          }else{
            $exists=0;  
          }
          ### end check #############################

            if (false) {
                //view to be rendered, if the condition above is true 
            } else {
             if($applicationCount >=1){
                    if($exists==1){
                    if($applicationCyleDetails->application_cycle_status_id==2 && $applicationCount==1){
             return $this->redirect(['application-list']);             
                    }else if($applicationCyleDetails->application_cycle_status_id !=2 && $applicationCount==1){
             return $this->render('my_application_index', ['modelUser' => $modelUser, 'modelApplicant' => $modelApplicant]);          
                    }else if($applicationCyleDetails->application_cycle_status_id ==2 && $applicationCount >1){
             return $this->redirect(['application-list']);           
                    }else if($applicationCyleDetails->application_cycle_status_id !=2 && $applicationCount >1){
             return $this->redirect(['application-list']);           
                    }
                    }else{
            return $this->render('my_application_index', ['modelUser' => $modelUser, 'modelApplicant' => $modelApplicant]);           
                    }
                }else{
             return $this->render('my_application_index', ['modelUser' => $modelUser, 'modelApplicant' => $modelApplicant]);
                }
            }
        } else {
            return $this->redirect(['/application/default/login']);
        }
    }
    public function actionMyApplication() {
        if (!\Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);

            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();


            if (false) {
                //view to be rendered, if the condition above is true 
            } else {
                return $this->render('my_application_main', ['modelUser' => $modelUser, 'modelApplicant' => $modelApplicant]);
            }
        } else {
            return $this->redirect(['/application/default/login']);
        }
    }

    public function actionLoanApply() {
        $this->layout = "main_public";
        $model = new Education;
        $modelall = new \common\models\User();
        if ($modelall->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
                         
         
            if ($model->is_necta== 1) {
                        $oindex = trim(str_replace(".",'/',$model->registration_number));
                //create user account
                $modelall->load(Yii::$app->request->post());
                   if($modelall->firstname=="All"){
                   $modelname=  \common\models\User::getName($model->completion_year,$oindex);
                      
                       $modelall->firstname =$modelname["szFirstName"];
                       $modelall->middlename =$modelname["szOtherNames"];
                       $modelall->surname =$modelname["szSurName"];
                       $modelall->sex =$modelname["szSex"];
                     }
                $modelall->username =trim(strtoupper($model->registration_number.".".$model->completion_year));
                $modelall->login_type = 1;
                $modelall->setPassword(trim($modelall->password));
                $modelall->generateAuthKey();
                
                $name_fully=$modelall->firstname." ".$modelall->middlename." ".$modelall->surname;
                //enda  
                ###############create applicant information###############
                $toValidate = [
                    'user_id',
                    'sex',
                    'f4indexno',
                ];
                if ($modelall->save()) {
                  #################create applicant role #########
                                    $data=strtotime(date("Y-m-d"));
   Yii::$app->db->createCommand("INSERT  INTO auth_assignment(item_name,user_id,created_at) VALUES('non-paying',$modelall->user_id,$data)")->execute();           
                //end
                 ############################end create #########
                    $modelapp = new Applicant();
                    $modelapp->user_id = $modelall->user_id;
                    $modelapp->sex = Yii::$app->request->post("sex");
                    $modelapp->f4indexno = $modelall->username;
                    //$modelapp->save();
                    if ($modelapp->validate($toValidate, false)) {
                        if ($modelapp->save(false)) {
                            ##########end applicant###############
                            $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
                            ###############create application information###############
                            $toValidate_app = [
                                'applicant_id',
                                'academic_year_id'
                            ];
                            $model_app = new \backend\modules\application\models\Application();
                            $model_app->applicant_id = $modelapp->applicant_id;
                            $model_app->academic_year_id = $model_year->academic_year_id;

                            if ($model_app->validate($toValidate_app, false)) {
                                if ($model_app->save(false)) {
								
								
								
								## save bill number and request control number
									$applicationID=$model_app->application_id;
									$bill_number="HESLB_".$model_app->application_id;
									$amount=30000;
									$applicatDetails=Application::getApplicantDetails($modelapp->applicant_id);
									$name=$applicatDetails->user->firstname." ".$applicatDetails->user->middlename." ".$applicatDetails->user->surname;
									$phone_number=$applicatDetails->user->phone_number;
									$email=$applicatDetails->user->email_address;
									$applicantID=$applicatDetails->applicant_id;
									$indexNumber=$applicatDetails->f4indexno;
									Application::saveBillNumber($applicationID,$bill_number,$amount);
                                                                        
                                      $dataToQueue = ['billNumber' => $bill_number, 
                                                      "amount"=>$amount, 
                                                      "name"=>$name, 
                                                      "phone_number"=>$phone_number, 
                                                      "email"=>$email, 
                                                      "applicantID"=>$applicantID, 
                                                      "indexNumber"=>$indexNumber];
                                                                        
                                     //Producer::queue("GePGBillSubmitionQueue", $dataToQueue);

				    //$this->submitBill($bill_number, $amount, $name, $phone_number, $email, $applicantID, $indexNumber);
									##end save bill number
								

                                    ##########end application###############
                                    ###############create education information###############
                                    $toValidate_educt = [
                                        'application_id',
                                        'learning_institution_id',
                                        'level',
                                        'registration_number',
                                        'completion_year',
//                    'division',
//                    'points',
                                        'is_necta'
                                    ];
                                    /*
                                     * Get Institution Information
                                     */
                                    $institutioncode = explode(".", $model->registration_number)[0];
                                    $institution_id = $this->getInstitutionId($institutioncode, Yii::$app->request->post("institution"));
                                    /*
                                     * end search institution information
                                     */
                                    $model_educt = new \common\models\Education();
                                    $model_educt->application_id = $model_app->application_id;
                                    $model_educt->learning_institution_id = $institution_id;
                                    $model_educt->level = 'OLEVEL';
                                    
                                    $model_educt->registration_number =strtoupper($model->registration_number);
                                    $model_educt->completion_year = $model->completion_year;

                                    // $model_educt->division = Yii::$app->request->post("division");
                                    //$model_educt->points = Yii::$app->request->post("points");
                                    $model_educt->is_necta =1;
                                    if ($model_educt->validate($toValidate_educt, false)) {
                                        if ($model_educt->save(false)) {
                                            ############Display message to user 
                                              //  Yii::$app->session->setFlash('success', 'Your account have been created successfully ?Use this username:<b>'.$modelall->username.'</b> as login username and your password .');               
                                            //end 
                                              //  return $this->goBack();
                                         return $this->render('_login_help.php', ["username" => $modelall->username,'name_fully'=>$name_fully]);
                                        }
                                    }
                                    ##########end education###############   
                                }
                            }
                        }
                    }
                } else {
                 
                   return $this->render('loanapply', [
                                    'model' => $model,
                                    'modelall' => $modelall,
                        ]);
                  
                }
            } else {
                /*###########################################
                 * None necta application   NON-NECTA
                 */###########################################
                           $center_number='E00'.substr(date("Y"), -2);
                              
                            $oindex = trim($model->registration_number.'.'.$model->completion_year);
                //create user account
                     $temp_number="E".strtotime(date("Y-m-d H:i:s"));
                        $modelall->load(Yii::$app->request->post());
                        $modelall->username =$temp_number;
                        $modelall->login_type = 1;
                        $modelall->validated = 1;
                        $modelall->setPassword(trim($modelall->password));
                        $modelall->generateAuthKey();

                //enda  
                ###############create applicant information###############
                $toValidate = [
                    'user_id',
                    'sex',
                    'f4indexno',
                ];
                 $name_fully=$modelall->firstname." ".$modelall->middlename." ".$modelall->surname;
                if ($modelall->save()) {
                         //update username
                    $countall=  \common\models\User::find()->where("username like '$center_number%' AND user_id<$modelall->user_id")->count();
                        //end 
                  
                    $countall+=1;
                           if($countall<10){
                            $regNo="000".$countall;   
                           }
                          else if($countall>9&&$countall<100){
                            $regNo="00".$countall;   
                           }
                          else if($countall>99&&$countall<1000){
                            $regNo="0".$countall;   
                           }
                           else{
                            $regNo=$countall;      
                           }
                       
                       $modelall->username=trim($center_number.".".$regNo.".".$model->completion_year);
                       Yii::$app->db->createCommand("update user  set username='{$modelall->username}' WHERE user_id='{$modelall->user_id}'")->execute();           
                           #################create applicant role #########
                                    $data=strtotime(date("Y-m-d"));
   Yii::$app->db->createCommand("INSERT  INTO auth_assignment(item_name,user_id,created_at) VALUES('non-paying',$modelall->user_id,$data)")->execute();           
                //end   
                    $modelapp = new Applicant();
                    $modelapp->user_id = $modelall->user_id;
                    $modelapp->sex = $modelall->sex;
                    $modelapp->f4indexno =$center_number.".".$regNo.'.'.$model->completion_year;
                    //$modelapp->save();
                    if ($modelapp->validate($toValidate, false)) {
                        if ($modelapp->save(false)) {
                            ##########end applicant###############
                            $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
                            ###############create application information###############
                            $toValidate_app = [
                                'applicant_id',
                                'academic_year_id'
                            ];
                            $model_app = new \backend\modules\application\models\Application();
                            $model_app->applicant_id = $modelapp->applicant_id;
                            $model_app->academic_year_id = $model_year->academic_year_id;

                            if ($model_app->validate($toValidate_app, false)) {
                                if ($model_app->save(false)) {
								
								
								## save bill number and request control number
									$applicationID=$model_app->application_id;
									$bill_number="HESLB".$model_app->application_id;
									$amount=1500;
									$applicatDetails=Application::getApplicantDetails($modelapp->applicant_id);
									$name=$applicatDetails->user->firstname." ".$applicatDetails->user->middlename." ".$applicatDetails->user->surname;
									$phone_number=$applicatDetails->user->phone_number;
									$email=$applicatDetails->user->email_address;
									$applicantID=$applicatDetails->applicant_id;
									$indexNumber=$applicatDetails->f4indexno;
									Application::saveBillNumber($applicationID,$bill_number,$amount);
                                                                        
                                      $dataToQueue = ['billNumber' => $bill_number, 
                                                      "amount"=>$amount, 
                                                      "name"=>$name, 
                                                      "phone_number"=>$phone_number, 
                                                      "email"=>$email, 
                                                      "applicantID"=>$applicantID, 
                                                      "indexNumber"=>$indexNumber];
                                                                        
                                //Producer::queue("GePGBillSubmitionQueue", $dataToQueue);

									//$this->submitBill($bill_number, $amount, $name, $phone_number, $email, $applicantID, $indexNumber);
									##end save bill number

                                    ##########end application###############
                                    ###############create education information###############
                                    $toValidate_educt = [
                                        'application_id',
                                        'learning_institution_id',
                                        'level',
                                        'registration_number',
                                        'completion_year',
//                    'division',
//                    'points',
                                        'is_necta'
                                    ];
                                    /*
                                     * Get Institution Information
                                     */

                                    $institution_id = $this->getInstitutionNoneNecta($model->country_id, $model->institution_name);
                                    /*
                                     * end search institution information
                                     */
                                    $model_educt = new \common\models\Education();
                                    $model_educt->application_id = $model_app->application_id;
                                    $model_educt->learning_institution_id = $institution_id;
                                    $model_educt->level = 'OLEVEL';
                                    $model_educt->registration_number =$center_number.".".$regNo;
                                    $model_educt->registration_number_old =$model->registration_number;
                                    $model_educt->completion_year = $model->completion_year;

                                    // $model_educt->division = Yii::$app->request->post("division");
                                    // $model_educt->points = Yii::$app->request->post("points");
                                    $model_educt->is_necta = 2;
                                    if ($model_educt->validate($toValidate_educt, false)) {
                                        if ($model_educt->save(false)) {
                                            ############Display message to user 
         //Yii::$app->session->setFlash('success', 'Your account have been created successfully ?Use this username:<b>'.$modelall->username.'</b> as login username and your password .');               
                                            //end 
                return $this->render('_login_help.php', ["username" => $modelall->username,'name_fully'=>$name_fully]);
                                  ///  return $this->goBack();
                                          //  return $this->render('_login_help.php', ["username" => $modelall->username]);
                                        }
                                    }
                                    ##########end education###############   
                                }
                            }
                        }
                    }
                } else {
                  return $this->render('loanapply', [
                                    'model' => $model,
                                    'modelall' => $modelall,
                        ]);
                }
                /*
                 * end 
                 */
            }
        } else {
            return $this->render('loanapply', [
                        'model' => $model,
                        'modelall' => $modelall,
            ]);
        }
    }
    public function actionHomePage() {
        $this->layout = "main_public";
        $activeTab="";
         $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
          if ($model->hasErrors()) {
            $activeTab = 'login_tab_id';
        }
            if($_GET["activeTab"]!=""){
             $activeTab=$_GET["activeTab"];    
            }
     ##############################################################registration form here#################################
        $modeleduc = new Education;
        $modelall = new \common\models\User();
        if ($modelall->load(Yii::$app->request->post()) && $modeleduc->load(Yii::$app->request->post())) {

            if (Yii::$app->request->post("is_necta") == 1) {
                //create user account
                $modelall->load(Yii::$app->request->post());
                $modelall->firstname = Yii::$app->request->post("firstname");
                $modelall->middlename = Yii::$app->request->post("middlename");
                $modelall->surname = Yii::$app->request->post("surname");
                $modelall->sex = Yii::$app->request->post("sex");
                $modelall->username = strtoupper($modeleduc->registration_number . "/" . $modeleduc->completion_year);
                $modelall->login_type = 1;
                $modelall->setPassword(trim($modelall->password));
                $modelall->generateAuthKey();

                //enda  
                ###############create applicant information###############
                $toValidate = [
                    'user_id',
                    'sex',
                    'f4indexno',
                ];
                if ($modelall->save()) {
                    $modelapp = new Applicant();
                    $modelapp->user_id = $modelall->user_id;
                    $modelapp->sex = Yii::$app->request->post("sex");
                    $modelapp->f4indexno = $modelall->username;
                    //$modelapp->save();
                    if ($modelapp->validate($toValidate, false)) {
                        if ($modelapp->save(false)) {
                            ##########end applicant###############
                            $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
                            ###############create application information###############
                            $toValidate_app = [
                                'applicant_id',
                                'academic_year_id'
                            ];
                            $model_app = new \backend\modules\application\models\Application();
                            $model_app->applicant_id = $modelapp->applicant_id;
                            $model_app->academic_year_id = $model_year->academic_year_id;

                            if ($model_app->validate($toValidate_app, false)) {
                                if ($model_app->save(false)) {

                                    ##########end application###############
                                    ###############create education information###############
                                    $toValidate_educt = [
                                        'application_id',
                                        'learning_institution_id',
                                        'level',
                                        'registration_number',
                                        'completion_year',
//                    'division',
//                    'points',
                                        'is_necta'
                                    ];
                                    /*
                                     * Get Institution Information
                                     */
                                    $institutioncode = explode("/", $modeleduc->registration_number)[0];
                                    $institution_id = $this->getInstitutionId($institutioncode, Yii::$app->request->post("institution"));
                                    /*
                                     * end search institution information
                                     */
                                    $model_educt = new \common\models\Education();
                                    $model_educt->application_id = $model_app->application_id;
                                    $model_educt->learning_institution_id = $institution_id;
                                    $model_educt->level = 'OLEVEL';
                                    $model_educt->registration_number =$modeleduc->registration_number;
                                    $model_educt->completion_year = $modeleduc->completion_year;

                                    // $model_educt->division = Yii::$app->request->post("division");
                                    $model_educt->points = Yii::$app->request->post("points");
                                    $model_educt->is_necta = Yii::$app->request->post("is_necta");
                                    if ($model_educt->validate($toValidate_educt, false)) {
                                        if ($model_educt->save(false)) {
                                            ############Display message to user 
                                            //Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');               
                                            //end 
                                            return $this->render('_login_help.php', ["username" => $modelall->username]);
                                        }
                                    }
                                    ##########end education###############   
                                }
                            }
                        }
                    }
                } else {
                    //echo $modelall->password_hash."==".$modelall->confirm_password;   

                   // print_r($modelall);
                   // exit();
                }
            } else {
                /*
                 * None necta application
                 */
                //create user account
                $modelall->load(Yii::$app->request->post());
                $modelall->username = $modeleduc->registration_number . "/" . $modeleduc->completion_year;
                $modelall->login_type = 1;
                $modelall->validated = 1;
                $modelall->setPassword(trim($modelall->password));
                $modelall->generateAuthKey();

                //enda  
                ###############create applicant information###############
                $toValidate = [
                    'user_id',
                    'sex',
                    'f4indexno',
                ];
                if ($modelall->save()) {
                    $modelapp = new Applicant();
                    $modelapp->user_id = $modelall->user_id;
                    $modelapp->sex = $modelall->sex;
                    $modelapp->f4indexno = $modelall->username;
                    //$modelapp->save();
                    if ($modelapp->validate($toValidate, false)) {
                        if ($modelapp->save(false)) {
                            ##########end applicant###############
                            $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
                            ###############create application information###############
                            $toValidate_app = [
                                'applicant_id',
                                'academic_year_id'
                            ];
                            $model_app = new \backend\modules\application\models\Application();
                            $model_app->applicant_id = $modelapp->applicant_id;
                            $model_app->academic_year_id = $model_year->academic_year_id;

                            if ($model_app->validate($toValidate_app, false)) {
                                if ($model_app->save(false)) {

                                    ##########end application###############
                                    ###############create education information###############
                                    $toValidate_educt = [
                                        'application_id',
                                        'learning_institution_id',
                                        'level',
                                        'registration_number',
                                        'completion_year',
//                    'division',
//                    'points',
                                        'is_necta'
                                    ];
                                    /*
                                     * Get Institution Information
                                     */

                                    $institution_id = $this->getInstitutionNoneNecta($model->country_id, $model->institution_name);
                                    /*
                                     * end search institution information
                                     */
                                    $model_educt = new \common\models\Education();
                                    $model_educt->application_id = $model_app->application_id;
                                    $model_educt->learning_institution_id = $institution_id;
                                    $model_educt->level = 'OLEVEL';
                                    $model_educt->registration_number =$model->registration_number;
                                    $model_educt->completion_year = $modeleduc->completion_year;

                                    // $model_educt->division = Yii::$app->request->post("division");
                                    // $model_educt->points = Yii::$app->request->post("points");
                                    $model_educt->is_necta =2;
                                    if ($model_educt->validate($toValidate_educt, false)) {
                                        if ($model_educt->save(false)) {
                                            ############Display message to user 
                                            //Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');               
                                            //end 
                                            return $this->render('_login_help.php', ["username" => $modelall->username,'name_fully'=>""]);
                                        }
                                    }
                                    ##########end education###############   
                                }
                            }
                        }
                    }
                } else {
                    //echo $modelall->password_hash."==".$modelall->confirm_password;   

//                    print_r($modelall);
//                    exit();
                }
                /*
                 * end 
                 */
            }
        }else{
     ################################################end registration form##########################
        return $this->render('home_main', [
                    'model' => $model,
                      'modeleduc' => $modeleduc,
                    'activeTab' => $activeTab,
                    'modelall' => $modelall,
        ]);
        }
    }
 function actionNecta() {
        //  $index="S0750/0023/1891";
        #############check if this academic year exit or not
        $index = Yii::$app->request->post("registrationId") . "." . Yii::$app->request->post("year");

        $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
        $sqlitem = Yii::$app->db->createCommand("SELECT count(*) FROM `applicant` a join application app on a.`applicant_id`=app.`applicant_id` WHERE a.`f4indexno`='{$index}' AND `academic_year_id`='{$model_year->academic_year_id}'")->queryScalar();

        #####################end check###################
        if ($sqlitem == 0) {
            $model = Education::getOlevelDetails($index);
            // print_r($model);
            if (!is_array($model)) {
                return "<h4><font color='red'>" . $model . "</font></h4>";
            }
            // return print_r($model);   
            return $this->renderPartial('_necta_details', [
                        'model' => $model
            ]);
        } else {
            $alert = "alert-error";
            $model_name = \common\models\User::findOne(["username" => $index]);
            $name = $model_name->firstname . " " . $model_name->middlename . " " . $model_name->surname;
            $message = "Sorry you have account with this username:  $index and your Full Name is : $name";
            return $this->renderPartial('_message', [
                        'message' => $message,
                        'alert' => $alert,
            ]);
        }
    }
   function actionNectain() {
        //  $index="S0750/0023/1891";
        #############check if this academic year exit or not
        $index = Yii::$app->request->post("registrationId") . "." . Yii::$app->request->post("year");

        $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
        $sqlitem = Yii::$app->db->createCommand("SELECT count(*) FROM `applicant` a join application app on a.`applicant_id`=app.`applicant_id` WHERE a.`f4indexno`='{$index}' AND `academic_year_id`='{$model_year->academic_year_id}'")->queryScalar();

        #####################end check###################
        if ($sqlitem == 0) {
            $model = Education::getOlevelDetails($index);
            // print_r($model);
            if (!is_array($model)) {
                return "<h4><font color='red'>" . $model . "</font></h4>";
            }
            // return print_r($model);   
            return $this->renderPartial('_necta_details', [
                        'model' => $model
            ]);
        } else {
            $alert = "alert-error";
            $model_name = \common\models\User::findOne(["username" => $index]);
            $name = $model_name->firstname . " " . $model_name->middlename . " " . $model_name->surname;
            $message = "Sorry this form index number :  $index is already exit with  this  name : $name";
            return $this->renderPartial('_messagein', [
                        'message' => $message,
                        'alert' => $alert,
            ]);
        }
    }
 function actionNectaAlevel() {
        //  $index="S0750/0023/1891";
        #############check if this academic year exit or not
           $index = trim(Yii::$app->request->post("registrationId")).".".Yii::$app->request->post("year");
          
                     $year=date("Y");
                  if(Yii::$app->request->post("year")==$year){
                         $data=explode(".",Yii::$app->request->post("registrationId"));
            $model=  \backend\modules\application\models\LearningInstitution::find()->where(["institution_code"=>$data[0]])->one();
           
            return $this->renderPartial('_necta_detail_new', [
                        'model' => $model
            ]);
                  }
                  else{
          $model = Education::getAlevelDetails($index);
                if (!is_array($model)) {
                        $data=explode(".",Yii::$app->request->post("registrationId"));
            $modelall=  \backend\modules\application\models\LearningInstitution::find()->where(["institution_code"=>$data[0]])->one();
                  if(count($modelall)>0){
            return $this->renderPartial('_necta_detail_new', [
                        'model' => $modelall
            ]);
                  }
                return "<h4><font color='red'>" . $model . "</font></h4>";
            }
                 return $this->renderPartial('_necta_details', [
                        'model' => $model
            ]);          
                  }
      
    }
    /*
     * get or generate instititution Id;
     */

    function getInstitutionId($institution_code, $institution_name) {
        /*
         * find institution Id
         */
        $model = LearningInstitution::findOne(["institution_code" => $institution_code]);
        if (count($model) > 0) {
            return $model->learning_institution_id;
        } else {
            $toValidate_app = [
                'institution_name',
                'institution_code',
            ];
            $model_app = new LearningInstitution();
            $model_app->institution_code = $institution_code;
            $model_app->entered_by_applicant = 1;
            $model_app->institution_name = $institution_name;
            if ($model_app->validate($toValidate_app, false)) {
                if ($model_app->save(false)) {
                    return $model_app->learning_institution_id;
                }
            }
        }
        /*
         * end find 
         */
    }

    function getInstitutionNoneNecta($countryId, $institution_name) {
        /*
         * find institution Id
         */
        $model = LearningInstitution::find()->where("country_id='{$countryId}' AND institution_name like '%$institution_name%'")->limit(1)->all();
        if (count($model) > 0) {
            foreach ($model as $models)
                ;
            return $models["learning_institution_id"];
        } else {
            $toValidate_app = [
                'institution_name',
                'country_id',
            ];
            $model_app = new LearningInstitution();
            $model_app->country_id = $countryId;
            $model_app->entered_by_applicant = 1;
            $model_app->institution_name = $institution_name;
            if ($model_app->validate($toValidate_app, false)) {
                if ($model_app->save(false)) {
                    return $model_app->learning_institution_id;
                }
            }
        }
        /*
         * end find 
         */
    }

    function actionNoneNecta() {
        $modelall = new \common\models\User();
        return $this->renderAjax('_none_necta_details', [
                    'modelall' => $modelall
        ]);
    }
    function actionMyProfile() {
        $model = \common\models\User::findOne(Yii::$app->user->identity->user_id);
        $modelall = Applicant::findOne(["user_id" => Yii::$app->user->identity->user_id]);
        $modelApplication =Application::find()->where("applicant_id = {$modelall->applicant_id}")->one();
                     if($modelApplication->loan_application_form_status == ""){
                    if ($modelApplication->load(Yii::$app->request->post())) {
                          
                            $modelApplication->passport_photo=UploadedFile::getInstance($modelApplication,'passport_photo');
                                         
                                      if($modelApplication->passport_photo!=""){ 
                                       $modelApplication->passport_photo->saveAs('applicant_attachment/profile/'.$modelApplication->passport_photo->name);                  
                                       $modelApplication->passport_photo='applicant_attachment/profile/'.$modelApplication->passport_photo->name;
                                       $modelApplication->save();
                                         }
                            return $this->redirect(['my-profile']);
                        } else {
                            return $this->render('profile', [
                                    'model' => $model,
                                    'modelApplication' => $modelApplication,
                                    'modelall' => $modelall
                        ]);
                        }
              }
          else{
  return $this->redirect(['default/my-application-index']);          
          }
    }
function actionUpdateprofile() {
        $model = \common\models\User::findOne(Yii::$app->user->identity->user_id);
        $modelall = Applicant::findOne(["user_id" => Yii::$app->user->identity->user_id]);

        $modelapp = Application::findOne(["applicant_id" => $modelall->applicant_id]);
           if($modelapp->loan_application_form_status==""){
        if ($model->load(Yii::$app->request->post()) && $modelall->load(Yii::$app->request->post()) && $modelapp->load(Yii::$app->request->post())) {
         
            $toValidate_app = [
                'phone_number',
                'email_address',
            ];
                  
            if ($model->validate($toValidate_app, false)) {
                if ($model->save(false)) {
                    $toValidate = [
                        'date_of_birth',
                        'region_id',
                        'district_id',
                        'ward_id',
                        'mailing_address',
                        'place_of_birth',
                    ];
                           /*
                            *process all uploaded document
                            */           #########@@ start identification_document #################
                                       if($modelall->tasaf_support=="YES"){
                                        $modelall->tasaf_support_document=UploadedFile::getInstance($modelall,'tasaf_support_document');
                                       
                                         if($modelall->tasaf_support_document!=""){ 
                                         unlink($modelall->OldAttributes['tasaf_support_documen']); 
                                       $modelall->tasaf_support_document->saveAs('applicant_attachment/TASAF_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->tasaf_support_document->extension);                  
                                       $modelall->tasaf_support_document='applicant_attachment/TASAF_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->tasaf_support_document->extension;
                                       ############## identification_document ###############
                                      
                                       ApplicantAttachment::SaveAttachment($modelapp->application_id,9, $modelall->tasaf_support_document,1); 
                                         }
                                         else{
                                    $modelall->tasaf_support_document=$modelall->OldAttributes['tasaf_support_document'];
                                      } 
                                       }else{
                                         $modelall->tasaf_support_document=NULL;     
                                       }
                                       #########@@ start identification_document #################
                                       $modelall->identification_document=UploadedFile::getInstance($modelall,'identification_document');
                                       //var_dump($modelall);die();
                                         if($modelall->identification_document!=""){ 
                                         unlink($modelall->OldAttributes['identification_document']); 
                                       $modelall->identification_document->saveAs('applicant_attachment/IDENT_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->identification_document->extension);                  
                                       $modelall->identification_document='applicant_attachment/IDENT_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->identification_document->extension;
                                       ############## identification_document ###############
                                     
                                       ApplicantAttachment::SaveAttachment($modelapp->application_id,8, $modelall->identification_document,1); 
                                           }
                                         else{
                                    $modelall->identification_document=$modelall->OldAttributes['identification_document'];
                                      }
                                       #########@@ start birth_certificate_document #################
                                       $modelall->birth_certificate_document=UploadedFile::getInstance($modelall,'birth_certificate_document');
//                                           $files = glob('applicant_attachment/DOB_'.$modelapp->application_id.'_'.date("Y").'.*');
//                                            foreach ($files as $file) {
//                                              unlink($modelall->OldAttributes['birth_certificate_document']);
//                                            }
                                            
                                       if($modelall->birth_certificate_document!=""){ 
                                           unlink($modelall->OldAttributes['birth_certificate_document']); 
                                       $modelall->birth_certificate_document->saveAs('applicant_attachment/DOB_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->birth_certificate_document->extension);                  
                                       $modelall->birth_certificate_document='applicant_attachment/DOB_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->birth_certificate_document->extension;
                                       ############## birth_certificate_document ###############
                                       
                                       ApplicantAttachment::SaveAttachment($modelapp->application_id,7, $modelall->birth_certificate_document,1); 
                                           
                                          }
                                         else{
                                    $modelall->birth_certificate_document=$modelall->OldAttributes['birth_certificate_document'];
                                      }
                                       #########@@ start disability_document #################
                                       if($modelall->disability_status=="YES"){
                                      $modelall->disability_document=UploadedFile::getInstance($modelall,'disability_document');
                                        if($modelall->disability_document!=""){ 
                                        unlink($modelall->OldAttributes['disability_document']); 
                                       $modelall->disability_document->saveAs('applicant_attachment/DISABILITY_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->disability_document->extension);                  
                                       $modelall->disability_document='applicant_attachment/DISABILITY_'.$modelapp->application_id.'_'.date("Y").'.'.$modelall->disability_document->extension;
                                       ############## disability_document ###############
                                         
                                       ApplicantAttachment::SaveAttachment($modelapp->application_id,6, $modelall->disability_document,1); 
                                         
                                        }
                                         else{
                                    $modelall->disability_document=$modelall->OldAttributes['disability_document'];
                                      } 
                                       }
                                       else{
                                              $modelall->disability_document=NULL;
                                       }
                                      $modelapp->passport_photo=UploadedFile::getInstance($modelapp,'passport_photo');
                                         
                                      if($modelapp->passport_photo!=""){ 
                                       unlink($modelapp->OldAttributes['passport_photo']); 
                                       $modelapp->passport_photo->saveAs('applicant_attachment/profile/PHOTO_'.$modelapp->application_id.'_'.date("Y").'.'.$modelapp->passport_photo->extension);                  
                                       $modelapp->passport_photo='applicant_attachment/profile/PHOTO_'.$modelapp->application_id.'_'.date("Y").'.'.$modelapp->passport_photo->extension;
                                      ApplicantAttachment::SaveAttachment($modelapp->application_id,3, $modelapp->passport_photo,1); 
                                         
                                         }
                                         else{
                                    $modelapp->passport_photo=$modelapp->OldAttributes['passport_photo'];
                                      } 
                                   if($modelapp->save(false)){
                                       
                                   }
                                 else{
                            
                                    return $this->render('updateprofile', [
                                               'model' => $model,
                                               'modelall' => $modelall,
                                               'modelapp' => $modelapp
                                   ]);      
              
                                 }
                                  
                                
                                      /*
                             * end upload document
                             */
                        $modelall->NID=$modelall->NID!=""?$modelall->NID:NULL;
                    if ($modelall->validate($toValidate, false)) {
                        if ($modelall->save()) {
                      Yii::$app->getSession()->setFlash(
                                            'success', 'Data Successfully Updated!'
                                    );
                              
                          
                        }
                        else{
             return $this->render('updateprofile', [
                        'model' => $model,
                        'modelall' => $modelall,
                        'modelapp' => $modelapp
            ]);      
                } 
                    }
                   else{
             return $this->render('updateprofile', [
                        'model' => $model,
                        'modelall' => $modelall,
                        'modelapp' => $modelapp
            ]);      
                } 
//                   print_r($modelall->errors);
//                                            exit();
                }else{
             return $this->render('updateprofile', [
                        'model' => $model,
                        'modelall' => $modelall,
                        'modelapp' => $modelapp
            ]);      
                }
            }
            else{
            return $this->render('updateprofile', [
                        'model' => $model,
                        'modelall' => $modelall,
                        'modelapp' => $modelapp
            ]);     
            }
          //      print_r($model->errors);
            // exit();
            return $this->redirect(['my-profile']);
        } else {
            return $this->render('updateprofile', [
                        'model' => $model,
                        'modelall' => $modelall,
                        'modelapp' => $modelapp
            ]);
        }
           }
           else{
   return $this->redirect(['default/my-application-index']);                  
           }
    }
  public function actionLogin($activeTab = 'home_page_contents_id', $message_type = NULL) {

        if (!\Yii::$app->user->isGuest) {

            if ((\Yii::$app->user->identity->status == 0)) {
//                if (!(\Yii::$app->controller->id == 'site' && \Yii::$app->controller->action->id = 'login' )) {
//                    $this->redirect(['site/login']);
//                }
            }

            return $this->redirect(['/application/default/index']);
        }


        $modelUser = new \frontend\modules\application\models\User();
        
        if ($modelUser->load(Yii::$app->request->post())) {
            if (false) {

                die('Registrations are currently closed');
            }
            $modelUser->username = $modelUser->email_address;
            $modelUser->is_default_password = 0;
            $modelUser->status = 10;
            $modelUser->login_type = 1;
            $modelUser->created_at = time();
            

            if ($modelUser->validate()) {
                $modelUser->password_hash = Yii::$app->getSecurity()->generatePasswordHash($modelUser->password_hash);

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$modelUser->save(false)) {
                        die('Technical Error 03, consult your system administrator');
                    }

                    $modelApplicant = new \frontend\modules\application\models\Applicant;
                    $modelApplicant->user_id = $modelUser->user_id;

                    $modelApplicant->save(false);

                    $url = Url::to(['activate-account', 'id' => md5(sha1('300' . $modelUser->user_id . '300'))], true);
                    //$emailMessage = 'Please click the link below to activate your account and get reference number for application fee payment '.$url;
                    //$message = 'Account created. An email has been sent to '.$modelUser->email_address.', please login to to activate your account. '.$emailMessage;
                    //\Yii::$app->getSession()->setFlash('success',$message);
                    $account_created = [
                        'email' => $modelUser->email_address,
                        'activation_link' => $url,
                    ];

                    
                    $fullname = $modelUser->firstname . " " . $modelUser->surname;
                    $subject = $fullname . " - Activate your account";
                
                    Yii::$app->session->setFlash('account_created', $account_created);
                    $transaction->commit();
                    return $this->redirect(['login', 'activeTab' => 'register']);
                } catch (\Swift_TransportException $exep) {
                    $transaction->rollBack();
                    $modelUser->addError('email_address', 'Unable to send email, please try again later '.$exep->getMessage());
                    $modelUser->password = NULL;
                    $modelUser->confirm_password = NULL;
                }
            } else {
                $modelUser->password = NULL;
                $modelUser->confirm_password = NULL;
            }

            $activeTab = 'register';
        }



        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $loginsModel = new \common\models\Logs();
            $loginsModel->user_id = \yii::$app->user->identity->id;
            $loginsModel->ip_address = Yii::$app->getRequest()->getUserIP();
            $loginsModel->details = Yii::$app->getRequest()->getUserAgent();
            $loginsModel->datecreated = date('Y-m-d H:i:s');
            $loginsModel->save();
            return $this->redirect(['/application/default/index']);
            //return $this->goBack();
        }
        if ($model->hasErrors()) {
            $activeTab = 'login_tab_id';
        }

        $username = Yii::$app->session->get('username_af');
        Yii::$app->session->set('username_af', NULL);
        if ($username !== NULL) {
            $model->username = $username;
        }


        return $this->render('home_main', [
                    'model' => $model,
                    'modelUser' => $modelUser,
                    'activeTab' => $activeTab,
                    'username' => $username,
                    'message_type' => $message_type,
        ]);
    }
   public function actionHelp(){
          $username="S0750.0023.2006";
          $name_fully="Mickidadi Kosiyanga";
    return $this->render('_login_help.php', ["username" =>$username,"name_fully" =>$name_fully]);   
   }  
  public function actionGuidelineEnglish(){
     $this->layout = "main_public";       
    return $this->render('guideline_english');   
   }
   public function actionGuidelineSwahili(){
           $this->layout = "main_public"; 
    return $this->render('guideline_swahili');   
   }
   public function actionPaymentStatus(){
       $this->layout = "default_main";       
    return $this->render('payment_status');   
   }
   public function actionApplicationList() { 
       $searchModel = new ApplicationSearch();
       $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
       $dataProvider = $searchModel->searchIndexApplicant(Yii::$app->request->queryParams,$modelApplicant->applicant_id);
        return $this->render('application_list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelUser' => $modelUser,
                    'modelApplicant' => $modelApplicant,
        ]);
    }
  public function actionNewApplication() {
        if (!\Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);

            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();

            if (false) {
                //view to be rendered, if the condition above is true 
            } else {
             return $this->render('my_application_index', ['modelUser' => $modelUser, 'modelApplicant' => $modelApplicant]);
            }
        } else {
            return $this->redirect(['/application/default/login']);
        }
    }
}

