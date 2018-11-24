<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\LoanSummary;
use frontend\modules\repayment\models\LoanSummaryDetail;
use frontend\modules\repayment\models\LoanSummarySearch;
use frontend\modules\repayment\models\EmployerSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployedBeneficiarySearch;
use frontend\modules\repayment\models\LoanSummaryDetailSearch;



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
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $searchModel = new LoanSummarySearch();
        $employerModel = new EmployerSearch();
        $LoanSummaryModel = new LoanSummary();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider = $searchModel->getBillUnderEmployer(Yii::$app->request->queryParams,$employerID);
        $LoanSummaryModel->getActiveBillToUpdateVRFofEmployees($employerID);
		//echo $results1q;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionIndexNotfication()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $searchModel = new LoanSummarySearch();
        $employerModel = new EmployerSearch();
        $LoanSummaryModel = new LoanSummary();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $dataProvider = $searchModel->getBillUnderEmployer(Yii::$app->request->queryParams,$employerID);
        $LoanSummaryModel->getActiveBillToUpdateVRFofEmployees($employerID);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $searchModel = new LoanSummarySearch();
        $employerModel = new EmployerSearch();
        $LoanSummaryModel = new LoanSummary();
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $dataProvider = $searchModel->getBillLoanee(Yii::$app->request->queryParams,$applicantID);

		$checkactiveLoansummaryavailable_beneficiary=$LoanSummaryModel->getActiveLoanSummaryforbeneficiary($applicantID);
        return $this->render('indexBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'applicantID' => $applicantID,
			'loanSummaryExist'=>$checkactiveLoansummaryavailable_beneficiary,
        ]);
    }
	
	public function actionIndexBeneficiarynotification()
    {
        $user_loged_in=Yii::$app->user->identity->login_type;
        if($user_loged_in==5){
           $this->layout="main_private"; 
        }else if($user_loged_in==1){
           $this->layout="main_private_beneficiary"; 
        }
        $searchModel = new LoanSummarySearch();
        $employerModel = new EmployerSearch();
        $LoanSummaryModel = new LoanSummary();
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $dataProvider = $searchModel->getBillLoanee(Yii::$app->request->queryParams,$applicantID);

		$checkactiveLoansummaryavailable_beneficiary=$LoanSummaryModel->getActiveLoanSummaryforbeneficiary($applicantID);
        return $this->render('indexBeneficiary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'applicantID' => $applicantID,
			'loanSummaryExist'=>$checkactiveLoansummaryavailable_beneficiary,
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
    
    public function actionBillPrepation($employerID)
    {
        $this->layout="main_private";
        
        $searchModel = new EmployedBeneficiarySearch();
        $model = new LoanSummary();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('billPrepation', [
                    'employer_id' => $employerID,'dataProvider'=>$dataProvider,'searchModel' => $searchModel,'model'=>$model,
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
        $model->created_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        $employerID=$model->employer_id;
        }
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $loan_summary_id=$model->loan_summary_id;            
            $model2->insertAllBeneficiariesUnderBill($employerID,$loan_summary_id);
            $model->updateEmployerBillReply($employerID);
            $sms = '<p>Bill sent! </p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['employer-bill-request-pending']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionCreateBillRequestApplicant()
    {
        $this->layout="main_private_beneficiary";
        $model = new LoanSummary();
        $employerModel = new EmployerSearch();
        //$model3 = new EmployedBeneficiary();
        //if ($model->load(Yii::$app->request->post())) {
        $created_by=Yii::$app->user->identity->user_id;
        $created_at=date("Y-m-d H:i:s");
        $bill_status=7;
        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=$employerModel->getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        $amount=0;
        $billNum=$model->getLastBillIDApplicant($applicantID);
        $bill_number="BEN".$applicantID."-".date("Y")."-".$billNum;
        
        $model->insertBillRequestApplicant($bill_status,$applicantID,$bill_number,$created_by,$created_at,$amount);
        //}
        

        if ($applicantID !='') {           
            //$model2->insertAllBeneficiariesUnderBill($employerID,$loan_summary_id);
            //$model->updateEmployerBillReply($employerID);
            $sms = '<p>Loan summary request sent! </p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index-beneficiary']);
        } else {
            $sms = '<p>Bill request fail! </p>';
            Yii::$app->getSession()->setFlash('error', $sms);
            return $this->redirect(['index-beneficiary']);
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
	
}
