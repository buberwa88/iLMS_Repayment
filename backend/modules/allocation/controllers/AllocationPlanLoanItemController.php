<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationPlanLoanItem;
use backend\modules\allocation\models\AllocationPlanLoanItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AllocationPlanLoanItemController implements the CRUD actions for AllocationPlanLoanItem model.
 */
class AllocationPlanLoanItemController extends Controller
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
     * Lists all AllocationPlanLoanItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationPlanLoanItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationPlanLoanItem model.
     * @param integer $allocation_plan_id
     * @param integer $loan_item_id
     * @return mixed
     */
    public function actionView($allocation_plan_id, $loan_item_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($allocation_plan_id, $loan_item_id),
        ]);
    }

    /**
     * Creates a new AllocationPlanLoanItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllocationPlanLoanItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'loan_item_id' => $model->loan_item_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AllocationPlanLoanItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $allocation_plan_id
     * @param integer $loan_item_id
     * @return mixed
     */
    public function actionUpdate($allocation_plan_id, $loan_item_id)
    {
        $model = $this->findModel($allocation_plan_id, $loan_item_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'loan_item_id' => $model->loan_item_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationPlanLoanItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $allocation_plan_id
     * @param integer $loan_item_id
     * @return mixed
     */
    public function actionDelete($allocation_plan_id, $loan_item_id)
    {
        $this->findModel($allocation_plan_id, $loan_item_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AllocationPlanLoanItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $allocation_plan_id
     * @param integer $loan_item_id
     * @return AllocationPlanLoanItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($allocation_plan_id, $loan_item_id)
    {
        if (($model = AllocationPlanLoanItem::findOne(['allocation_plan_id' => $allocation_plan_id, 'loan_item_id' => $loan_item_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
