<?php
namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\Applicant;
use backend\modules\application\models\ApplicationSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
use frontend\modules\application\models\ApplicantAttachment;
use yii\web\UploadedFile;
use common\models\District;
use frontend\modules\application\models\ApplicantAttachmentSearch;
use backend\modules\application\models\ReattachmentSetting;
use backend\modules\allocation\models\Allocation;
use backend\modules\allocation\models\AllocationSearch;
use backend\modules\disbursement\models\Disbursement;
use backend\modules\disbursement\models\DisbursementSearch;


/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
{
    /**
     * @inheritdoc
     */
     public $layout="main_public_beneficiary";
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
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */
    public function actionUploadMissingAttachment($id)
    {
        $user_id = Yii::$app->user->identity->user_id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $model=$this->findModel($modelApplicant->applicant_id);
        
        $searchModel = new ApplicantAttachmentSearch();
        $dataProvider = $searchModel->searchfile(Yii::$app->request->queryParams,$model->application_id);
        
        return $this->render('upload_missing_attachment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'application_id'=>$model->application_id
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Application();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->application_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->application_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$url)
    {
        $this->findModel($id)->delete();

        return $this->redirect(["$url"]);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
     public function actionStudyView()
    {
           $user_id = Yii::$app->user->identity->id;
           //  $model = $this->findModel($id);
           $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
           $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
     
        if ($model->load(Yii::$app->request->post())) {
               
                             if($model->applicant_category_id==2||$model->applicant_category_id==5){
                   ##########################admission Letter#####################
                $model->admission_letter = UploadedFile::getInstance($model, 'admission_letter');
                if ($model->admission_letter != "") {
                      unlink($model->OldAttributes['admission_letter']); 
                    $model->admission_letter->saveAs('applicant_attachment/admission_'.$model->application_id.'_'.date("Y").'.'.$model->admission_letter->extension);
                    $model->admission_letter = 'applicant_attachment/admission_'.$model->application_id.'_'.date("Y").'.'.$model->admission_letter->extension;
                         
                  
                   ApplicantAttachment::SaveAttachments($model->application_id,4, $model->admission_letter,1); 
                    
                  } else {
                    $model->admission_letter = $model->OldAttributes['admission_letter'];
                }
           ##############################end admission letter#######################################    
           #######################employer letter   ################################################
                  
                $model->employer_letter = UploadedFile::getInstance($model, 'employer_letter');
                if ($model->employer_letter != "") {
                    unlink($model->OldAttributes['employer_letter']); 
                    $model->employer_letter->saveAs('applicant_attachment/emp_letter_'.$model->application_id.'_'.date("Y").'.'.$model->employer_letter->extension);
                    $model->employer_letter = 'applicant_attachment/emp_letter_'.$model->application_id.'_'.date("Y").'.'.$model->employer_letter->extension;
                
                 
                   ApplicantAttachment::SaveAttachments($model->application_id,5, $model->employer_letter,1); 
                    
                } else {
                    $model->employer_letter = $model->OldAttributes['employer_letter'];
                }
                   }
                  else {
                    $model->employer_letter=NULL;  
                    $model->admission_letter=Null;
                  }  
                if($model->save()){
                 //   print_r($model->errors);
                   // exit();
            return $this->redirect(['study-view']);
                }
                else{
                    return $this->render('_study_level', [
            'model' => $model,
        ]);         
                }
        } else {
            return $this->render('view_study_level', [
            'model' => $model,
        ]);
        }
    }
    public function actionStudyUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
                     if($model->applicant_category_id==2||$model->applicant_category_id==5){
                   ##########################admission Letter#####################
                   $model->admission_letter = UploadedFile::getInstance($model, 'admission_letter');
                if ($model->admission_letter != "") {
                    unlink($model->OldAttributes['admission_letter']); 
                    $model->admission_letter->saveAs('applicant_attachment/admission_'.$model->application_id.'_'.date("Y").'.'.$model->admission_letter->extension);
                    $model->admission_letter = 'applicant_attachment/admission_'.$model->application_id.'_'.date("Y").'.'.$model->admission_letter->extension;
                  
                   ApplicantAttachment::SaveAttachment($model->application_id,4, $model->admission_letter); 
                    
                    } else {
                    $model->admission_letter = $model->OldAttributes['admission_letter'];
                }
           ##############################end admission letter#######################################    
           #######################employer letter   ################################################
                  
                $model->employer_letter = UploadedFile::getInstance($model, 'employer_letter');
                if ($model->employer_letter != "") {
                      unlink($model->OldAttributes['employer_letter']); 
                    $model->employer_letter->saveAs('applicant_attachment/emp_letter_'.$model->application_id.'_'.date("Y").'.'.$model->employer_letter->extension);
                    $model->employer_letter = 'applicant_attachment/emp_letter_'.$model->application_id.'_'.date("Y").'.'.$model->employer_letter->extension;
                  unlink($model->OldAttributes['employer_letter']); 
                   ApplicantAttachment::SaveAttachment($model->application_id,5, $model->employer_letter); 
                    
                    } else {
                    $model->employer_letter = $model->OldAttributes['employer_letter'];
                }
                   }
                  else {
                    $model->employer_letter=NULL;  
                    $model->admission_letter=Null;
                  } 
            if($model->save()){
                  //enddelete all information of applicant associate
                    Yii::$app->db->createCommand("DELETE FROM `applicant_associate` WHERE application_id='{$model->application_id}' AND type='GA'")->execute();           
                            
                    //end 
            return $this->redirect(['study-view']);
                }
                else{
                    return $this->render('study_update', [
            'model' => $model,
        ]);         
                }
           #############################end employer############################################    
           
            
            return $this->redirect(['study-view']);
        } else {
            return $this->render('study_update', [
                'model' => $model,
            ]);
        }
    }
    
    
    
  public function actionSubmitApplication($action = null)
    {
         $user_id = Yii::$app->user->identity->id;
         $modelUser = \common\models\User::findOne($user_id);
         $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
         $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
          if($model->loan_application_form_status  != 1 & $action == 'submit'){
             $model->loan_application_form_status  = 1;
             $model->application_form_number = $model->generateFormNumber($model->applicant_id,$model->applicantCategory->applicant_category_code);
             $model->save(false);
           $sms="<p>You have successfully confirmed your application, Kindly Download the Application Form get it signed and Upload the signed Page #2 and Page #5(Step #11 below). Thanks!!!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
      return $this->redirect(['/application/default/my-application-index']);
         }
       else{
        return $this->render('submit_my_application', [
                'model' => $model,
            ]);
       }    
    }
  public function actionApplicationForm()
    {
         $user_id = Yii::$app->user->identity->id;
         $modelUser = \common\models\User::findOne($user_id);
         $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
         $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
           if($model->applicant_category_id == 1 || $model->applicant_category_id == 3 || $model->applicant_category_id == 4){
             if($model->loan_application_form_status >= 2){
                 $view = '_signed_application_form';
               }
             else{
                 $view = '_application_form';
               }
            }
         else{
               if($model->loan_application_form_status >= 2){
                  $view = '_postgraduate_signed_application_form.php';
                 }
               else{
                  $view = '_postgraduate_application_form.php';
               }
             }
          return $this->render($view, [
                'model' => $model,
            ]);  
     }

        public function actionUploadSignedForm()
    {
       $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
       $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
       $model->scenario = 'upload-signed-form';
        if ($model->load(Yii::$app->request->post())) {
            $model->loan_application_form_status  = 2;
            $clear_attached_pages = ApplicantAttachment::deleteAll(['application_id' => $model->application_id]);
            $model->page_number_two = UploadedFile::getInstance($model, 'page_number_two');
            $model->page_number_two->saveAs('applicant_attachment/loanApplicationFormPageNumberTwo_'.$model->application_id.'.'.$model->page_number_two->extension);
            $page_number_two_application_id = $model->application_id.'.'.$model->page_number_two->extension;
            $page_number_two_application_form_number = $model->application_form_number.'.'.$model->page_number_two->extension;
            $cmd_page_number_two = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dBATCH -sOutputFile=applicant_attachment/loanApplicationFormPageNumberTwo_$page_number_two_application_form_number applicant_attachment/loanApplicationFormPageNumberTwo_$page_number_two_application_id";
            $result_page_number_two = shell_exec($cmd_page_number_two);
            $page_number_two_model = new ApplicantAttachment();
            $page_number_two_model->application_id = $model->application_id;
            $page_number_two_model->attachment_definition_id = 2;
            $page_number_two_model->attachment_path = 'loanApplicationFormPageNumberTwo_'.$model->application_form_number.'.pdf'; 
            $page_number_two_model->save();

            $model->page_number_five = UploadedFile::getInstance($model, 'page_number_five');
            $model->page_number_five->saveAs('applicant_attachment/loanApplicationFormPageNumberFive_'.$model->application_id.'.'.$model->page_number_five->extension);
            $page_number_five_application_id = $model->application_id.'.'.$model->page_number_five->extension;
            $page_number_five_application_form_number = $model->application_form_number.'.'.$model->page_number_five->extension;
            $cmd_page_number_five = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dBATCH -sOutputFile=applicant_attachment/loanApplicationFormPageNumberFive_$page_number_five_application_form_number applicant_attachment/loanApplicationFormPageNumberFive_$page_number_five_application_id";
            $result_page_number_five = shell_exec($cmd_page_number_five);


            $page_number_five_model = new ApplicantAttachment();
            $page_number_five_model->application_id = $model->application_id;
            $page_number_five_model->attachment_definition_id = 4;
            $page_number_five_model->attachment_path = 'loanApplicationFormPageNumberFive_'.$model->application_form_number.'.pdf'; 
            $page_number_five_model->save();


            if($model->save(false)){                            
              $sms="<p>You have successfully Uploaded Signed and Certified Pages #2 and #5. You may please proceed with the next stage. Thanks!!!</p>";
               Yii::$app->getSession()->setFlash('success', $sms);
               return $this->redirect(['/application/default/my-application-index']);
            }
        } else {
            return $this->render('_upload_signed_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionCloseMyApplication($action = null)
    { 
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
        if($model->loan_application_form_status  != 3 & $action == 'close'){
          $model->loan_application_form_status  = 3;
          $model->save(false);
           $sms="<p>Congralatulation! You have successfully submitted your Application</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
      return $this->redirect(['/application/default/my-application-index']);
         }
       else{
        return $this->render('close_my_application', [
                'model' => $model,
            ]);
        }
    }

     public function actionViewApplication()
     {
       $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
       $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
        return $this->render('application_details', [
                'model' => $model,
            ]);
    }
   public function actionDownloadMyApplication()
    {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
         return $this->render('download_application_form', [
                'model' => $model,
       ]);
    }
    public function actionSubmitAttachment()
    {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            //find missing attachment 
            
        //  print_r($modelall['verification_status']);
        $modelall=ReattachmentSetting::findbysql('SELECT group_concat(verification_status) as verification_status ,
                        group_concat(comment_id) as comment_id FROM `reattachment_setting` WHERE `is_active`=1')->asArray()->one();
        // print_r($modelall);
        //   exit();
        //  print_r($modelall['verification_status']);
        $verification_status=$modelall['verification_status'];
        $comment_id="";
        if($modelall['comment_id']!=""){
            $comment_id=$modelall['comment_id'];
        }
        // $commentsql='';
        if($comment_id!=""){
            $commentsql=" AND comment IN($comment_id)";
        }
        Yii::$app->db->createCommand("UPDATE  applicant_attachment set submited=2,verification_status=0 WHERE application_id='{$model->application_id}' AND verification_status IN($verification_status) $commentsql")->execute();
        $model->resubmit=1;
        $model->save(FALSE);
        //end
        //  $query = ApplicantAttachment::find()->where("application_id='{$application_id}' AND verification_status IN($verification_status) $commentsql ");
       // $query = ApplicantAttachment::find()->where("application_id='{$model->application_id}'");
        
             
            $sms="<p>You have successfully submit your attachment(s)). Thanks!!!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['/application/default/my-application-index']);
        
    }
    public function actionApplicationFormGeneral($id)
    {
         $user_id = Yii::$app->user->identity->id;
         $modelUser = \common\models\User::findOne($user_id);
         $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
         $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
           if($model->applicant_category_id == 1 || $model->applicant_category_id == 3 || $model->applicant_category_id == 4){
             if($model->loan_application_form_status >= 2){
                 $view = '_signed_application_form';
               }
             else{
                 $view = '_application_form';
               }
            }
         else{
               if($model->loan_application_form_status >= 2){
                  $view = '_postgraduate_signed_application_form.php';
                 }
               else{
                  $view = '_postgraduate_application_form.php';
               }
             }
          return $this->render($view, [
                'model' => $model,
                'application_id'=>$id, 
            ]);  
     }
     public function actionViewAttachments($id) {
        $model = $this->findModel($id);
        $searchModel = new ApplicantAttachmentSearch();
        $dataProvider = $searchModel->searchAttachments(Yii::$app->request->queryParams,$id);
        return $this->render('view_attachments', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'application_id'=>$id,
                    'searchModel' => $searchModel,
        ]);
     
   }
   public function actionAllocatedLoan() { 
       $searchModel = new AllocationSearch();
       $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();       
       $dataProvider = $searchModel->searchAllocatedLoan(Yii::$app->request->queryParams,$modelApplicant->applicant_id);

        return $this->render('allocated_loan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelUser' => $modelUser,
                    'modelApplicant' => $modelApplicant,
        ]);
    }
    
    public function actionDisbursedLoan() { 
       $searchModel = new DisbursementSearch();
       $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();       
       $dataProvider = $searchModel->searchDisbursedLoan(Yii::$app->request->queryParams,$modelApplicant->applicant_id);

        return $this->render('disbursed_loan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelUser' => $modelUser,
                    'modelApplicant' => $modelApplicant,
        ]);
    }
    public function actionNotification() { 
       $searchModel = new DisbursementSearch();
       $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();       
       $dataProvider = $searchModel->searchDisbursedLoan(Yii::$app->request->queryParams,$modelApplicant->applicant_id);

        return $this->render('notification', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelUser' => $modelUser,
                    'modelApplicant' => $modelApplicant,
        ]);
    }
	public function actionApplicationOriginalForm()
     {
         $user_id = Yii::$app->user->identity->id;
         $modelUser = \common\models\User::findOne($user_id);
         $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
         $model = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
         if($model->applicant_category_id == 1 || $model->applicant_category_id == 3 || $model->applicant_category_id == 4){
             
                 $view = '_application_form';
          
         }
         else{
           $view = '_postgraduate_application_form.php';
         }
         return $this->render($view, [
             'model' => $model,
         ]);
     }

}

