<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationPlanStudentLoanItem;
use backend\modules\allocation\models\AllocationPlanStudentLoanItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AllocationPlanStudentLoanItemController implements the CRUD actions for AllocationPlanStudentLoanItem model.
 */
class AllocationPlanStudentLoanItemController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all AllocationPlanStudentLoanItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationPlanStudentLoanItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationPlanStudentLoanItem model.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @param integer $loan_item_id
     * @return mixed
     */
    public function actionView($allocation_plan_id, $application_id, $loan_item_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($allocation_plan_id, $application_id, $loan_item_id),
        ]);
    }

    /**
     * Creates a new AllocationPlanStudentLoanItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllocationPlanStudentLoanItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'application_id' => $model->application_id, 'loan_item_id' => $model->loan_item_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AllocationPlanStudentLoanItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @param integer $loan_item_id
     * @return mixed
     */
    public function actionUpdate($allocation_plan_id, $application_id, $loan_item_id)
    {
        $model = $this->findModel($allocation_plan_id, $application_id, $loan_item_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'application_id' => $model->application_id, 'loan_item_id' => $model->loan_item_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationPlanStudentLoanItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @param integer $loan_item_id
     * @return mixed
     */
    public function actionDelete($allocation_plan_id, $application_id, $loan_item_id)
    {
        $this->findModel($allocation_plan_id, $application_id, $loan_item_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AllocationPlanStudentLoanItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $allocation_plan_id
     * @param integer $application_id
     * @param integer $loan_item_id
     * @return AllocationPlanStudentLoanItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($allocation_plan_id, $application_id, $loan_item_id)
    {
        if (($model = AllocationPlanStudentLoanItem::findOne(['allocation_plan_id' => $allocation_plan_id, 'application_id' => $application_id, 'loan_item_id' => $loan_item_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
