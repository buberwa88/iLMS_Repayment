<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\TreasuryPaymentDetail;
use frontend\modules\repayment\models\TreasuryPaymentDetailSearch;
use frontend\modules\repayment\models\LoanRepaymentDetailSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TreasuryPaymentDetailController implements the CRUD actions for TreasuryPaymentDetail model.
 */
class TreasuryPaymentDetailController extends Controller
{
    /**
     * @inheritdoc
     */
	 public $layout="main_private_treasury";
	 
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
     * Lists all TreasuryPaymentDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TreasuryPaymentDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TreasuryPaymentDetail model.
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
     * Creates a new TreasuryPaymentDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TreasuryPaymentDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->treasury_payment_detail_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TreasuryPaymentDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->treasury_payment_detail_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TreasuryPaymentDetail model.
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
     * Finds the TreasuryPaymentDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TreasuryPaymentDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TreasuryPaymentDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionEmployersBills($id)
    {
	   $this->layout="default_main";
        $searchModel = new TreasuryPaymentDetailSearch();
        $dataProvider = $searchModel->searchEmployersBills(Yii::$app->request->queryParams,$id);

        return $this->render('employersBills', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionBillsPayments()
    {

        $searchModel = new LoanRepaymentDetailSearch();
        $dataProvider=$searchModel->searchTreasuryAllPayments(Yii::$app->request->queryParams);
        
        return $this->render('billsPayments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
