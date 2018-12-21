<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\LoanSummary;
use backend\modules\repayment\models\LoanSummaryDetail;
use backend\modules\repayment\models\LoanSummaryDetailSearch;
use backend\modules\repayment\models\LoanSummarySearch;
use backend\modules\repayment\models\EmployerSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\repayment\models\EmployedBeneficiarySearch;
use backend\modules\repayment\models\EmployedBeneficiary;



/**
 * LoanSummaryController implements the CRUD actions for LoanSummary model.
 */
class LoanSummaryController extends Controller
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
     * Lists all LoanSummary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $loggedin=Yii::$app->user->identity->login_type;
        if($loggedin==5){
        $this->layout="main_private";
        }else if($loggedin==2){
        $this->layout="main_private";    
        }
        $searchModel = new LoanSummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionEmployerBillRequestPending()
    {
        $loggedin=Yii::$app->user->identity->login_type;
        if($loggedin==5){
        $this->layout="main_private";
        }else if($loggedin==2){
        $this->layout="main_private";    
        }
        $searchModel = new EmployerSearch();
        $dataProvider = $searchModel->employerBillRequestPending(Yii::$app->request->queryParams);

        return $this->render('employerBillRequestPending', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanSummary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new LoanSummaryDetailSearch();
        $loan_summary_id=$id;
        $dataProvider = $searchModel->loaneesUnderBill(Yii::$app->request->queryParams,$loan_summary_id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionViewLoanSummaryApproved($id)
    {
	    $this->layout="default_main";
        $searchModel = new LoanSummaryDetailSearch();
        $loan_summary_id=$id;
        $dataProvider = $searchModel->loaneesUnderBill(Yii::$app->request->queryParams,$loan_summary_id);
        return $this->render('viewLoanSummaryApproved', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionViewLoaneesInLoanSummaryApproved($id)
    {
	    $this->layout="default_main";
        $searchModel = new LoanSummaryDetailSearch();
        $loan_summary_id=$id;
        $dataProvider = $searchModel->loaneesUnderBill(Yii::$app->request->queryParams,$loan_summary_id);
        return $this->render('viewLoaneesInLoanSummaryApproved', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionViewLoanDetailsInLoanSummaryApproved($id)
    {
	    $this->layout="default_main";
        $searchModel = new LoanSummaryDetailSearch();
        $loan_summary_id=$id;
        $dataProvider = $searchModel->loaneesUnderBill(Yii::$app->request->queryParams,$loan_summary_id);
        return $this->render('viewLoanDetailsInLoanSummaryApproved', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionViewLoanDetailsInLoanSummary($id)
    {
	//$this->layout="default_main";
	
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==2){
           $this->layout="main_private"; 
        }
		
        return $this->render('viewLoanDetailsInLoanSummary', [
            'model' => $this->findModel($id),
        ]);
    }
    /*
    public function actionBillPrepation($employerID)
    {
        $this->layout="main_private";
        
        $searchModel = new EmployedBeneficiarySearch();
        $model = new LoanSummary();
        $employedBeneficiary = new EmployedBeneficiary();
        $dataProvider = $searchModel->verified_beneficiaries(Yii::$app->request->queryParams,$employerID);
        return $this->render('billPrepation', [
                    'employer_id' => $employerID,'dataProvider'=>$dataProvider,'searchModel' => $employedBeneficiary,'model'=>$model,
        ]);    
    }
	*/
	
	public function actionViewLoanSummary($employerID)
    {
        $this->layout="main_private";
        
        $searchModel = new EmployedBeneficiarySearch();
        $model = new LoanSummary();
        $employedBeneficiary = new EmployedBeneficiary();
        $dataProvider = $searchModel->verified_beneficiaries(Yii::$app->request->queryParams,$employerID);
        return $this->render('viewLoanSummary', [
                    'employer_id' => $employerID,'dataProvider'=>$dataProvider,'searchModel' => $employedBeneficiary,'model'=>$model,
        ]);    
    }
	public function actionLoaneesInLoanSummary($employerID)
    {
        $this->layout="default_main";        
        $searchModel = new EmployedBeneficiarySearch();
        $dataProvider = $searchModel->verified_beneficiaries(Yii::$app->request->queryParams,$employerID);
        return $this->render('loaneesInLoanSummary', [
                    'dataProvider'=>$dataProvider,'searchModel' => $searchModel,
        ]);    
    }
    public function actionBillPrepationLoanee($loan_summary_id)
    {
        $this->layout="main_private";
        $model = new LoanSummary();
        $employedBeneficiary = new EmployedBeneficiary();
        return $this->render('billPrepationLoanee', [
                    'loan_summary_id' => $loan_summary_id,'model'=>$model,'searchModel' => $employedBeneficiary,
        ]);    
    }

    /**
     * Creates a new LoanSummary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LoanSummary();
        $model2 = new LoanSummaryDetail();
        //$model3 = new EmployedBeneficiary();
        if ($model->load(Yii::$app->request->post())) {
		$model->amount = str_replace(",", "", $model->amountx);
        $model->created_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        $employerID=$model->employer_id;
        $model->vrf_accumulated=0.00;
        $model->vrf_last_date_calculated=$model->created_at;
        }
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $loan_summary_id=$model->loan_summary_id;            
            $model2->insertAllBeneficiariesUnderBill($employerID,$loan_summary_id);
            $model->updateEmployerBillReply($employerID);
            $model->updateCeasedBill($employerID);
			$Recent_loan_summary_id=$model->loan_summary_id;
			$model->updateCeasedAllPreviousActiveBillUnderEmployer($employerID,$Recent_loan_summary_id);
            $sms = '<p>Loan approved! </p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionRequestBillEmployer($employerID)
    {
        $this->layout="main_private";
        $model = new LoanSummary();
        //$employer = new EmployerSearch();
        $dateRequested=date("Y-m-d H:i:s");
        $model->updateEmployerBillRequestStatus($employerID,$dateRequested);
            $sms = '<p>Your request has been sent, You will receive response shortly,</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
      }

    /**
     * Updates an existing LoanSummary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_summary_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLoaneeVerifyandApproveBill()
    {
        $this->layout="main_private";
        $model = new LoanSummary();
        $model2 = new LoanSummaryDetail();
        if ($model->load(Yii::$app->request->post())) {
		$model->amount = str_replace(",", "", $model->amountx);
        $loan_summary_id=$model->Bill_Ref_No;        
        $applicantID=$model->applicant_id;
        $bill_status=$model->status;
        $created_at=date("Y-m-d H:i:s");
        $description=$model->description;
        $vrf_accumulated=0;
        $amount=$model->amount;
        //echo $loan_summary_id;
        //exit;
        $vrf_last_date_calculated=date("Y-m-d");
        $model->updateLoaneeBill1($loan_summary_id,$bill_status,$created_at,$description,$vrf_accumulated,$amount,$vrf_last_date_calculated);
        $model2->insertLoaneeBillDetail($applicantID,$loan_summary_id);        
        
         $sms = '<p>Loan approved! </p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        }else{           
             return $this->redirect(['billPrepationLoanee']);
        }
    }

    /**
     * Deletes an existing LoanSummary model.
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
     * Finds the LoanSummary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanSummary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanSummary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionEmployerWaitingBillTerminatedAdditionalEmployee()
    {
        $LoanSummaryModel = new LoanSummarySearch();
        $dataProvider1 = $LoanSummaryModel->searchNewBill2(Yii::$app->request->queryParams);
        return $this->render('employerWaitingBill', [
            'searchModel' => $LoanSummaryModel,
            'dataProvider' => $dataProvider1,
        ]);
    }
    public function actionLoaneeWaitingBill()
    {
        $LoanSummaryModel = new LoanSummarySearch();
        $dataProvider1 = $LoanSummaryModel->searchNewBillLoanee(Yii::$app->request->queryParams);
        return $this->render('loaneeWaitingBill', [
            'searchModel' => $LoanSummaryModel,
            'dataProvider' => $dataProvider1,
        ]);
    }
	public function actionFullPaidbeneficiary()
    {
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
        $user_loged_in=Yii::$app->user->identity->login_type;
        $searchModel = new \frontend\modules\repayment\models\LoanSummaryDetailSearch();
		$searchLoanRepayment = new \frontend\modules\repayment\models\LoanRepaymentSearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		$is_fullPaid=0;
        //$dataProvider = $searchModel->getBillUnderEmployerScholarShip(Yii::$app->request->queryParams,$employerID,$is_fullPaid);
		//$dataProviderBill=$searchLoanRepayment->searchPaymentsForSpecificEmployer(Yii::$app->request->queryParams,$employerID);
		//echo $results1q;
        return $this->render('fullRepaidBeneficiary', [
            //'searchModel' => $searchModel,
           // 'dataProvider' => $dataProvider,
			//'searchModelBill' => $searchLoanRepayment,
            //'dataProviderBill' => $dataProviderBill,
        ]);
    }
	public function actionFullPaidstudentloan()
    {
		$this->layout="default_main";		
		$loan_given_tostudents=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
        $searchModel = new \backend\modules\repayment\models\LoanSearch();
		$is_fullPaid=0;
        $dataProvider = $searchModel->Loansearch(Yii::$app->request->queryParams,$loan_given_tostudents);
		//echo $results1q;
        return $this->render('fullPaidstudentloan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionFullPaidemployerloan()
    {	
		$this->layout="default_main";		
		$loan_given_toemployer=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
        $searchModel = new \backend\modules\repayment\models\LoanSearch();
		$is_fullPaid=0;
        $dataProvider = $searchModel->Loansearch(Yii::$app->request->queryParams,$loan_given_toemployer);
		//echo $results1q;
        return $this->render('fullPaidemployerloan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
