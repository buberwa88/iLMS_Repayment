<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\LoanRepaymentSearch;
use backend\modules\repayment\models\LoanRepayment;
use backend\modules\repayment\models\LoanRepaymentDetail;
use backend\modules\repayment\models\LoanRepaymentDetailSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\repayment\models\EmployerSearch;

/**
 * LoanRepaymentDetailController implements the CRUD actions for LoanRepaymentDetail model.
 */
class LoanRepaymentDetailController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout="main_private";
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
     * Lists all LoanRepaymentDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoanRepaymentDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionBillsPayments()
    {
        //$searchModel = new LoanRepaymentDetailSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel = new LoanRepaymentSearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams);
        
        return $this->render('billsPayments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanRepaymentDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model1 = new LoanRepaymentSearch();
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $loan_repayment_id=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);        
        return $this->render('view', [
            'model' => $model1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelBatch' => $model2,
            'loan_repayment_id' => $loan_repayment_id,
        ]);
    }

    /**
     * Creates a new LoanRepaymentDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LoanRepaymentDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_repayment_detail_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LoanRepaymentDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_repayment_detail_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanRepaymentDetail model.
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
     * Finds the LoanRepaymentDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanRepaymentDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanRepaymentDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionViewLoaneeUnderPayment($id)
    {
    	$this->layout="default_main";
        $model1 = new LoanRepaymentSearch();
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $loan_repayment_id=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);        
        return $this->render('viewLoaneeUnderPayment', [
            'model' => $model1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelBatch' => $model2,
            'loan_repayment_id' => $loan_repayment_id,
        ]);
    }
	public function actionPaymentsunderemployersknown()
    {
    	$this->layout="default_main";
        $model1 = new LoanRepaymentSearch();
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $dataProvider = $searchModel->searchAllEmployerRepaymentsknown(Yii::$app->request->queryParams);        
        return $this->render('paymentsunderemployersknown', [
            'model' => $model1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelBatch' => $model2,
        ]);
    }
	public function actionPaymentsunderemployersunknown()
    {
    	$this->layout="default_main";
        $model1 = new LoanRepaymentSearch();
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $dataProvider = $searchModel->searchAllEmployerRepaymentsunknown(Yii::$app->request->queryParams);        
        return $this->render('paymentsunderemployersunknown', [
            'model' => $model1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelBatch' => $model2,
        ]);
    }
}
