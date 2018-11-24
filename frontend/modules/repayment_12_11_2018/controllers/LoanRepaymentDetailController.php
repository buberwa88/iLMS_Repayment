<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\LoanRepaymentSearch;
use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use frontend\modules\repayment\models\LoanSummaryDetail;
use frontend\modules\repayment\models\LoanRepaymentDetailSearch;
use frontend\modules\repayment\models\LoanSummary;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployerSearch;

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
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);
        
        return $this->render('billsPayments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionBillsPaymentsBenefiaciary()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }

        $searchModel = new LoanRepaymentSearch();
        $batchDetailModel = new LoanRepaymentDetail();
        $BillDetailModel = new LoanSummaryDetail();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $beneficiary=$employerModel->getApplicant($loggedin);
        $applicantID=$beneficiary->applicant_id;
        $dataProvider=$searchModel->searchPaymentsForSpecificBeneficiary(Yii::$app->request->queryParams,$applicantID);
        
        return $this->render('billsPaymentsBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'applicantID' => $applicantID,
            'batchDetailModel'=>$batchDetailModel,
            'BillDetailModel'=>$BillDetailModel,
        ]);
    }
	
	public function actionBillsPaymentsBenefiaciaryView()
    {

        $this->layout="default_main";
        $searchModel = new LoanRepaymentSearch();
        $batchDetailModel = new LoanRepaymentDetail();
        $BillDetailModel = new LoanSummaryDetail();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $beneficiary=$employerModel->getApplicant($loggedin);
        $applicantID=$beneficiary->applicant_id;
        $dataProvider=$searchModel->searchPaymentsForSpecificBeneficiary(Yii::$app->request->queryParams,$applicantID);
        
        return $this->render('billsPaymentsBenefiaciaryView', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'applicantID' => $applicantID,
            'batchDetailModel'=>$batchDetailModel,
            'BillDetailModel'=>$BillDetailModel,
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
	public function actionViewLoaneeinbillPayment($id)
    {
    	$this->layout="default_main";
        $model1 = new LoanRepaymentSearch();
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $loan_repayment_id=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);        
        return $this->render('viewLoaneeinbillPayment', [
            'model' => $model1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelBatch' => $model2,
            'loan_repayment_id' => $loan_repayment_id,
        ]);
    }
	public function actionViewloaneebillConfirmedpayment($id)
    {
    	$this->layout="default_main";
        $model1 = new LoanRepaymentSearch();
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $loan_repayment_id=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);        
        return $this->render('viewloaneebillConfirmedpayment', [
            'model' => $model1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelBatch' => $model2,
            'loan_repayment_id' => $loan_repayment_id,
        ]);
    }
	public function actionUpdateNewPaymentAmount($id)
    {
	 $this->layout="default_main";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['loan-repayment-detail/view-loaneeinbill-payment']);
        } else {
            return $this->render('updateNewPaymentAmount', [
                'model' => $model,
            ]);
        }
    }
	public function actionNewamountinPayment()
    {
	    $this->layout="default_main";
        $searchModel = new LoanRepaymentDetailSearch();
		$ModelLoanRepaymentDetail = new LoanRepaymentDetail();
        $model2 = new LoanRepayment();
		$modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $ModelLoanRepaymentDetail->scenario='adjustAmount';	
        		

		if ($ModelLoanRepaymentDetail->load(Yii::$app->request->post())) {
		
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		$outstandingDebt=str_replace(",","",$ModelLoanRepaymentDetail->outstandingDebt);
		if($ModelLoanRepaymentDetail->amount > $outstandingDebt){
		$sms="Operation Fail,Pay amount must be equal or less than outstanding debt!";
        Yii::$app->getSession()->setFlash('error', $sms);
		return $this->redirect(['update-new-payment-amount','id'=>$ModelLoanRepaymentDetail->loan_repayment_id]);
		}
		if($ModelLoanRepaymentDetail->save()){
        if($employerID >0){

            $loan_repayment_id=$ModelLoanRepaymentDetail->loan_repayment_id;
			$applicantID=$ModelLoanRepaymentDetail->applicant_id;
			$loan_summary_id=$ModelLoanRepaymentDetail->loan_summary_id;
			$amounUpdated=$ModelLoanRepaymentDetail->amount;

			$model2->resetTheOldAmountOnPaymentAdjustmentAccepted($loan_repayment_id,$applicantID);			
			$ModelLoanRepaymentDetail->updateNewAmountOnAdjustmentOfPaymentEmployedBeneficiary($loan_summary_id,$loan_repayment_id,$amounUpdated,$applicantID);			
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id);			
            $model2->updateNewTotaAmountAfterPaymentAdjustment($totalAmount1,$loan_repayment_id);

			
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        }
		$sms="Pay amount adjusted successful!";
        Yii::$app->getSession()->setFlash('success', $sms);
		return $this->redirect(['loan-repayment-detail/view-loaneeinbill-payment','id'=>$loan_repayment_id]);
		}else {
            return $this->render('updateNewPaymentAmount', [
                'model' => $ModelLoanRepaymentDetail,
            ]);
        }
		}else {
            return $this->render('updateNewPaymentAmount', [
                'model' => $ModelLoanRepaymentDetail,
            ]);
        }
    }
}
