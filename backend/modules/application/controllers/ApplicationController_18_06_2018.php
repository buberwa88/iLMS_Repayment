<?php

namespace backend\modules\application\controllers;

use Yii;
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
        if (isset($_POST['ApplicantAttachment'])) {
            $posted_data = Yii::$app->request->post();
            $applicant_attachment_id = $posted_data['ApplicantAttachment']['applicant_attachment_id'];
            $verification_status = $posted_data['ApplicantAttachment']['verification_status'];
            $comment = $posted_data['ApplicantAttachment']['comment'];

            $applicant_attachment = ApplicantAttachment::findOne($applicant_attachment_id);

            $applicant_attachment->verification_status = $verification_status;
            $applicant_attachment->comment = $comment;
            $applicant_attachment->save();
            $this->checkApplicationStatus($id);
        }

        $model = $this->findModel($id);

        $searchModel = new ApplicantAttachmentSearch();
        $condition = "application_id={$model->application_id}";
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $condition);
        return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
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


    public function actionIncompleteApplications() {
        $searchModel = new ApplicationSearch();
        $verification_status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $verification_status);
        return $this->render('incomplete_applications', [
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
                   \backend\modules\application\models\VerificationActivitiesHistory::insertVerificationActivityHistory($application_id,$activity,$done_by,$done_at,$other);
		   }
                   $sms="<p>You have successfully reversed application!!!</p>";
                   Yii::$app->getSession()->setFlash('success', $sms);
                   return $this->redirect(['index-verification-assigned']);
                   }else{
                   $sms="<p>No selection done!!!</p>";
                   Yii::$app->getSession()->setFlash('danger', $sms);    
                   return $this->redirect(['index-verification-assigned']);    
                   }
    }

}

