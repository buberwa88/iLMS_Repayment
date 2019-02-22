<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\LoanRepaymentPrepaid;
use frontend\modules\repayment\models\LoanRepaymentPrepaidSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\LoanSummary;
use frontend\modules\repayment\models\EmployerSearch;

/**
 * LoanRepaymentPrepaidController implements the CRUD actions for LoanRepaymentPrepaid model.
 */
class LoanRepaymentPrepaidController extends Controller
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
     * Lists all LoanRepaymentPrepaid models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoanRepaymentPrepaidSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanRepaymentPrepaid model.
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
     * Creates a new LoanRepaymentPrepaid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LoanRepaymentPrepaid();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->prepaid_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LoanRepaymentPrepaid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->prepaid_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanRepaymentPrepaid model.
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
     * Finds the LoanRepaymentPrepaid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanRepaymentPrepaid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanRepaymentPrepaid::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
		public function actionPrepaid()
    {
        $modelLoanSummary = new LoanSummary();
		$modelLoanRepaymentPrepaid = new LoanRepaymentPrepaid();
		$searchModelLoanRepaymentPrepaid = new LoanRepaymentPrepaidSearch();
        $employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
        $modelLoanRepaymentPrepaid->employer_id=$employerID;
		$modelLoanRepaymentPrepaid->scenario='prepaid_posting';
        if ($modelLoanRepaymentPrepaid->load(Yii::$app->request->post())) {
		$modelLoanRepaymentPrepaid->employer_id=$employerID;
        $created_by=$loggedin;
		$created_at=date("Y-m-d H:i:s");
		$payment_date=$modelLoanRepaymentPrepaid->payment_date;
		$totalMonths=$modelLoanRepaymentPrepaid->totalMonths;
		$loanSummary=\frontend\modules\repayment\models\LoanSummary::find()->where(['employer_id'=>$employerID])->orderBy(['loan_summary_id'=>SORT_DESC])->one();
		$loan_summary_id=$loanSummary->loan_summary_id;
		$countEmployerBillPREP=\frontend\modules\repayment\models\LoanRepaymentPrepaid::find()->where(['employer_id'=>$employerID])->groupBy('bill_number')->count();
		$newBill=$countEmployerBillPREP + 1;
        $repaymnet_reference_number=$employer2->employer_code."-PREP".$newBill;	
        $bill_number=$repaymnet_reference_number;
		//save
		\frontend\modules\repayment\models\LoanRepayment::getAmountRequiredForMonthlyRepaymentBeneficiary($employerID,$loan_summary_id,$bill_number,$created_by,$payment_date,$totalMonths,$created_at);
	    $sms="Kindldy Confirm the total amount and beneficiaries under pre-paid posted for payment";
        Yii::$app->getSession()->setFlash('success', $sms);		
		return $this->redirect(['prepaid']);
        }
        $dataProvider = $searchModelLoanRepaymentPrepaid->searchPrepaid(Yii::$app->request->queryParams);		
        return $this->render('prepaid', [
            'model' => $modelLoanRepaymentPrepaid,'searchModel' => $searchModelLoanRepaymentPrepaid,'dataProvider'=>$dataProvider,
            
        ]);
		
    }
	public function actionCancelPrepaid($bill_number)
    {
		$modelLoanRepaymentPrepaid = new LoanRepaymentPrepaid();
		$employerModel = new EmployerSearch();
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		$modelLoanRepaymentPrepaid->deleteAll(['bill_number'=>$bill_number,'employer_id'=>$employerID,'payment_status'=>null]);
	    $sms="Pre-paid Cancelled";
        Yii::$app->getSession()->setFlash('success', $sms);		
		return $this->redirect(['prepaid']);
    }
	public function actionConfirmPaymentprepaid()
    {    
	    $model = new LoanRepaymentPrepaid();        
		$employerModel = new EmployerSearch();
		$loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
		$searchModelLoanRepaymentPrepaid = new LoanRepaymentPrepaidSearch();
		$dataProvider = $searchModelLoanRepaymentPrepaid->searchPrepaid(Yii::$app->request->queryParams);
		if ($model->load(Yii::$app->request->post())) {
            $controlNumber=mt_rand (1000,100000);
			$bill_number=$model->bill_number;
			$model->updateConfirmPaymentandControlNoprepaidbill($bill_number,$controlNumber,$employerID);
            $sms="Bill successful confirmed!";  
           Yii::$app->getSession()->setFlash('success', $sms);
           return $this->redirect(['prepaid']);     
		}else {
            return $this->render('prepaid', [
                'model' =>$model,'searchModel' => $searchModelLoanRepaymentPrepaid,'dataProvider'=>$dataProvider,
            ]);
        }
    }
}
