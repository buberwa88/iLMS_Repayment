<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\DisbursementTaskAssignment;
use backend\modules\disbursement\models\DisbursementTaskAssignmentSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * DisbursementTaskAssignmentController implements the CRUD actions for DisbursementTaskAssignment model.
 */
class DisbursementTaskAssignmentController extends Controller
{
    /**
     * @inheritdoc
     */
     public $layout = "main_private";
    public function behaviors()
    {
         $this->layout="default_main"; 
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
     * Lists all DisbursementTaskAssignment models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        
        $searchModel = new DisbursementTaskAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'disbursement_schedule_id'=>$id
        ]);
    }

    /**
     * Displays a single DisbursementTaskAssignment model.
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
     * Creates a new DisbursementTaskAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new DisbursementTaskAssignment();

        if ($model->load(Yii::$app->request->post())) {
                        $modelcheck=  DisbursementTaskAssignment::find()->where(['disbursement_task_id'=>$model->disbursement_task_id,'disbursement_structure_id'=>$model->disbursement_structure_id,'disbursement_schedule_id'=>$model->disbursement_schedule_id])->asArray()->all();
                         //check duplicate
                        if(count($modelcheck)==0){
                           Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Created!'
                        );
                        $model->save();
                        }
                        else{
                   Yii::$app->getSession()->setFlash(
                                'danger', 'Sorry! Already exist!'
                        );            
                        }
                            //end
            return $this->redirect(['index', 'id' => $model->disbursement_schedule_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'disbursement_schedule_id'=>$id
            ]);
        }
    }

    /**
     * Updates an existing DisbursementTaskAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
                        $modelcheck=  DisbursementTaskAssignment::find()->where(['disbursement_task_id'=>$model->disbursement_task_id,'disbursement_structure_id'=>$model->disbursement_structure_id,'disbursement_schedule_id'=>$model->disbursement_schedule_id])->asArray()->all();
                         //check duplicate
                        if(count($modelcheck)==1){
                           Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Updated!'
                        );
                        $model->save();
                        }
                        else{
                   Yii::$app->getSession()->setFlash(
                                'danger', 'Sorry! Already exist!'
                        );            
                        }
            return $this->redirect(['index', 'id' => $model->disbursement_schedule_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DisbursementTaskAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$model1=$this->findModel($id);
          $model1->delete();
        return $this->redirect(['index', 'id' => $model->disbursement_schedule_id]);
    }

    /**
     * Finds the DisbursementTaskAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DisbursementTaskAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DisbursementTaskAssignment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
