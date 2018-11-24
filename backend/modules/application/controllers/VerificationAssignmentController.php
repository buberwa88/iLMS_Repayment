<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\VerificationAssignment;
use backend\modules\application\models\VerificationAssignmentSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\application\models\Application;
use backend\modules\application\models\ApplicationSearch;


/**
 * VerificationAssignmentController implements the CRUD actions for VerificationAssignment model.
 */
class VerificationAssignmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout = "main_private";
        //$this->layout = "main_private_verification";
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
     * Lists all VerificationAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VerificationAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       $searchModelApplication = new ApplicationSearch();
       $dataProviderApplication = $searchModelApplication->searchVerificationAssigned(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelApplication'=>$searchModelApplication,
            'dataProviderApplication'=>$dataProviderApplication,
        ]);
    }
    public function actionAssignApplications()
    {
       //$this->layout="default_main";
        $searchModel = new VerificationAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('assignApplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VerificationAssignment model.
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
     * Creates a new VerificationAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       //$this->layout="default_main";
        $model = new VerificationAssignment();
        $model->scenario='create_assignment';
        $model->assigned_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $applicant_category_id=$model->study_level;
            if($applicant_category_id > 0){
            $category=" AND applicant_category_id='" . $applicant_category_id . "'";
            }else{
             $category="";   
            }
            $applications = \backend\modules\application\models\VerificationAssignment::getUnverifiedApplication($category,$model->total_applications);
                $i=0;
                foreach ($applications as $results) {		
			    $applicationID=$results->application_id; 
                            $resultApplicationID=\backend\modules\application\models\Application::findOne(['application_id'=>$applicationID]);
                            $resultApplicationID->assignee=$model->assignee;
                            $resultApplicationID->assigned_at=$model->created_at;
                            $resultApplicationID->assigned_by =$model->assigned_by;
                            $resultApplicationID->save();
                 $i++;
                        }
                        VerificationAssignment::saveNewValueTotal($model->verification_assignment_id,$i);
                        $sms="<p>Applications successfully assigned</p>";
                        Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VerificationAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->verification_assignment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VerificationAssignment model.
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
     * Finds the VerificationAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VerificationAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VerificationAssignment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionReverseApplicationbulk()
    {
       //$this->layout="default_main";
        $model = new VerificationAssignment();
        $model->scenario='reverse_assignment';
        $model->assigned_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $applicant_category_id=$model->study_level;
            if($applicant_category_id > 0){
            $category=" AND applicant_category_id='" . $applicant_category_id . "'";
            }else{
             $category="";   
            }
            $applications = \backend\modules\application\models\VerificationAssignment::getReverseApplicationsBulk($category,$model->total_applications,$model->assignee,$model->application_status);
            
                //$i=0;
                foreach ($applications as $results) {		
			    $applicationID=$results->application_id; 
                            $resultApplicationID=\backend\modules\application\models\Application::findOne(['application_id'=>$applicationID]);
                            $other=$resultApplicationID->assignee;
                            $resultApplicationID->assignee=NULL;
                            $resultApplicationID->assigned_at=NULL;
                            $resultApplicationID->assigned_by =NULL;
                            $resultApplicationID->save();
                            $activity="Reversing Assigned applications";
                            $done_by=Yii::$app->user->identity->user_id;
                            $done_at=date("Y-m-d H:i:s");
                            $comment='';
                 //$i++;
                 \backend\modules\application\models\VerificationActivitiesHistory::insertVerificationActivityHistory($applicationID,$activity,$done_by,$done_at,$other,$comment);
                        }
                        //VerificationAssignment::saveNewValueTotal($model->verification_assignment_id,$i);
                        $sms="<p>Applications successfully reversed</p>";
                        Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('reverseApplicationbulk', [
                'model' => $model,
            ]);
        }
    }

public function actionIndexVerificationAssigned()
    {
        //$this->layout = "main_private_verification";
        $model = new Application();
        //$this->layout="default_main";
        $searchModelApplication = new ApplicationSearch();
        $dataProvider = $searchModelApplication->searchVerificationAssigned(Yii::$app->request->queryParams);

        return $this->render('assigned_applications', [
            'searchModel' => $searchModelApplication,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionReverseapplicationAssigned()
    {
                  //$this->layout = "main_private_verification";
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
                   return $this->redirect(['index']);
                   }else if(count($selection) <= 0 && $selection1['application']['application_id']=='' && Yii::$app->request->post()){
                   $sms="<p>No selection done!!!</p>";
                   Yii::$app->getSession()->setFlash('danger', $sms);
                   return $this->redirect(['index']);
                   }                   
                   return $this->redirect(['index']);    
                   
    }

    
}
