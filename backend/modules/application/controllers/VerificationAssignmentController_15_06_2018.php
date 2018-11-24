<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\VerificationAssignment;
use backend\modules\application\models\VerificationAssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        return $this->render('index', [
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
        $model = new VerificationAssignment();
        $model->assigned_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $applications = \backend\modules\application\models\VerificationAssignment::getUnverifiedApplication($model->study_level,$model->total_applications);
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
    
}
