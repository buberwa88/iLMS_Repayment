<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\LoanRepayment;
use backend\modules\repayment\models\LoanRepaymentSearch;
use backend\modules\repayment\models\EmployerSearch;
use backend\modules\repayment\models\LoanSummary;
use backend\modules\repayment\models\LoanRepaymentDetailSearch;
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
        //$searchModel = new LoanRepaymentSearch();
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
        if($resultsAfterCheck->payment_status !='0'){
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'employerID'=>$employerID,
            'modelBill'=>$modelBill,
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
        $model2->pay_method_id=4;
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
      public function actionSend(){
	  set_time_limit(0);
           /*$email =Yii::$app->mailer->compose()
                ->setFrom("shuleapphelp@gmail.com")
                ->setTo("buberwa.1988.seveline@gmail.com")
                ->setSubject('Shule App Account Activation link')
                //->setTextBody('Plain text content')
                ->setHtmBody("Click this link ".\yii\helpers\Html::a('confirm',
            Yii::$app->urlManager->createAbsoluteUrl(
            ['site/confirm','id'=>12,'key'=>43]
            )));
            $email->send();*/
     /*$email =Yii::$app->mailer->compose()
                ->setFrom("shuleapphelp@gmail.com")
                ->setTo("buberwa.1988.seveline@gmail.com")
                ->setSubject('Shule App Account Activation link')
                ->setTextBody('Plain text content')
                ->setHtmBody("Click this link ".\yii\helpers\Html::a('confirm',
            Yii::$app->urlManager->createAbsoluteUrl(
            ['site/confirm','id'=>12,'key'=>43]
            )));
            $email->send();*/
     return Yii::$app
            ->mailer
            ->compose()
            ->setFrom("shuleapphelp@gmail.com")
            ->setTo("buberwa.1988.seveline@gmail.com")
            ->setSubject('Password reset for ')
            ->send();
 
 }
    public function actionReceipt()
    {
        $model = new LoanRepayment();
            return $this->render('receipt', [
                'model' => $model,
            ]);
    }
	public function actionAllPayments()
    {
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployerheslb(Yii::$app->request->queryParams);

        return $this->render('allPayments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
   /* 
    public function actionAllPaymentsheslb()
    {
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployerheslb(Yii::$app->request->queryParams);

        return $this->render('allPayments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
    * 
    */
	public function actionBills()
    {
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployerheslb(Yii::$app->request->queryParams);

        return $this->render('bills', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
	public function actionLoanBillsEmployer()
    {
		$this->layout="default_main";
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployerheslb(Yii::$app->request->queryParams);

        return $this->render('loanBillsEmployer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
	public function actionPaymentslist()
    {
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployerheslb(Yii::$app->request->queryParams);

        return $this->render('paymentslist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
	public function actionLoanBillsBeneficiary()
    {
		$this->layout="default_main";
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificBeneficiaryheslb(Yii::$app->request->queryParams);

        return $this->render('loanBillsBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
	public function actionCancelBillRepayment($id,$identity)
    {
		$this->layout="default_main";
		if($identity=='REPAYMENT'){
        $model = $this->findModel($id);
		$model->scenario = 'Cancell_bill_repayment';
        }else if($identity=='EPNT'){
		$model = \frontend\modules\repayment\models\EmployerPenaltyPayment::findOne($id);
        $model->scenario = 'Cancell_employer_penalty';		
		}
        

        if ($model->load(Yii::$app->request->post())){
        $model->payment_status=3;
		$model->canceled_by=Yii::$app->user->identity->user_id;
		$model->canceled_at=date("Y-m-d H:i:s");
        }
		if($model->load(Yii::$app->request->post()) && $model->save()) {
         //return $this->redirect(['view', 'id' => $model->id]);

         //take cancelled bill in queue
		 if($identity=='REPAYMENT'){
		    $cancel_id=$model->loan_repayment_id;
		 }else if($identity=='EPNT'){
			$cancel_id=$model->employer_penalty_payment_id; 
		 }
			$BillId1 = $model->bill_number;
			$SpCode='SP111';
			$SpSysId='LHESLB001';
            			//echo $SpReconcReqId;
			$dataToQueue = ["SpCode" => $SpCode, 
                                     "SpSysId"=>$SpSysId, 
                                     "BillId1"=>$BillId1]; 
                                     
            if($cancel_id >0){
            //Producer::queue("GePGBillCancellationRequestQueue", $dataToQueue);
			if($identity=='REPAYMENT'){
			$query3 = "UPDATE loan_repayment SET gepg_cancel_request_status='1' WHERE  	loan_repayment_id='".$cancel_id."'";
             Yii::$app->db->createCommand($query3)->execute();
			}else if($identity=='EPNT'){
			$query3 = "UPDATE employer_penalty_payment SET gepg_cancel_request_status='1' WHERE  	employer_penalty_payment_id='".$cancel_id."'";
             Yii::$app->db->createCommand($query3)->execute();	
			}
			 }
			 
		//end take cancelled bill in queue
		    $sms = '<p>Bill Cancelled successful!</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
			if($identity=='REPAYMENT'){
         if($model->employer_id > 0){
          return $this->redirect(['loan-bills-employer']);
		 }else if($model->applicant_id > 0){
		  return $this->redirect(['loan-bills-beneficiary']);	 
		 }
			}else if($identity=='EPNT'){
		  return $this->redirect(['employer/employer-penalty-bill']);	
			}
        } else {
            return $this->render('cancelBillRepayment', [
                'model' => $model,'identity'=>$identity,
            ]);
        }
    }
	public function actionPaymentsEmployer()
    {
		$this->layout="default_main";
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificEmployerheslbRe(Yii::$app->request->queryParams);

        return $this->render('paymentsEmployer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
	public function actionPaymentsBeneficiary()
    {
		$this->layout="default_main";
        $searchModel = new LoanRepaymentSearch();
        $dataProvider=$searchModel->searchPaymentsForSpecificBeneficiaryheslbRe(Yii::$app->request->queryParams);

        return $this->render('paymentsBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);    
        
    }
}
