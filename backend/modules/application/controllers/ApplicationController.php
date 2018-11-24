<?php

namespace backend\modules\application\controllers;

use Yii;
use mPDF;
use backend\modules\application\models\Application;
use backend\modules\application\models\ApplicationSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
use yii\data\SqlDataProvider;
use common\models\ApplicantQuestion;
use frontend\modules\application\models\ApplicantAttachmentSearch;
use frontend\modules\application\models\ApplicantAttachment;
use backend\modules\application\models\VerificationFrameworkItemSearch;
use backend\modules\application\models\VerificationFrameworkItem;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $this->layout = "main_private";
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
    public function actionIndex() {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexCompliance() {

        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchcompliance(Yii::$app->request->queryParams);

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
    /*
      public function actionView($id)
      {
      return $this->render('view', [
      'model' => $this->findModel($id),
      ]);
      }
     */

    public function actionView($id,$action = null) {
     if($action == 'view'){
       $model = $this->findModel($id);
        return $this->render('application_details', [
                    'model' => $model,
        ]);
      } 
     else{
        if (isset($_POST['VerificationFrameworkItem'])) {
            $posted_data = Yii::$app->request->post();
            $applicant_attachment_id = $posted_data['VerificationFrameworkItem']['applicant_attachment_id'];            
            $verification_status = $posted_data['VerificationFrameworkItem']['verification_status'];            
            $comment = $posted_data['VerificationFrameworkItem']['comment'];
            $other_description = $posted_data['VerificationFrameworkItem']['other_description'];
            $sponsor_address = $posted_data['VerificationFrameworkItem']['sponsor_address'];
            $attachment_definition_id = $posted_data['VerificationFrameworkItem']['attachment_definition_id'];
            $attachment_path = $posted_data['VerificationFrameworkItem']['attachment_path'];
            $todate=date("Y-m-d H:i:s");
            $userID=Yii::$app->user->identity->user_id;

            $verificationFrameworkIDP = $posted_data['VerificationFrameworkItem']['verification_framework_id'];
           
            if($applicant_attachment_id !=''){
            $applicant_attachment = ApplicantAttachment::findOne(['applicant_attachment_id'=>$applicant_attachment_id]);

		$applicant_attachment->verification_status = $verification_status;            
		$applicant_attachment->comment = $comment;
		$applicant_attachment->other_description = $other_description;
		$applicant_attachment->sponsor_address = $sponsor_address;
		if($attachment_path==''){
		$applicant_attachment->attachment_path = "applicant_attachment/profile/verification_missing_image.jpg"; 
		}
                $applicant_attachment->last_verified_by = $userID;
                $applicant_attachment->last_verified_at  = $todate;
		$applicant_attachment->save();
		}
		if($applicant_attachment_id==''){
		$applicantAttachmentModel = new ApplicantAttachment(); 
		$applicantAttachmentModel->application_id=$id;
		$applicantAttachmentModel->attachment_definition_id=$attachment_definition_id;
		$applicantAttachmentModel->attachment_path="applicant_attachment/profile/verification_missing_image.jpg"; 
		$applicantAttachmentModel->verification_status = $verification_status;            
		$applicantAttachmentModel->comment = $comment;
		$applicantAttachmentModel->other_description = $other_description;
		$applicantAttachmentModel->sponsor_address = $sponsor_address;
                $applicantAttachmentModel->last_verified_by = $userID;
                $applicantAttachmentModel->last_verified_at  = $todate;
		$applicantAttachmentModel->save();   
		}
            
           $vreificationFrameworkResults = Application::findOne(['application_id'=>$id]);
            if($vreificationFrameworkResults->verification_framework_id==''){
             $vreificationFrameworkResults->verification_framework_id=$verificationFrameworkIDP;
             $vreificationFrameworkResults->save();
            }

$vreificationFrameworkResultsAttemptedBy = Application::findOne(['application_id'=>$id]);
$userAttempted = Yii::$app->user->identity->user_id;
$date_verified=$vreificationFrameworkResultsAttemptedBy->date_verified;
$todate=date("Y-m-d");
if(($vreificationFrameworkResultsAttemptedBy->last_verified_by != $userAttempted) && ($date_verified !=$todate)){
 $userAttempted = Yii::$app->user->identity->user_id;   
 $vreificationFrameworkResultsAttemptedBy->last_verified_by=$userAttempted;
 $vreificationFrameworkResultsAttemptedBy->date_verified=date("Y-m-d H:i:s");
 $vreificationFrameworkResultsAttemptedBy->save();
}

$activity="Verification of Applicant Attachment";
                   $done_by=Yii::$app->user->identity->user_id;
                   $done_at=date("Y-m-d H:i:s");
                   $other=$applicant_attachment_id;
                   //$comment=$comment;
                   \backend\modules\application\models\VerificationActivitiesHistory::insertVerificationActivityHistory($id,$activity,$done_by,$done_at,$other,$comment);

           //$this->checkApplicationStatus($id);
           $this->checkApplicationStatus($verificationFrameworkIDP,$id);
        }

        $model = $this->findModel($id);

        $searchModel = new VerificationFrameworkItemSearch();
       //$searchModel = new ApplicantAttachmentSearch();
        //$condition = "application_id={$model->application_id}";
	$condition =$model->application_id;
        $applicationID=$model->application_id;
        $applicantCategory=$model->applicant_category_id;
        $released=$model->released;
        $verificationStatus=$model->verification_status;

        $verification_framework_id =$model->verification_framework_id;
        if($verification_framework_id==''){
            $verificationF=\backend\modules\application\models\VerificationFramework::getActiveFramework($applicantCategory);
            $verificationFrameworkID=$verificationF->verification_framework_id;
        }else{
           $verificationFrameworkID=$verification_framework_id;   
        }

       //$dataProvider = $searchModel->searchVerify(Yii::$app->request->queryParams, $condition,$verificationFrameworkID);
      //$dataProvider=\backend\modules\application\models\VerificationFrameworkItem::getVerificationAttachments($applicationID, $verificationFrameworkID);
      if($released==NULL OR $released==''){
       $dataProvider=\backend\modules\application\models\VerificationFrameworkItem::getVerificationAttachments($applicationID, $verificationFrameworkID);
       }else{
        $dataProvider=\backend\modules\application\models\VerificationFrameworkItemPassed::getVerificationFrameworkItemPassed($applicationID,$verificationFrameworkID);   
       }


        return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,'application_id'=>$condition,'released'=>$released,'verificationStatus'=>$verificationStatus,
        ]);
     }
   }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
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
    public function actionUpdate($id) {
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
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Check application status 
     */
/*
    function checkApplicationStatus($applicationId) {
        //
        $models = ApplicantAttachment::find()->where(['application_id' => $applicationId])->all();
        if (count($models) > 0) {
            $invalid = $valid = $waiting = $empty = 0;
            foreach ($models as $model) {
                if ($model->verification_status == 1) {
                    $valid+=$model->verification_status;
                } else if ($model->verification_status == 2) {
                    $invalid+=$model->verification_status;
                } else if ($model->verification_status == 3) {
                    $waiting+=$model->verification_status;
                } else {
                    $empty+=1;
                }
            }      
           //$this->updateApplicationStatus($applicationId,$valid,$invalid,$empty,$waiting);
        $modelApplication=Application::findone($applicationId);
        $status=0;
        if ($empty == 0 && $valid > 0 && $invalid == 0&&$waiting==0) {
           //complete
           $status = 1;
        } else if ($invalid > 0) {
            //Incomplete
           $status = 2;
        } elseif ($invalid == 0 && $waiting > 0) {
            //Waiting
           $status = 3;
        }
        $modelApplication->verification_status = $status;
        $modelApplication->save();
      }
     // return $this->redirect(['view','id' => $applicationId,'action' => 'view']);
        return $this->redirect(['view','id' => $applicationId]);
    }
*/

//below tele in use
	function checkApplicationStatus($verification_framework_id,$applicationId) {
        //
        $models = VerificationFrameworkItem::find()->where(['verification_framework_id' => $verification_framework_id])->all();
        if (count($models) > 0) {
            $invalid = $valid = $waiting = $empty = $pending = $incomplete = 0;			
            foreach ($models as $model) {
				$attachment_definition_id=$model->attachment_definition_id;
				$modelsAttachment = ApplicantAttachment::find()->where(['application_id' => $applicationId,'attachment_definition_id' => $attachment_definition_id])->one();
				if(count($modelsAttachment) >0){
				if ($modelsAttachment->verification_status == 0) {
					//check for pending
                $pending=1;					
                }else if ($modelsAttachment->verification_status == 1) {
					//check for valid
                    $valid+=$modelsAttachment->verification_status;
                } else if ($modelsAttachment->verification_status == 2) {
					//check for invalid
                    $invalid+=$modelsAttachment->verification_status;
                } else if ($modelsAttachment->verification_status == 3) {
					//check for waiting
                    $waiting+=$modelsAttachment->verification_status;
                } else if ($modelsAttachment->verification_status == 4) {
					//check for incomplete
                    $incomplete+=$modelsAttachment->verification_status;
                }else {
                    $empty+=1;
                }				
            }
			}			
           //$this->updateApplicationStatus($applicationId,$valid,$invalid,$empty,$waiting);
        $modelApplication=Application::findone($applicationId);
        $status=0;
		if($pending > 0){
			//pending
			$status = 5;
		}if ($valid > 0 && $invalid == 0 && $waiting==0 && $pending==0 && $incomplete==0) {
           //complete
          $modelApplicationDetailsComplete=Application::findone(['application_id'=>$applicationId]);
           $applicantCategoryValue=$modelApplicationDetailsComplete->applicant_category_id;
           $applicantIDValue1=$modelApplicationDetailsComplete->applicant_id;
           $systemStatus_custom_criteria=\backend\modules\application\models\VerificationFramework::getGeneralSystemStatus($applicationId,$applicantIDValue1,$verification_framework_id,$applicantCategoryValue);
           if($systemStatus_custom_criteria==0){
            $status = 4;   
           }else{
            $status = 1; 
           
            //copy the criteria passed
    $resultsCopyCriteria=\backend\modules\application\models\VerificationCustomCriteria::getActiveCustomerCriteria($verification_framework_id,$applicantCategoryValue); 
                                 if(count($resultsCopyCriteria) >0){
				 foreach($resultsCopyCriteria AS $values){
                   $verification_custom_criteria_id=$values->verification_custom_criteria_id;$verification_framework_id=$values->verification_framework_id;$application_id=$applicationId;$criteria_name=$values->criteria_name;$applicant_source_table=$values->applicant_source_table; $applicant_souce_column=$values->applicant_souce_column; $applicant_source_value=$values->applicant_source_value;$operator=$values->operator;$level=$values->level;$created_by=$values->created_by;$created_at=$values->created_at;$is_active=$values->is_active;$last_updated_at=$values->last_updated_at;$last_updated_by=$values->last_updated_by;
            $resultsExist=\backend\modules\application\models\VerificationCustomCriteriaPassed::checkExist($verification_custom_criteria_id,$application_id);
            if($resultsExist==0){
            \backend\modules\application\models\VerificationCustomCriteriaPassed::insertPassedCriteria($verification_custom_criteria_id,$verification_framework_id,$application_id,$criteria_name,$applicant_source_table,$applicant_souce_column,$applicant_source_value,$operator,$created_by,$created_at,$level,$is_active,$last_updated_at,$last_updated_by);
            }
                                 }}
            //end
           //copy the attachments passed
    $resultsCopyAttachments=\backend\modules\application\models\VerificationFrameworkItem::getVerificationAttachmentsSet($verification_framework_id,$applicantCategoryValue); 
                                 if(count($resultsCopyAttachments) >0){
				 foreach($resultsCopyAttachments AS $valuesAttachments){
                   $verification_framework_item_id=$valuesAttachments->verification_framework_item_id;$verification_framework_id=$valuesAttachments->verification_framework_id;$application_id=$applicationId;$attachment_definition_id=$valuesAttachments->attachment_definition_id;$attachment_desc=$valuesAttachments->attachment_desc; $verification_prompt=$valuesAttachments->verification_prompt;$created_by=$valuesAttachments->created_by;$created_at=$valuesAttachments->created_at;$is_active=$valuesAttachments->is_active;$last_updated_at=$valuesAttachments->last_updated_at;$last_updated_by=$valuesAttachments->last_updated_by;$category=$valuesAttachments->category;
            $resultsExistFrameworkExist=\backend\modules\application\models\VerificationFrameworkItemPassed::checkExist($verification_framework_item_id,$application_id);
            if($resultsExistFrameworkExist==0){
                $attachmentVerifcItems=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($attachment_definition_id,$application_id);
                if($attachmentVerifcItems->verification_status > 0){
            \backend\modules\application\models\VerificationFrameworkItemPassed::insertPassedAttachments($verification_framework_item_id,$verification_framework_id,$application_id,$attachment_definition_id,$attachment_desc,$verification_prompt,$created_at,$created_by,$category,$is_active,$last_updated_at,$last_updated_by);
                }
            }
                                 }}
            //end
  
           }
           //$status = 1;
        } else if ($pending==0 && $invalid > 0) {
            //invalid
           $status = 4;
        } elseif ($pending==0 && $invalid == 0 && $waiting== 0 && $incomplete > 0 && $valid > 0) {
            //Incomplete
           $status = 2;
        }elseif ($pending==0 && $invalid == 0 && $waiting > 0 && ($incomplete > 0  || $incomplete == 0) && $valid > 0) {
            //waiting
           $status = 3;
        }
        $modelApplication->verification_status = $status;
        $modelApplication->save();
      }
     // return $this->redirect(['view','id' => $applicationId,'action' => 'view']);
        return $this->redirect(['view','id' => $applicationId]);
    
	}



     /*
 * Update final status of the application
 */
 function updateApplicationStatus($applicationId,$valid,$invalid,$empty,$waiting){
        $model=Application::findone($applicationId);
        $status=0;
        if ($empty == 0 && $valid > 0 && $invalid == 0&&$waiting==0) {
           //complete
           $status = 1;
        } else if ($invalid > 0) {
            //Incomplete
           $status = 2;
        } elseif ($invalid == 0 && $waiting > 0) {
            //Waiting
           $status = 3;
        }
        $model->verification_status = $status;
        $model->save();     
    }

   public function actionReverseApplication($id)
    {
        $model = $this->findModel($id);
        $application_form_number=$model->application_form_number;
        $application_id=$id;
        $model->loan_application_form_status  = 0;
        $model->application_form_number = null;
        $model->save();
       //here auditing purpose
        $comments="Taking the control back to the Applicant";
        $reversed_by = Yii::$app->user->identity->user_id;
        $reversed_at = date("Y-m-d H:i:s");
        \backend\modules\application\models\ApplicationReverse::insertApplicationReverseHistory($application_id,$application_form_number,$comments,$reversed_by,$revers_at);
        //end auditing purpose
        $sms="<p>You have successfully reversed applicant's application. Thanks!!!</p>";
        Yii::$app->getSession()->setFlash('success', $sms);
        return $this->redirect(['view','id' => $model->application_id,'action' => 'view']);
    }

    public function actionUnverifiedApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$verification_status);
        return $this->render('unverified_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

public function actionSubmittedApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 0;
        $dataProvider = $searchModel->searchAllSubmitedApplications(Yii::$app->request->queryParams);
        return $this->render('submitted_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }


    public function actionPendingApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 5;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $verification_status);
        return $this->render('pending_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }



public function actionIncompletedApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $verification_status);
        return $this->render('incompleted_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
public function actionInvalidApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 4;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $verification_status);
        return $this->render('invalid_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }




    public function actionCompleteApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $verification_status);
        return $this->render('complete_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitingApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $verification_status);
        return $this->render('waiting_applications', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssignVerification() {
        $model = new Application();

        if (isset($_POST['Application'])) {
            die('On progresssss');
        }

        return $this->render('assign_verification', [
                    'model' => $model,
        ]);
    }

      public function actionPreviewApplicationForm($id)
    {
         $model = Application::find()->where("applicant_id = {$id}")->one();
           if($model->applicant_category_id == 1 || $model->applicant_category_id == 3 || $model->applicant_category_id == 4){
                 $view = '_signed_application_form';

            }
         else{
                  $view = '_postgraduate_signed_application_form.php';
             }
          return $this->render($view, [
                'model' => $model,
            ]);  
     }

public function actionIndexVerificationAssigned()
    {
       $this->layout="default_main";
        $searchModelApplication = new ApplicationSearch();
        $dataProvider = $searchModelApplication->searchVerificationAssigned(Yii::$app->request->queryParams);

        return $this->render('assigned_applications', [
            'searchModel' => $searchModelApplication,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionReverseapplicationAssigned()
    {
                   $model = new Application();
                   $selection1=Yii::$app->request->post();
                   $selection=(array)Yii::$app->request->post('selection');//typecasting
                   if(count($selection) > 0){                 
		   foreach($selection as $applicationID){
                   $application_id=$applicationID;   
                   $applicationreversed=\backend\modules\application\models\Application::findOne(['application_id'=>$application_id]);
                   $other=$applicationreversed->assignee;
                   $applicationreversed->assignee=NULL;
                   $applicationreversed->assigned_at=NULL;
                   $applicationreversed->assigned_by =NULL;
                   $applicationreversed->save();
                   $activity="Reversing Assigned applications";
                   $done_by=Yii::$app->user->identity->user_id;
                   $done_at=date("Y-m-d H:i:s");
                   $comment='';
                   \backend\modules\application\models\VerificationActivitiesHistory::insertVerificationActivityHistory($application_id,$activity,$done_by,$done_at,$other,$comment);
		   }
                   $sms="<p>You have successfully reversed application!!!</p>";
                   Yii::$app->getSession()->setFlash('success', $sms);
                   return $this->redirect(['index-verification-assigned']);
                   
                  }else if(count($selection) <= 0 && $selection1['application']['application_id']=='' && Yii::$app->request->post()){
                   $sms="<p>No selection done!!!</p>";
                   Yii::$app->getSession()->setFlash('danger', $sms);    
                   return $this->redirect(['index-verification-assigned']);    
                   }
                  return $this->redirect(['index-verification-assigned']);
    }

public function actionFinalSubmitform($frameworkID,$id) {
            $model = new Application();    
            //$vreificationFrameworkResults = Application::findOne(['application_id'=>$id]);
             //$vreificationFrameworkResults->verification_status=4;
             //$vreificationFrameworkResults->save();
			 if($frameworkID !=0 && $id !=''){
			 $this->checkApplicationStatus($frameworkID,$id);
			 }
            return $this->redirect(['unverified-applications']);

    }




public function actionCompleteApplicationsReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = 1;
        $dataProvider = $searchModel->searchVerificationReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('complete_applications_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIncompleteApplicationverifiedReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = 2;
        $dataProvider = $searchModel->searchVerificationIncompleteReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('incomplete_applications_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

public function actionInvalidApplicationverifiedReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = 4;
        $dataProvider = $searchModel->searchVerificationIncompleteReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('invalid_applications_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionWaitingApplicationverifiedReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = 3;
        $dataProvider = $searchModel->searchVerificationIncompleteReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('waiting_applications_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUnverifiedApplicationverifiedReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = 0;
        $dataProvider = $searchModel->searchVerificationIncompleteReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('unverified_applications_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAllverifiedApplicationverifiedReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = [1,2,3,4,5];
        $dataProvider = $searchModel->searchVerificationIncompleteReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('allverified_applications_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionVerificationOfficerassignmentReport() {
        $searchModel = new ApplicationSearch();
        $verification_status = [0,1,2,3,4,5];
        $dataProvider = $searchModel->searchVerificationAssignmentReport(Yii::$app->request->queryParams, $verification_status);
        return $this->render('verification_assignment_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

public function actionReleaseApplications() {
        $searchModel = new ApplicationSearch();
        //$verification_status = 1;
        $dataProvider = $searchModel->searchVerificationcompleteToRelease(Yii::$app->request->queryParams);
        return $this->render('release_complete_verification', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionReleaseVerificationComplete()
    {
                   $model = new Application();
                   $selection1=Yii::$app->request->post();
                   $selection=(array)Yii::$app->request->post('selection');//typecasting
                   if(count($selection) > 0){                 
		   foreach($selection as $applicationID){
                   $application_id=$applicationID;   
                   $applicationreversed=\backend\modules\application\models\Application::findOne(['application_id'=>$application_id]);
                   $other=$applicationreversed->assignee;
                   $applicationreversed->released =1;
                   $applicationreversed->save();
                   $activity="Release Complete Verification";
                   $done_by=Yii::$app->user->identity->user_id;
                   $done_at=date("Y-m-d H:i:s");
                   $comment='';
                   \backend\modules\application\models\VerificationActivitiesHistory::insertVerificationActivityHistory($application_id,$activity,$done_by,$done_at,$other,$comment);
		   }
                   $sms="<p>You have successfully released application!!!</p>";
                   Yii::$app->getSession()->setFlash('success', $sms);
                   return $this->redirect(['release-applications']);
                   
                  }else if(count($selection) <= 0 && $selection1['application']['application_id']=='' && Yii::$app->request->post()){
                   $sms="<p>No selection done!!!</p>";
                   Yii::$app->getSession()->setFlash('danger', $sms);    
                   return $this->redirect(['release-applications']);    
                   }
                  return $this->redirect(['release-applications']);
    }
    public function actionReleaseVerificationCompletebulk()
    {
                   $model = new Application();
                   $applicationsV=\backend\modules\application\models\Application::find()
                           ->where(['application.verification_status'=>1,'application.loan_application_form_status'=>3,'application.is_migration_data'=>0])
                           ->andWhere(['or',
                   ['application.released'=>NULL],
                   ['application.released'=>''],
                                    ])
                           ->all();
		   foreach($applicationsV as $applicationID){
                   $application_id=$applicationID->application_id;   
                   $applicationreversed=\backend\modules\application\models\Application::findOne(['application_id'=>$application_id]);
                   $other=$applicationreversed->assignee;
                   $applicationreversed->released =1;
                   $applicationreversed->save();
                   $activity="Release Complete Verification";
                   $done_by=Yii::$app->user->identity->user_id;
                   $done_at=date("Y-m-d H:i:s");
                   $comment='';
                   \backend\modules\application\models\VerificationActivitiesHistory::insertVerificationActivityHistory($application_id,$activity,$done_by,$done_at,$other,$comment);
		   }
                   $sms="<p>You have successfully released application!!!</p>";
                   Yii::$app->getSession()->setFlash('success', $sms);
                   return $this->redirect(['release-applications']);
    }

public function actionVerificationPrintReportpdf($searches,$verification_status,$criteriaSearchV) { 
      set_time_limit(0);
     if($verification_status==7){
            //7 for all verified
          $verification_status= [1,2,3,4,5];
          $assignee="";
        }else if($verification_status==0){
            //0 for unverified
          $verification_status=[0];
          $assignee="";
        }else if($verification_status==1){
            //1 for complete
           $verification_status=[1]; 
           $assignee="";
        }else if($verification_status==2){
            //2 for Incomplete
           $verification_status=[2];
           $assignee="";
        }else if($verification_status==3){
            //3 waiting
            $verification_status=[3];
            $assignee="";
        }else if($verification_status==4){
            //4 Invalid
            $verification_status=[4];
            $assignee="";
        }else if($verification_status==5){
            //5 Pending
            $verification_status=[5];
            $assignee="";
        }else if($verification_status==8){
            //8 for all Assigned Applications
          $verification_status= [0,1,2,3,4,5];
          $assignee =" AND application.assignee > 0";
        }
    $htmlContent = $this->renderPartial('printVerificationReport',['searches' =>$searches,'verification_status'=>$verification_status,'assignee'=>$assignee,'criteriaSearchV'=>$criteriaSearchV]);
    $reportNumber="VER".strtotime(date("Y-m-d H:i:s"));
$generated_by=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;
 $mpdf = new mPDF(); 
 $mpdf->SetDefaultFontSize(8.0);
 $mpdf->useDefaultCSS2 = true; 
 $mpdf->SetTitle('Report');
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetFooter($reportNumber.'  |Page #{PAGENO} out of {nbpg} |Generated @ {DATE d/m/Y H:i:s}');
 $mpdf->WriteHTML($htmlContent);
return $mpdf->Output();
    exit;
}


public function actionVerificationPrintReportexcel($searches,$verification_status,$criteriaSearchV) { 
        if($verification_status==7){
            //7 for all verified
          $verification_status= [1,2,3,4,5];
          $assignee="";
        }else if($verification_status==0){
            //0 for unverified
          $verification_status=[0];
          $assignee="";
        }else if($verification_status==1){
            //1 for complete
           $verification_status=[1]; 
           $assignee="";
        }else if($verification_status==2){
            //2 for Incomplete
           $verification_status=[2];
           $assignee="";
        }else if($verification_status==3){
            //3 waiting
            $verification_status=[3];
            $assignee="";
        }else if($verification_status==4){
            //4 Invalid
            $verification_status=[4];
            $assignee="";
        }else if($verification_status==5){
            //5 Pending
            $verification_status=[5];
            $assignee="";
        }else if($verification_status==8){
            //8 for all Assigned Applications
          $verification_status= [0,1,2,3,4,5];
          $assignee =" AND application.assignee > 0";
        }
    
         $setHeader= 'Verification Report.Filtering Criteria:'.$criteriaSearchV;
        
    $objPHPExcelOutput = new \PHPExcel();
    $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    $objPHPExcelOutput->setActiveSheetIndex(0);
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', $setHeader);
    $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:J1', $setHeader);
    
    $rowCount = 2;    
    $customTitle = ['SNo', 'f4indexno', 'FirstName', 'MiddleName', 'LastName', 'Sex','Category','Status','Date Verified','Officer'];
    $attachmentHeader = ['Attachment', 'Comment'];
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $customTitle[8]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $customTitle[9]);
                    $objPHPExcelOutput->getActiveSheet()->getStyle('A' . $rowCount.':'.'J' . $rowCount)->getFont()->setBold(true);
       $QUERY_BATCH_SIZE = 1000;
       $offset = 0;
       $done = false;
       $startTime = time();
       $rowCountF = 2;
       $rowCount3=0;
       $i=0;
       $results= \backend\modules\application\models\Application::getVerificationReport($searches,$verification_status,$assignee,$offset,$limit);                        
                        foreach($results as $values){                            
                             $rowCountF++; 
                             if($rowCount3 > 0){
                            $rowCount=$rowCount3 + 1;
                            $rowCountF=$rowCount;
                             }else{
                            $rowCount=$rowCountF + $rowCount3;
                             }
                            $i++;
                             
                             
                             
                             
                             //++$i;
            //HERE START EXCEL
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $values->applicant->f4indexno);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $values->applicant->user->firstname);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $values->applicant->user->middlename);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $values->applicant->user->surname);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $values->applicant->sex);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $values->applicantCategory->applicant_category);
            $rowCount2=0;
            if($values->verification_status==0){$status="Unverified";}else if($values->verification_status==1){$status="Complete";}else if($values->verification_status==2){$status="Incomplete";}else if($values->verification_status==3){$status="Waiting";}else if($values->verification_status==4){$status="Invalid";}else if($values->verification_status==5){$status="Pending";}
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $status);
            if(!empty($values->date_verified)){
            $dVerified=date("Y-m-d",strtotime($values->date_verified));
            }else{ 
             $dVerified=$values->date_verified;
            }
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $dVerified);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $values->assignee0->firstname." ".$values->assignee0->middlename." ".$values->assignee0->surname);
            
            $verificationComments = \frontend\modules\application\models\ApplicantAttachment::find()                
                ->where(['application_id'=>$values->application_id])
                ->andWhere(['not',['comment'=>'']])
                ->andWhere(['not',['comment'=>NULL]])->all();
                
                if(count($verificationComments) > 0){                
                $rowCount2=$rowCount + 1;
                $objPHPExcelOutput->getActiveSheet()->mergeCells('A'.$rowCount2.':'.'F'.$rowCount2);
                $objPHPExcelOutput->getActiveSheet()->mergeCells('I'.$rowCount2.':'.'J'.$rowCount2);   
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount2, 'Attachment');
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount2, 'Comment');
            $objPHPExcelOutput->getActiveSheet()->getStyle('G' . $rowCount2.':'.'H' . $rowCount2)->getFont()->setBold(true);
                }
                 
                 
            foreach ($verificationComments as $modelApplicantAttachment) { 
                ++$rowCount2;
                if($modelApplicantAttachment->comment > 0){     
                $objPHPExcelOutput->getActiveSheet()->mergeCells('A'.$rowCount2.':'.'F'.$rowCount2);
                $objPHPExcelOutput->getActiveSheet()->mergeCells('I'.$rowCount2.':'.'J'.$rowCount2);   
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount2, $modelApplicantAttachment->attachmentDefinition->attachment_desc);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount2, \backend\modules\application\models\VerificationComment::getVerificationComment($modelApplicantAttachment->comment));
            //$objPHPExcelOutput->getActiveSheet()->mergeCells('A'.$rowCount.':'.'E'.$rowCount);            
                }
                
            }           
            //END FOR EXCEL
            if($rowCount2 > 0){
                $rowCount3=$rowCount2;                
            }else{
                $rowCount3=0;
            }
            //$i=0;
            //$rowCount=0;
        }
        $highestRow=$rowCount + 1;
        //$highestRow=6;
        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:J' .$highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Verification Report.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
                    
}


}
