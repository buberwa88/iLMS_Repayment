<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\LoanRepaymentSearch;
use frontend\modules\repayment\models\EmployerSearch;
use frontend\modules\repayment\models\LoanSummary;
use frontend\modules\repayment\models\LoanRepaymentDetailSearch;
use frontend\modules\repayment\models\LoanRepaymentDetail;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoanRepaymentController implements the CRUD actions for LoanRepayment model.
 */
class LoanRepaymentController extends Controller
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
     * Lists all LoanRepayment models.
     * @return mixed
     */
    public function actionPayments()
    {
        $searchModel = new LoanRepaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('payments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex()
    {
        $model = new LoanRepayment();
        $modelBill = new LoanSummary();
        $searchModelBills = new LoanRepaymentSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModel = new LoanRepaymentDetailSearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $resultsAfterCheck=$model->checkWaitingConfirmationFromGePG($employerID);
        $forSpecificBatchID=$model->getDataUnderLoanRepaymentId($employerID);
        $loan_repayment_id1=$forSpecificBatchID->loan_repayment_id;
        $loan_repayment_id=$resultsAfterCheck->loan_repayment_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id1);
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
		$dataProviderBills=$searchModelBills->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);
        if($resultsAfterCheck->payment_status !='0'){
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'employerID'=>$employerID,
            'modelBill'=>$modelBill,
			'searchModelBills' => $searchModelBills,
            'dataProviderBills' => $dataProviderBills,
        ]);
        }else{
        return $this->render('confirmed_payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider2,
            'model' => $model,
            'loan_repayment_id'=>$loan_repayment_id,
            'modelBill'=>$modelBill,
            
        ]);    
        }
    }
    public function actionIndexBeneficiary()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $model = new LoanRepayment();
        $modelBill = new LoanSummary();
        //$searchModel = new LoanRepaymentSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModel = new LoanRepaymentDetailSearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $resultsAfterCheck=$model->checkWaitingConfirmationFromGePGLoanee($applicantID);
        $forSpecificBatchID=$model->getDataUnderLoanRepaymentIdLoanee($applicantID);
        $loan_repayment_id1=$forSpecificBatchID->loan_repayment_id;
        $loan_repayment_id=$resultsAfterCheck->loan_repayment_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id1);
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        if($resultsAfterCheck->payment_status !='0'){
        return $this->render('indexBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'applicantID'=>$applicantID,
            'modelBill'=>$modelBill,
        ]);
        }else{
        return $this->render('confirmed_payment_beneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider2,
            'model' => $model,
            'loan_repayment_id'=>$loan_repayment_id,
            'modelBill'=>$modelBill,
            
        ]);    
        }
    }
	/*
    public function actionInitiatePayment()
    {
        $searchModel = new LoanRepaymentDetailSearch();
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $model2->employer_id=$employerID;
        //$model2->repayment_reference_number=$employer2->employer_code;
        $model2->amount=0;
        //$model2->pay_method_id=4;
        $model2->pay_method_id=$model2->getPaymentMethod();
        //generating payment reference number
        //end generating
        
        if($employerID >0){
        // requesting control number from GePG
        if($model2->save()){
          //reference no to send to GePG  
            $ActiveBill=$modelBill->getActiveBill($employerID);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number=$employer2->employer_code."-".$model2->loan_repayment_id;
            $loan_repayment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            $searchModel->insertAllPaymentsofAllLoaneesUnderBill($loan_summary_id,$loan_repayment_id);
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);
            
        }
        //end requesting number
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'employerID'=>$employerID,
            'modelBill'=>$modelBill,
            
        ]);
    }
	*/
	public function actionGenerateBill()
    {
        $searchModel = new LoanRepaymentDetailSearch();
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $model2->employer_id=$employerID;
        //$model2->repayment_reference_number=$employer2->employer_code;
        $model2->amount=0;
        //$model2->pay_method_id=4;
        $model2->pay_method_id=$model2->getPaymentMethod();
        //generating payment reference number
        //end generating
        
        if($employerID >0){
        // requesting control number from GePG
        if($model2->save()){
          //reference no to send to GePG  
            $ActiveBill=$modelBill->getActiveBill($employerID);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number=$employer2->employer_code."-".$model2->loan_repayment_id;
            $loan_repayment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            $searchModel->insertAllPaymentsofAllLoaneesUnderBill($loan_summary_id,$loan_repayment_id);
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);
            
        }
        //end requesting number
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'employerID'=>$employerID,
            'modelBill'=>$modelBill,
            
        ]);
    }
	/*
	public function actionAcceptAdjustedAmountduringPayment()
    {
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
		return $this->redirect(['loan-repayment-detail/view-loanee-under-bill-ready-for-payment','id'=>$loan_repayment_id]);
		}
		}
    }*/
    
    public function actionInitiatePaymentLoanee()
    {
        $this->layout="main_private_beneficiary";
        $searchModel = new LoanRepaymentDetailSearch();
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $model2->applicant_id=$applicantID;
        //$model2->repayment_reference_number=$employer2->employer_code;
        $model2->amount=0;
        $model2->pay_method_id=$model2->getPaymentMethod();
        //$model2->pay_method_id=4;
        //generating payment reference number
        //end generating
        
        if($applicantID >0){
        // requesting control number from GePG
        if($model2->save()){
          //reference no to send to GePG  
            $ActiveBill=$modelBill->getActiveBillLoanee($applicantID);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number="BEN"."-".$model2->loan_repayment_id;
            $loan_repayment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            $searchModel->insertAllPaymentsofAllLoaneesUnderBillSelfEmployedBeneficiary($loan_summary_id,$loan_repayment_id,$applicantID);
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);
            
        }
        //end requesting number
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        }
        return $this->render('indexBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'applicantID'=>$applicantID,
            'modelBill'=>$modelBill,
            
        ]);
    }
    
    public function actionPaymentAdjustmentProcessingLoanee()
    {
        $this->layout="main_private_beneficiary";
        $searchModel = new LoanRepaymentDetail();
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $model2->scenario='paymentAdjustmentLoanee';
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $model2->applicant_id=$applicantID;
        //$model2->repayment_reference_number=$employer2->employer_code;
        $totalAmount1=$model2->amount;
        $loan_repayment_id=$model2->loan_repayment_id;
        $model2->pay_method_id=$model2->getPaymentMethod();
        //$model2->pay_method_id=4;
        //generating payment reference number
        //end generating
        
        if($applicantID >0){
       $model2->updateLoaneeAdjustedPaymentAmount($totalAmount1,$loan_repayment_id);
        if($model2->save()){
          //reference no to send to GePG  
            $ActiveBill=$modelBill->getActiveBillLoanee($applicantID);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number="BEN"."-".$model2->loan_repayment_id;
            $loan_repayment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            $$searchModel->updateLoaneeWhenAdjustedPaymentAmount($totalAmount1,$loan_repayment_id,$applicantID);
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);
            
        }
        //end requesting number
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        }
        return $this->render('indexBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'applicantID'=>$applicantID,
            'modelBill'=>$modelBill,
            
        ]);
    }     
     
    
    public function actionConfirmPayment($loan_repayment_id)
    {
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        if($loan_repayment_id >0){
            //requesting control number
            //this is for temporaly test
            $controlNumber=mt_rand (10,100);
            //end for temporaly test
          //end
            $model2->updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber);
        //end requesting number
        }
        return $this->render('confirmed_payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'loan_repayment_id'=>$loan_repayment_id,
            'modelBill'=>$modelBill,
            
        ]);
    }
    
    public function actionConfirmPaymentLoanee($loan_repayment_id)
    {
        $this->layout="main_private_beneficiary";
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        if($loan_repayment_id >0){
            //requesting control number
            //this is for temporaly test
            $controlNumber=mt_rand (10,100);
            //end for temporaly test
          //end
            $model2->updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber);
        //end requesting number
        }
        return $this->render('confirmed_payment_beneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'loan_repayment_id'=>$loan_repayment_id,
            'modelBill'=>$modelBill,
            
        ]);
    }
    
     public function actionRequestPaymentAdjustment($loan_repayment_id)
    {
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerCode=$employer2->employer_code;               
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        return $this->render('request_payment_adjustment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'loan_repayment_id'=>$loan_repayment_id,
            'modelBill'=>$modelBill,
            
        ]);
    }
    
    public function actionPaymentAdjustmentLoanee($loan_repayment_id,$amount)
    {
        $this->layout="main_private_beneficiary";
        $model2 = new LoanRepayment();
        $searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $loaneeDetails=$employerModel->getApplicant($loggedin);
        $applicantID=$loaneeDetails->applicant_id;               
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        return $this->render('paymentAdjustmentLoanee', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'loan_repayment_id'=>$loan_repayment_id,
            'applicantID'=>$applicantID,
            'amount'=>$amount,
            
        ]);
    }

    /**
     * Displays a single LoanRepayment model.
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
     * Creates a new LoanRepayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LoanRepayment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_repayment_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LoanRepayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_repayment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanRepayment model.
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
     * Finds the LoanRepayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanRepayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanRepayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionReceipt()
    {
	$user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $model = new LoanRepayment();
            return $this->render('receipt', [
                'model' => $model,
            ]);
    }
}
