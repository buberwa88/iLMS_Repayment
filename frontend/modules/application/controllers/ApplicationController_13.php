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
             $user_id = Yii::$app->user->identity->id;
           //  $model = $this->findModel($id);
           $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        if (($model = Application::findOne(['application_id'=>$id,'applicant_id'=>$modelApplicant->applicant_id])) !== null) {
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
           if($model->loan_application_form_status==""){
        if ($model->load(Yii::$app->request->post())) {
                       if($model->applicant_category_id==2||$model->applicant_category_id==4||$model->applicant_category_id==5){
                   ##########################admission Letter#####################
                $model->admission_letter = UploadedFile::getInstance($model, 'admission_letter');
                if ($model->admission_letter != "") {
                    $model->admission_letter->saveAs('applicant_attachment/' . $model->admission_letter->name);
                    $model->admission_letter = 'applicant_attachment/' . $model->admission_letter->name;
                } else {
                    $model->admission_letter = $model->OldAttributes['admission_letter'];
                }
           ##############################end admission letter#######################################    
           #######################employer letter   ################################################
                  
                $model->employer_letter = UploadedFile::getInstance($model, 'employer_letter');
                if ($model->employer_letter != "") {
                    $model->employer_letter->saveAs('applicant_attachment/' . $model->employer_letter->name);
                    $model->employer_letter = 'applicant_attachment/' . $model->employer_letter->name;
                } else {
                    $model->employer_letter = $model->OldAttributes['employer_letter'];
                }
                   }
                  else {
                    $model->employer_letter=NULL;  
                    $model->admission_letter=Null;
                  }
           $model->save();        
            return $this->redirect(['study-view']);
        } else {
            return $this->render('view_study_level', [
            'model' => $model,
        ]);
        }
           }
           else{
  return $this->redirect(['default/my-application-index']);                
           }
    }
    public function actionStudyUpdate($id)
    {
            $model = $this->findModel($id);
             if($model->loan_application_form_status==""){
        if ($model->load(Yii::$app->request->post())) {
                     if($model->applicant_category_id==2||$model->applicant_category_id==4||$model->applicant_category_id==5){
                   ##########################admission Letter#####################
                $model->admission_letter = UploadedFile::getInstance($model, 'admission_letter');
                if ($model->admission_letter != "") {
                    $model->admission_letter->saveAs('applicant_attachment/' . $model->admission_letter->name);
                    $model->admission_letter = 'applicant_attachment/' . $model->admission_letter->name;
                } else {
                    $model->admission_letter = $model->OldAttributes['admission_letter'];
                }
           ##############################end admission letter#######################################    
           #######################employer letter   ################################################
                  
                $model->employer_letter = UploadedFile::getInstance($model, 'employer_letter');
                if ($model->employer_letter != "") {
                    $model->employer_letter->saveAs('applicant_attachment/' . $model->employer_letter->name);
                    $model->employer_letter = 'applicant_attachment/' . $model->employer_letter->name;
                } else {
                    $model->employer_letter = $model->OldAttributes['employer_letter'];
                }
                   }
                  else {
                    $model->employer_letter=NULL;  
                    $model->admission_letter=Null;
                  }
           $model->save();
           #############################end employer############################################    
           
            
            return $this->redirect(['study-view']);
        } else {
            return $this->render('study_update', [
                'model' => $model,
            ]);
        }
      }
    else{
  return $this->redirect(['default/my-application-index']);                
       }
    }
    
     public function actionViewApplication($id)
    {
        $model = $this->findModel($id);
        return $this->render('application_details', [
                'model' => $model,
            ]);
    }
   
     public function actionUploadSignedForm($id)
    {
       $model = $this->findModel($id);
       $model->scenario = 'upload-signed-form';
        if ($model->load(Yii::$app->request->post())) {
            $model->loan_application_form_status  = 2;
            $clear_attached_pages = ApplicantAttachment::deleteAll(['application_id' => $model->application_id]);
            $model->page_number_two = UploadedFile::getInstance($model, 'page_number_two');
                      if($model->page_number_two!=""){
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
                      }
                        if( $model->page_number_five!=""){
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
                        }

            if($model->save(false)){
              $sms="<p>You have successfully Uploaded Signed and Certified Pages #2 and #5,.You may please proceed with the next stage.Thanks!!!</p>";
               Yii::$app->getSession()->setFlash('success', $sms);
               return $this->redirect(['/application/default/my-application-index']);
            }
        } else {
            return $this->render('_upload_signed_form', [
                'model' => $model,
            ]);
        }
    }
 



  public function actionSubmitApplication($id,$action = null)
    {
        $model = $this->findModel($id);
          if($model->loan_application_form_status  != 1 & $action == 'submit'){
          $model->loan_application_form_status  = 1;
          $model->application_form_number = $model->generateFormNumber($model->applicant_id,$model->applicantCategory->applicant_category_code);
          $model->save(false);
           $sms="<p>You have successfully submitted your application,Kindly Download the Application Form get it signed and Upload the signed Page #2 and Page #5(Step #11 below).Thanks!!!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
      return $this->redirect(['/application/default/my-application-index']);
         }
       else{
        return $this->render('submit_my_application', [
                'model' => $model,
            ]);
       }
    }



   public function actionDownloadMyApplication($id)
    {
        $model = $this->findModel($id);
         return $this->render('download_application_form', [
                'model' => $model,
       ]);
    }



    public function actionCloseMyApplication($id,$action = null)
    {
        $model = $this->findModel($id);
        if($model->loan_application_form_status  != 3 & $action == 'close'){
          $model->loan_application_form_status  = 3;
          $model->save(false);
           $sms="<p>You have successfully closed your Application,Keep Previewimg your Application by Clicking the Preview Application.Thanks!!!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
      return $this->redirect(['/application/default/my-application-index']);
         }
       else{
        return $this->render('close_my_application', [
                'model' => $model,
            ]);
        }
    }
    
 public function actionApplicationForm($id)
    {
        $model = $this->findModel($id);
        if($model->loan_application_form_status == 2){
           $view = '_signed_application_form';
        }
        else{
           $view = '_application_form';
        }
        return $this->render($view, [
                'model' => $model,
            ]);
    }
    
}
