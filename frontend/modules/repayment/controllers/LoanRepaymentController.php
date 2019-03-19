<?php

namespace frontend\modules\repayment\controllers;

use common\components\GSSPSoapClient;
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
use frontend\modules\repayment\models\GepgLawson;
use frontend\modules\repayment\models\GepgLawsonSearch;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \common\rabbit\Producer;
//use  yii\web\Session;

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
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
        $model = new LoanRepayment();
        $modelBill = new LoanSummary();
        $searchModel = new LoanRepaymentSearch();

        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		
		$resultsAfterCheck=$model->checkUnCompleteBillEmployer($employerID);
		if($resultsAfterCheck !=0){
        $loan_repayment_id=$resultsAfterCheck->loan_repayment_id;
		}else{
		$loan_repayment_id=0;
		}	
        //redirect to genarate bill
		    $results1=$model->checkControlNumberStatus($employerID,$loan_given_to);
			$results_bill_number=(count($results1) == 0) ? '0' : $results1->loan_repayment_id;
            $ActiveBill=$modelBill->getActiveBill($employerID,$loan_given_to);
            $billID=$ActiveBill->loan_summary_id;			
			//$amountRemainedUnpaid=$modelBill->getLoanSummaryBalance($billID);
			$date=date("Y-m-d");
            $amountRemainedUnpaid=\frontend\modules\repayment\models\LoanSummaryDetail::getOustandingAmountUnderLoanSummary($billID,$date,$loan_given_to);
			if($amountRemainedUnpaid < 1){
			$modelBill->updateCompletePaidLoanSummary($billID);
			}			
			if($results_bill_number ==0 && $billID !=0){
			return $this->redirect(['generate-bill']);
			}
		//end redirecting to generate bill

		
		$dataProviderIncompleteBills=$searchModel->searchIncompleteBillEmployer(Yii::$app->request->queryParams,$employerID);
		$dataProviderBills=$searchModel->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderIncompleteBills' => $dataProviderIncompleteBills,
            'model' => $model,
            'employerID'=>$employerID,
            'modelBill'=>$modelBill,
            'dataProviderBills' => $dataProviderBills,
			'loan_repayment_id'=>$loan_repayment_id,
        ]);
        
    }
	
	public function actionIndexNotification()
    {
        $model = new LoanRepayment();
        $searchModel = new LoanRepaymentSearch();

        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;		
		$dataProviderPendingPayments=$searchModel->searchPendingPaymentsEmployer(Yii::$app->request->queryParams,$employerID);
        return $this->render('indexNotification', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProviderPendingPayments,            
        ]);
        
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
        $searchModel = new LoanRepaymentSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //$searchModel = new LoanRepaymentDetailSearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $resultsAfterCheck=$model->checkUnCompleteBill($applicantID);
		if($resultsAfterCheck !=0){
        $loan_repayment_id=$resultsAfterCheck->loan_repayment_id;
		}else{
		$loan_repayment_id=0;
		}
        $dataProvider = $searchModel->searchIncompleteBillBeneficiary(Yii::$app->request->queryParams,$applicantID);
		$dataProvider2 = $searchModel->searchPaymentsForSpecificApplicant(Yii::$app->request->queryParams,$applicantID);
        return $this->render('indexBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'dataProvider2' => $dataProvider2,
            'model' => $model,
            'modelBill'=>$modelBill,
			'loan_repayment_id'=>$loan_repayment_id,
			'applicantID'=>$applicantID,
        ]);
        
    }
	
	public function actionGenerateBill()
    {
        $searchModel = new LoanRepaymentDetailSearch();
		$loan_given_to=LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
		$searchLoanRepayment = new LoanRepaymentSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $model2->employer_id=$employerID;
		$model2->scenario='billGeneration2';
        //$model2->repayment_reference_number=$employer2->employer_code;
        $model2->amount=0;
        //$model2->pay_method_id=4;
        //$model2->pay_method_id=$model2->getPaymentMethod();
        //generating payment reference number
        //end generating
        if ($model2->load(Yii::$app->request->post())) {
        if($employerID >0){
			$salarySource=$model2->salarySource;
        // requesting control number from GePG
		//check if all beneficiaries have Gross salaries
		$getGrossSalaryStatus=\frontend\modules\repayment\models\EmployedBeneficiary::getBeneficiaryGrossSalaryStatus($employerID);
		if($getGrossSalaryStatus >0){
		$sms="Error: Please set GROSS SALARY to all beneficiaries! Thanks!";
        Yii::$app->getSession()->setFlash('error', $sms);	
		return $this->redirect(['generate-bill']);	
		}else{
		//end check
		
        if($model2->save()){
		
          //reference no to send to GePG  
            $ActiveBill=$modelBill->getActiveBill($employerID,$loan_given_to);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            //$repaymnet_reference_number=$employer2->employer_code."-".$model2->loan_repayment_id;
			
			//generate bill
			$yearT=date("Y");	
	$resultsCount=\frontend\modules\repayment\models\LoanRepayment::getBillRepaymentEmployer($employerID,$yearT) + 1;
    $repaymnet_reference_number=\frontend\modules\repayment\models\LoanRepayment::EMPLOYER_BILL_FORMAT.$employer2->employer_code.$yearT."-".$resultsCount;
			//end generate bill
			
			
            $loan_repayment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            if($salarySource==2){
			$searchModel->insertAllPaymentsofAllLoaneesUnderBillSalarySourceBases($loan_summary_id,$loan_repayment_id,$loan_given_to);	
			}else{
			$searchModel->insertAllPaymentsofAllLoaneesUnderBill($loan_summary_id,$loan_repayment_id,$loan_given_to);
			}
            
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id,$loan_given_to);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);			
			return $this->redirect(['confirm-payment', 'id' => $model2->loan_repayment_id]);            
        }
		}
        //end requesting number
        }
        }
        $dataProviderBills=$searchLoanRepayment->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);		
        return $this->render('generateBill', [
            'model' => $model2,'dataProviderBills'=>$dataProviderBills,'searchLoanRepayment' => $searchLoanRepayment,
            
        ]);
		
    }
	
    
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
     
    
    public function actionConfirmPayment($id)
    {    
	    $model = $this->findModel($id);
		$loan_repayment_id=$id;
        //$model2 = new LoanRepayment();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;                
        $employerSalarySource=$employerModel->getEmployerSalarySource2($employerID);
        $searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
		if ($model->load(Yii::$app->request->post())) {
		if($model->save()){
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        if($loan_repayment_id >0){
            //requesting control number
            //this is for temporaly test
            if($employerSalarySource==0){
            $controlNumber=mt_rand (10,100);
            }else{
            $controlNumber='';    
            }
            //end for temporaly test
          //end
		     $testingLocal=\frontend\modules\repayment\models\LoanRepayment::TESTING_REPAYMENT_LOCAL;
			//GePG LIVE
			if($testingLocal=='N'){
            $dataToQueue=$model->getEmployerDetailsForBilling($loan_repayment_id);
            Producer::queue("GePGBillSubmitionQueue", $dataToQueue);
			}
            //end GePG LIVE
            ###########below to be commented when we go with GePG######
			if($testingLocal=='T'){
            $model->updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber);
			}
            ##############END below to be commented when we go with GePG####
        //end requesting number
		if($employerSalarySource==0){
		   $sms="Kindly use the below control number for payment!";
                }else{
                  $sms="Bill successful confirmed!";  
                }
           Yii::$app->getSession()->setFlash('success', $sms);
           return $this->redirect(['viewconfirmed-payment', 'id' => $model->loan_repayment_id]);
                
        }
		}
		}else {
            return $this->render('confirmPayment', [
                'model' => $model,'employerSalarySource'=>$employerSalarySource,'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
        }
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
	public function actionGenerateBillbeneficiary()
    {
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
	    $this->layout="main_private_beneficiary";
        $searchModel = new LoanRepaymentDetailSearch();
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $model2->applicant_id=$applicantID;
        $model2->amount=0;
        $loan_repayment_id='';
        //$model2->pay_method_id=$model2->getPaymentMethod();
        $model2->payment_date=date('Y-m-d');
        if($applicantID >0){			
        if($model2->save()){
            $ActiveBill=$modelBill->getActiveBillLoanee($applicantID,$loan_given_to);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID; 
            //$beneficiaryCode="BEN";			
            //$repaymnet_reference_number=$beneficiaryCode."-".$model2->loan_repayment_id;
			
			//generate bill
			$yearT=date("Y");	
    $repaymnet_reference_number=\frontend\modules\repayment\models\LoanRepayment::BENEFICIARY_BILL_FORMAT.$yearT."-".$model2->loan_repayment_id;
			//end generate bill
			
            $loan_repayment_id=$model2->loan_repayment_id;
			
            
            $searchModel->insertAllPaymentsofAllLoaneesUnderBillSelfEmployedBeneficiary($loan_summary_id,$loan_repayment_id,$applicantID,$loan_given_to);
            $totalAmount1=$model2->getAmountRequiredForPaymentSelfBeneficiary($loan_repayment_id,$applicantID);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);
		   return $this->redirect(['confirm-paymentbeneficiary', 'id' => $model2->loan_repayment_id]);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        }
        return $this->render('pendingpaymentsBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model2,
            'applicantID'=>$applicantID,
            'modelBill'=>$modelBill,
			'id'=>$loan_repayment_id,
            
        ]);
    }
		
	public function actionViewconfirmedPaymentbeneficiary($id)
    {
	    $this->layout="main_private_beneficiary";
        return $this->render('viewconfirmedPaymentbeneficiary', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionViewconfirmedPayment($id)
    {
	    $this->layout="main_private";
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;                
        $employerSalarySource=$employerModel->getEmployerSalarySource2($employerID);
        return $this->render('viewconfirmedPayment', [
            'model' => $this->findModel($id),'employerSalarySource'=>$employerSalarySource
        ]);
    }
	
	public function actionConfirmPaymentbeneficiary($id)
    {
	    $this->layout="main_private_beneficiary";
        $model = $this->findModel($id);		
		$searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
		$ModelLoanRepaymentDetail = new LoanRepaymentDetail();
		$employerModel = new EmployerSearch();
		//$model->scenario='paymentAdjustmentLoanee';
		
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			//end if amount changed
			$testingLocal=\frontend\modules\repayment\models\LoanRepayment::TESTING_REPAYMENT_LOCAL;
			//GePG LIVE
			if($testingLocal=='N'){
            $dataToQueue=$model->getBeneficiaryDetailsForBilling($model->loan_repayment_id);
            Producer::queue("GePGBillSubmitionQueue", $dataToQueue);
			}
            //end GePG LIVE
		   $sms="Kindly use the below control number for payment!";
           Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['viewconfirmed-paymentbeneficiary', 'id' => $model->loan_repayment_id]);
			}else {
            return $this->render('confirmPaymentbeneficiary', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionAdjustAmountBeneficiary()
    {
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
        $model = new LoanRepayment();	
		$searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
		$ModelLoanRepaymentDetail = new LoanRepaymentDetail();
		$employerModel = new EmployerSearch();
		$model->scenario='paymentAdjustmentLoanee';
		
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;

        if (Yii::$app->request->post()) {
			$request = Yii::$app->request->post();
			$outstandingAmount=str_replace(",","",$request['outstandingAmount']);
			$amount=str_replace(",","",$request['amount']);
			$loan_repayment_id=$request['loan_repayment_id'];
			$loan_summary_id=$request['loan_summary_id'];
			$minimumAmount=str_replace(",","",$request['amountApplicant']);
			 //&& $model->validate()
			 
		if($amount !=''){
			if(!is_numeric($amount)){
				$sms="Operation failed, Pay amount must nummber!";
                Yii::$app->getSession()->setFlash('danger', $sms); 
				return $this->redirect(['confirm-paymentbeneficiary','id'=>$loan_repayment_id]);
			}else{
            if(($outstandingAmount >= $amount) && $amount > 0){
            if($amount < $minimumAmount){
			$sms="Operation Fail,Pay amount must not be less than ".number_format($minimumAmount,2);
			Yii::$app->getSession()->setFlash('error', $sms);
			return $this->redirect(['confirm-paymentbeneficiary','id'=>$loan_repayment_id]);
			}else{
			$model->updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber=NULL);
            //if(($amount != $model->amountApplicant)){
			$model->resetTheOldAmountOnPaymentAdjustmentAccepted($loan_repayment_id,$applicantID);			
			$ModelLoanRepaymentDetail->updateNewAmountOnAdjustmentOfPaymentEmployedBeneficiary($loan_summary_id,$loan_repayment_id,$amount,$applicantID,$loan_given_to);			
            $totalAmount1=$model->getAmountRequiredForPayment($loan_repayment_id,$loan_given_to);			
            $model->updateNewTotaAmountAfterPaymentAdjustment($totalAmount1,$loan_repayment_id);
			//}	
			}
           $sms="Amount successful adjusted, Kindly confirm payment!";
           Yii::$app->getSession()->setFlash('success', $sms);			
		   return $this->redirect(['confirm-paymentbeneficiary','id'=>$loan_repayment_id]);
			}else{
			$sms="Pay Amount must be less than or equal to outstanding amount";
           Yii::$app->getSession()->setFlash('danger', $sms);			
		   return $this->redirect(['confirm-paymentbeneficiary','id'=>$loan_repayment_id]);
			}
		}}else{
			$sms="Pay Amount must be less than or equal to outstanding amount";
                Yii::$app->getSession()->setFlash('danger', $sms); 
				return $this->redirect(['confirm-paymentbeneficiary','id'=>$loan_repayment_id]); 
			 }
		} else {
            return $this->render('confirmPaymentbeneficiary', [
                'model' => $model,
            ]);
        }
    }
	public function actionPendingpaymentsBeneficiary()
    {
	    $this->layout="main_private_beneficiary";
		$employerModel = new EmployerSearch();
		$loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $searchModel = new LoanRepaymentSearch();
        $dataProvider = $searchModel->searchPendingpaymentsBeneficiary(Yii::$app->request->queryParams,$applicantID);

        return $this->render('pendingpaymentsBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionIndexTreasury()
    {
	   $this->layout="main_private_treasury";
        $model = new LoanRepayment();
        $modelBill = new LoanSummary();
        $searchModel = new LoanRepaymentSearch();

        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		
		$resultsAfterCheck=$model->checkUnCompleteBillEmployer($employerID);
		if($resultsAfterCheck !=0){
        $loan_repayment_id=$resultsAfterCheck->loan_repayment_id;
		}else{
		$loan_repayment_id=0;
		}	
        //redirect to genarate bill
		    $results1=$model->checkControlNumberStatus($employerID);
			$results_bill_number=(count($results1) == 0) ? '0' : $results1->loan_repayment_id;
            $ActiveBill=$modelBill->getActiveBill($employerID);
            $billID=$ActiveBill->loan_summary_id;			
			$amountRemainedUnpaid=$modelBill->getLoanSummaryBalance($billID);
			if($amountRemainedUnpaid < 1){
			$modelBill->updateCompletePaidLoanSummary($billID);
			}			
			if($results_bill_number ==0 && $billID !=0){
			return $this->redirect(['generate-bill']);
			}
		//end redirecting to generate bill

		
		$dataProviderIncompleteBills=$searchModel->searchIncompleteBillEmployer(Yii::$app->request->queryParams,$employerID);
		$dataProviderBills=$searchModel->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);
        return $this->render('indexTreasury', [
            'searchModel' => $searchModel,
            'dataProviderIncompleteBills' => $dataProviderIncompleteBills,
            'model' => $model,
            'employerID'=>$employerID,
            'modelBill'=>$modelBill,
            'dataProviderBills' => $dataProviderBills,
			'loan_repayment_id'=>$loan_repayment_id,
        ]);
        
    }
    
    public function actionIndexTreasuryBill()
    {	
     $this->layout="main_private_treasury";
        $model = new LoanRepayment();
        $searchModel = new LoanRepaymentSearch();

        $loggedin=Yii::$app->user->identity->user_id;        
		
		$resultsAfterCheck=$model->checkUnCompleteBillTreasury();
		if($resultsAfterCheck !=0){
        $loan_repayment_id=$resultsAfterCheck->loan_repayment_id;
		}else{
		$loan_repayment_id=0;
		}
		
        $results1=$model->checkControlNumberStatusTreasury();
			$results_bill_number=(count($results1) == 0) ? '0' : $results1->loan_repayment_id;
		$EmployersBillPending=$model->checkBillPendingGovernmentEmployers();
                //check if exists pending selected bill
                $resultsPendingSelectedBill=\frontend\modules\repayment\models\LoanRepayment::getSelectedBillsTreasuryPending();
        if($resultsPendingSelectedBill->loan_repayment_id==''){
            $existingSelectedBill=0;
        }else{
            $existingSelectedBill=1;
        }
        //end check if exists pending selected bill
            //echo $existingSelectedBill;
            //exit;
        if(($results_bill_number ==0 && $EmployersBillPending !=0)){
			return $this->redirect(['generate-bill-treasury']);
			}
		$dataProviderBills=$searchModel->searchTreasuryBills(Yii::$app->request->queryParams);
        return $this->render('indexTreasuryBill', [
            'searchModel' => $searchModel,
            'dataProviderBills' => $dataProviderBills,'loan_repayment_id'=>$loan_repayment_id
        ]);
    }
    public function actionGenerateBillTreasury()
    {
        $this->layout="main_private_treasury";
        $searchModel = new LoanRepaymentDetailSearch();
        $model2 = new LoanRepayment();
		$searchLoanRepayment = new LoanRepaymentSearch();
                $searchBillsEmp = new LoanRepaymentSearch();
        $loggedin=Yii::$app->user->identity->user_id;
		$model2->scenario='billGeneration';
        //$model2->repayment_reference_number=$employer2->employer_code;
        $model2->amount=0;
        //$model2->pay_method_id=4;
        $model2->pay_method_id=LoanRepayment::getPaymentMethod();
        //generating payment reference number
        //end generating
        if ($model2->load(Yii::$app->request->post())) {
        // requesting control number from GePG
        if($model2->save()){
		
          //reference no to send to GePG  
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number="T".date("Y")."-".$model2->loan_repayment_id;
            $treasury_payment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            //$searchModel->insertAllGovernmentEmployersBill($loan_repayment_id);
            $searchModel->updateAllGovernmentEmployersBill($treasury_payment_id);
            //$totalAmount1=$model2->getAmountRequiredForPayment($treasury_payment_id);
            $totalAmount1=$model2->getAmountRequiredForPaymentTreasury($treasury_payment_id);
       //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);
       $model2->updateReferenceNumberTreasury($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);	
			return $this->redirect(['confirm-payment-treasury', 'id' => $model2->loan_repayment_id]);            
        }
        //end requesting number
        
        }
        $resultsPendingSelectedBill=\frontend\modules\repayment\models\LoanRepayment::getSelectedBillsTreasuryPending();
        if($resultsPendingSelectedBill->loan_repayment_id==''){
            $existingSelectedBill=0;
        }else{
            $existingSelectedBill=1;
        }
        $dataProviderBills=$searchLoanRepayment->searchTreasuryBills(Yii::$app->request->queryParams);
        $dataProviderBillsEmp=$searchBillsEmp->searchTreasuryBillsEmployerPendingPayments(Yii::$app->request->queryParams);
        return $this->render('generateBillTreasury', [
            'model' => $model2,'dataProviderBills'=>$dataProviderBills,'searchLoanRepayment' => $searchLoanRepayment,'dataProviderBillsEmp'=>$dataProviderBillsEmp,'searchBillsEmp' => $searchBillsEmp,'existingSelectedBill'=>$existingSelectedBill,
            
        ]);
		
    }
    public function actionConfirmPaymentTreasury($id)
    {  
        $this->layout="main_private_treasury";
	    $model = $this->findModel($id);
		$treasury_payment_id=$id;
            $model->scenario = "billConfirmationTreasury";
        $searchModel = new LoanRepaymentDetailSearch();
		if ($model->load(Yii::$app->request->post())) {
		if($model->save()){
        
        if($treasury_payment_id >0){
            //requesting control number
            //this is for temporaly test
            $controlNumber=mt_rand (10,100);
            //end for temporaly test
          //end
            $model->updateConfirmPaymentandControlNoTreasury($treasury_payment_id,$controlNumber);
        //end requesting number
		
		   $sms="Kindly use the below control number for payment!";
           Yii::$app->getSession()->setFlash('success', $sms);
           return $this->redirect(['viewconfirmed-payment-treasury', 'id' => $model->loan_repayment_id]);
        }
		}
		}else {
            return $this->render('confirmPaymentTreasury', [
                'model' => $model,
            ]);
        }
    }
    public function actionViewconfirmedPaymentTreasury($id)
    {
        $this->layout="main_private_treasury";
	    //$this->layout="main_private";
        return $this->render('viewconfirmedPaymentTreasury', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionEmployersBillsTreasury($id)
    {
	   $this->layout="default_main";
        $searchModel = new LoanRepaymentSearch();
        $dataProvider = $searchModel->searchTreasuryBills2(Yii::$app->request->queryParams,$id);

        return $this->render('employersBillsTreasury', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewTreasury($id)
    {
      $this->layout="main_private_treasury";  
        return $this->render('viewTreasury', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionReceiptTreasury()
    {
        $this->layout="main_private_treasury"; 
        $model = new LoanRepayment();
        $searchModel = new LoanRepaymentSearch();
        $loggedin=Yii::$app->user->identity->user_id;        
		$dataProviderBills=$searchModel->searchReceiptTreasury(Yii::$app->request->queryParams);
        return $this->render('receiptTreasury', [
            'searchModel' => $searchModel,
            'dataProviderBills' => $dataProviderBills
        ]);
    }
    
    
public function actionPrintReceipt($id) {
    // get your HTML raw content without any layouts or scripts
    $htmlContent = $this->renderPartial('printReceipt',['id' =>$id]);
    
    // setup kartik\mpdf\Pdf component
 $pdf = Yii::$app->pdf;
$pdf->content = $htmlContent;
return $pdf->render();
    
    // return the pdf output as per the destination setting
    //return $pdf->render(); 
}
     
    
    public function actionUpdateSelectedBilltreasury()
    {	
           $this->layout="main_private_treasury";
	   $user_loged_in=Yii::$app->user->identity->login_type;
           $user_id=Yii::$app->user->identity->user_id;
           $model = new LoanRepayment();
        $loan_repayment_id='';
		   $selection=(array)Yii::$app->request->post('selection');//typecasting
                   if(count($selection) > 0){
                    $model->amount=0;
                    $model->save();
                   
                   $treasury_payment_id=$model->loan_repayment_id;
		   foreach($selection as $loan_repayment_id){
                   $loanRepayment=\frontend\modules\repayment\models\LoanRepayment::findOne(['loan_repayment_id'=>$loan_repayment_id]);
                   $loanRepayment->treasury_payment_id=$treasury_payment_id;
                   $loanRepayment->treasury_user_id=$user_loged_in;
                   $loanRepayment->save();                   
		   }
                   $getAllBillsUnderTreasuryId=\frontend\modules\repayment\models\LoanRepayment::find()
                                     ->where(['treasury_payment_id'=>$treasury_payment_id,'treasury_user_id'=>$user_id])->all();
                   foreach($getAllBillsUnderTreasuryId as $results){
                    $loan_repayment_id=$results->loan_repayment_id;
                    \frontend\modules\repayment\models\LoanRepaymentDetail::updateAllGovernmentEmployersBillMultSelected($treasury_payment_id,$loan_repayment_id,$user_id);
                       
                   }
                   $repaymnet_reference_number="T".date("Y")."-".$model->loan_repayment_id;
                   $totalAmount1=$model->getAmountRequiredForPaymentTreasury($treasury_payment_id);
                   $model->updateReferenceNumberTreasury($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);	
		   return $this->redirect(['confirm-payment-treasury', 'id' => $model->loan_repayment_id]);
                   }
                   /*
                   //reference no to send to GePG  
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number="T".date("Y")."-".$model2->loan_repayment_id;
            $treasury_payment_id=$model2->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            //$searchModel->insertAllGovernmentEmployersBill($loan_repayment_id);
            $searchModel->updateAllGovernmentEmployersBill($treasury_payment_id);
            //$totalAmount1=$model2->getAmountRequiredForPayment($treasury_payment_id);
            $totalAmount1=$model2->getAmountRequiredForPaymentTreasury($treasury_payment_id);
       //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);
       $model2->updateReferenceNumberTreasury($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);	
			return $this->redirect(['confirm-payment-treasury', 'id' => $model2->loan_repayment_id]); 
                   
                   */
                   
                   
		   if($loan_repayment_id !=''){
		   $sms="Bill Generated";
		   Yii::$app->getSession()->setFlash('success', $sms);
		   }
		   if($loan_repayment_id ==''){
		   $sms=" Error: No any bill selected!";
		   Yii::$app->getSession()->setFlash('error', $sms);
		   }
		   return $this->redirect(['generate-bill-treasury']);
    }
    
    public function actionGenerateBillbulkTreasury()
    {
        $this->layout="main_private_treasury";
        $model = new LoanRepayment();
        $model->scenario='bulkBillTreasury';
        $user_id=Yii::$app->user->identity->user_id;

        if ($model->load(Yii::$app->request->post())) {
                
                $model->amount=0;
                $model->save();
                
                $treasury_payment_id=$model->loan_repayment_id;
                //$array=$model->loan_repayment_bulkId;
                $array=$model->employerId_bulk;
                foreach ($array as $employer_id) {
                    $checkAllEmployerBills=  \frontend\modules\repayment\models\LoanRepayment::find()
                            ->select('loan_repayment_id')
                            ->where(['employer_id'=>$employer_id,'treasury_payment_id'=>NULL])->all();
                    foreach($checkAllEmployerBills AS $loan_repayment_id){
                 $loanRepayment=\frontend\modules\repayment\models\LoanRepayment::findOne(['loan_repayment_id'=>$loan_repayment_id->loan_repayment_id]);
                 $loanRepayment->treasury_payment_id=$treasury_payment_id;
                 $loanRepayment->treasury_user_id=$user_id;
                 $loanRepayment->save(false);  
                    }
                }
                

            $getAllBillsUnderTreasuryId=\frontend\modules\repayment\models\LoanRepayment::find()
                                     ->where(['treasury_payment_id'=>$treasury_payment_id,'treasury_user_id'=>$user_id])->all();
                   foreach($getAllBillsUnderTreasuryId as $results){
                    $loan_repayment_id=$results->loan_repayment_id;
            \frontend\modules\repayment\models\LoanRepaymentDetail::updateAllGovernmentEmployersBillMultSelected($treasury_payment_id,$loan_repayment_id,$user_id);
                       
                   }
                   $repaymnet_reference_number="T".date("Y")."-".$model->loan_repayment_id;
                   $totalAmount1=$model->getAmountRequiredForPaymentTreasury($treasury_payment_id);
                   $model->updateReferenceNumberTreasury($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);	
		   return $this->redirect(['confirm-payment-treasury', 'id' => $model->loan_repayment_id]);
        } else {
            return $this->render('generateBillbulkTreasury', [
                'model' => $model,
            ]);
        }
    }
	public function actionWaitingControlnumber()
    {
        $this->layout="main_private";
        $searchModel = new LoanRepaymentSearch();
        $dataProvider = $searchModel->searchWaitingControlnumber(Yii::$app->request->queryParams);
        return $this->render('waitingControlnumber', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }
	public function actionCancelBillEmployer($id)
    {
		$modelLoanRepayment = new LoanRepayment();
		$employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		$results=$modelLoanRepayment->find()->where(['loan_repayment_id'=>$id])->one();
		$results->payment_status=3;
		$results->canceled_by=$loggedin;
		$results->canceled_at =date("Y-m-d H:i:s");
		$results->cancel_reason=Yii::$app->params['employer_cancelBillReason'];
		$results->save();
		
	    $sms="Bill Cancelled";
        Yii::$app->getSession()->setFlash('success', $sms);		
		return $this->redirect(['index']);
    }
	public function actionCancelBillBeneficiary($id)
    {
		$this->layout="main_private_beneficiary";
		$modelLoanRepayment = new LoanRepayment();
		$employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		$results=$modelLoanRepayment->find()->where(['loan_repayment_id'=>$id])->one();
		$results->payment_status=3;
		$results->canceled_by=$loggedin;
		$results->canceled_at =date("Y-m-d H:i:s");
		$results->cancel_reason=Yii::$app->params['cancelBillReason'];
		$results->save();
		
	    $sms="Bill Cancelled";
        Yii::$app->getSession()->setFlash('success', $sms);		
		return $this->redirect(['index-beneficiary']);
    }
	public function actionGenerateBillscholarship()
    {
        $searchModel = new LoanRepaymentDetailSearch();
		$loan_given_to=LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
        $model2 = new LoanRepayment();
        $modelBill = new LoanSummary();
        $employerModel = new EmployerSearch();
		$searchLoanRepayment = new LoanRepaymentSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $model2->employer_id=$employerID;
		$model2->scenario='billGeneration';
        //$model2->repayment_reference_number=$employer2->employer_code;
        $model2->amount=0;
        //$model2->pay_method_id=4;
        //$model2->pay_method_id=$model2->getPaymentMethod();
        //generating payment reference number
        //end generating
        $model2->payment_date=date('Y-m-d');
        if($employerID >0){			
        if($model2->save()){
		
          //reference no to send to GePG  
            $ActiveBill=$modelBill->getActiveBill($employerID,$loan_given_to);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            //$repaymnet_reference_number=$employer2->employer_code."-".$model2->loan_repayment_id;
            $loan_repayment_id=$model2->loan_repayment_id;
			
			//generate bill
			$yearT=date("Y");	
	$resultsCount=\frontend\modules\repayment\models\LoanRepayment::getBillRepaymentEmployer($employerID,$yearT) + 1;
    $repaymnet_reference_number=\frontend\modules\repayment\models\LoanRepayment::EMPLOYER_BILL_FORMAT.$employer2->employer_code.$yearT."-".$resultsCount;
			//end generate bill
			
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
			
			$searchModel->insertPaymentOfScholarshipBeneficiaries($loan_summary_id,$loan_repayment_id,$loan_given_to);
            
            $totalAmount1=$model2->getAmountRequiredForPayment($loan_repayment_id,$loan_given_to);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);			
			return $this->redirect(['confirm-payment-scholarship', 'id' => $model2->loan_repayment_id]);            
        }
        //end requesting number
        
        }
        $dataProviderBills=$searchLoanRepayment->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);		
        return $this->render('generateBillscholarship', [
            'model' => $model2,'dataProviderBills'=>$dataProviderBills,'searchLoanRepayment' => $searchLoanRepayment,
            
        ]);
		
    }
	public function actionConfirmPaymentScholarship($id)
    {    
	    $this->layout="default_main";
	    $model = $this->findModel($id);
		$loan_repayment_id=$id;
        //$model2 = new LoanRepayment();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;                
        $employerSalarySource=$employerModel->getEmployerSalarySource2($employerID);
        $searchModel = new LoanRepaymentDetailSearch();
        $modelBill = new LoanSummary();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
		if ($model->load(Yii::$app->request->post())) {
		if($model->save()){
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$loan_repayment_id);
        if($loan_repayment_id >0){
            //requesting control number
            //this is for temporaly test
            if($employerSalarySource==0){
            $controlNumber=mt_rand (10,100);
            }else{
            $controlNumber='';    
            }
            //end for temporaly test
			$testingLocal=\frontend\modules\repayment\models\LoanRepayment::TESTING_REPAYMENT_LOCAL;
			//GePG LIVE
			if($testingLocal=='N'){
            $dataToQueue=$model->getEmployerDetailsForBilling($loan_repayment_id);
            Producer::queue("GePGBillSubmitionQueue", $dataToQueue);
			}
            //end GePG LIVE
          //end
		  //below to be deleted when GePG
            if($testingLocal=='T'){		  
            $model->updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber);
			}
			//end below to be deleted when GePG
        //end requesting number
		if($employerSalarySource==0){
		   $sms="Kindly use the below control number for payment!";
                }else{
                  $sms="Bill successful confirmed!";  
                }
           Yii::$app->getSession()->setFlash('success', $sms);
           return $this->redirect(['viewconfirmed-paymentscholarship', 'id' => $model->loan_repayment_id]);
                
        }
		}
		}else {
            return $this->render('confirmPaymentScholarship', [
                'model' => $model,'employerSalarySource'=>$employerSalarySource,'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
        }
    }
	public function actionViewconfirmedPaymentscholarship($id)
    {
	    $this->layout="default_main";
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;                
        $employerSalarySource=$employerModel->getEmployerSalarySource2($employerID);
        return $this->render('viewconfirmedPaymentscholarship', [
            'model' => $this->findModel($id),'employerSalarySource'=>$employerSalarySource
        ]);
    }
	public function actionCancelBillEmployerscholsp($id)
    {
		$this->layout="default_main";
		$modelLoanRepayment = new LoanRepayment();
		$employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		$results=$modelLoanRepayment->find()->where(['loan_repayment_id'=>$id])->one();
		$results->payment_status=3;
		$results->canceled_by=$loggedin;
		$results->canceled_at =date("Y-m-d H:i:s");
		$results->cancel_reason=Yii::$app->params['employer_cancelBillReason'];
		$results->save();
		
	    $sms="Bill Cancelled";
        Yii::$app->getSession()->setFlash('success', $sms);		
		return $this->redirect(['loan-summary/index-scholarshipnotpaid']);
    }
	
public function actionMonthlyDeductionsResponse() {
    $paymentMonth='';
    $paymentYear='';
    echo $paymentMonth."--Month---Year".$paymentYear;exit;
    $config=[];
    $config['password']='User@Heslb123';
    $config['username']='HESLB';
    $config['url']='192.168.1.104/gsppApi/api/'; //192.168.1.104/gsppApi/api/deductions/getdeductions?month=10&year=2018

        $GSSPSoapClient=new GSSPSoapClient($config);
        //exit;
        $fileDeductions=$GSSPSoapClient->getMonthlyGSSPHelbPayment($paymentMonth, $paymentYear);
\frontend\modules\repayment\models\LoanRepayment::requestMonthlyDeduction($fileDeductions);
$sms="Operation Successful!";
Yii::$app->getSession()->setFlash('success', $sms);	
return $this->redirect(['requestgspp-monthdeduction']);	
}
public function actionRequestgsppMonthdeduction()
    {
        $model = new LoanRepayment();
		$model2 = new GepgLawson();
		$searchModel = new GepgLawsonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('requestgsppmonthlydeduction', [
                'model' => $model,
				'model2'=>$model2,
				'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }
public function actionRequestgsppMonthdeductionform()
    {
        $model = new LoanRepayment();
		$model->scenario='gspp_monthly_deduction_request';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['monthly-deductions-response']);
        } else {
            return $this->render('requestgsppmonthlydeductionform', [
                'model' => $model,
            ]);
        }
    }
    public function actionTestgepgControlnumber()
    {
        //$model = new LoanRepayment();
        //$session = Yii::$app->session;
        //$session->set('user_id', '1');
        //$user_id = $session->get('user_id');
        //echo $user_id;
         echo "tele";exit;
        ###########GePG Important part############
        $billNumber='RPEMP88888';
        $control_number='647474647474';
        $billPrefix = substr($billNumber, 0, 5);
        $date_control_received=date("Y-m-d H:i:s");
        $operationType=\backend\modules\repayment\models\GepgBillProcessingSetting::RECEIVE_CONTROL_NO;
        $results_url=\backend\modules\repayment\models\GepgBillProcessingSetting::getBillPrefix($billPrefix,$operationType);

        //return $this->redirect([$results_url->bill_processing_uri,'control_number'=>$control_number,'bill_number'=>$billNumber,'date_control_received'=>$date_control_received]);
        \Yii::$app->runAction("http://localhost/ilms_repayment", [
            'control_number'=>$control_number,
            'bill_number'=>$billNumber,
            'date_control_received'=>$date_control_received
        ]);
        ###########end GePG important part#############
    }
    public function actionReceiveControlnumber($control_number,$bill_number,$date_control_received)
    {
        if($control_number !='' && $bill_number !='' && $date_control_received !='') {
            \frontend\modules\repayment\models\LoanRepayment::updateControlngepgrealy($control_number,$bill_number,$date_control_received);
        }

    }
    public function actionReceivePaymentgepg($controlNumber,$amount,$date_receipt_received,$receiptDate,$receiptNumber)
    {
        if($controlNumber !='' && $amount !='' && $date_receipt_received !='' && $receiptDate !='' && $receiptNumber !='') {
            \frontend\modules\repayment\models\LoanRepayment::updatePaymentAfterGePGconfirmPaymentDonelive($controlNumber,$amount,$date_receipt_received,$receiptDate,$receiptNumber);
        }

    }
    public function actionIndexRefund()
{
    $model = new LoanRepayment();
    $this->layout="main_private_beneficiary";
    return $this->render('index_refund', [
        'model' => $model,
        'jwded'=>890,
    ]);
}
    public function actionRepaymentSchedule()
    {
        $model = new LoanRepayment();
        $employerModel = new EmployerSearch();
        $this->layout="main_private_beneficiary";
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicant_id=$applicant->applicant_id;
        return $this->render('beneficiaryRepaySchedule', [
            'applicant_id'=>$applicant_id,
        ]);
    }
}
