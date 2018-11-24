<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationPlanStudent;
use backend\modules\allocation\models\AllocationPlanStudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AllocationPlanStudentController implements the CRUD actions for AllocationPlanStudent model.
 */
class AllocationPlanStudentController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all AllocationPlanStudent models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AllocationPlanStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationPlanStudent model.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @return mixed
     */
    public function actionView($allocation_plan_id, $application_id) {
        return $this->render('view', [
                    'model' => $this->findModel($allocation_plan_id, $application_id),
        ]);
    }

    /**
     * Creates a new AllocationPlanStudent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AllocationPlanStudent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'application_id' => $model->application_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AllocationPlanStudent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @return mixed
     */
    public function actionUpdate($allocation_plan_id, $application_id) {
        $model = $this->findModel($allocation_plan_id, $application_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'application_id' => $model->application_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationPlanStudent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @return mixed
     */
    public function actionDelete($allocation_plan_id, $application_id) {
        $this->findModel($allocation_plan_id, $application_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AllocationPlanStudent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @return AllocationPlanStudent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($allocation_plan_id, $application_id) {
        if (($model = AllocationPlanStudent::findOne(['allocation_plan_id' => $allocation_plan_id, 'application_id' => $application_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   

}
