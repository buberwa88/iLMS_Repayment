<?php

namespace frontend\modules\repayment\controllers;

use Yii;

use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\LoanRepaymentSearch;
use frontend\modules\repayment\models\EmployerSearch;
use frontend\modules\repayment\models\LoanSummary;
use frontend\modules\repayment\models\LoanRepaymentDetailSearch;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use frontend\modules\repayment\models\TreasuryPayment;
use frontend\modules\repayment\models\TreasuryPaymentSearch;
use frontend\modules\repayment\models\TreasuryPaymentDetail;
use frontend\modules\repayment\models\TreasuryPaymentDetailSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TreasuryPaymentController implements the CRUD actions for TreasuryPayment model.
 */
class TreasuryPaymentController extends Controller
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
     * Lists all TreasuryPayment models.
     * @return mixed
     */
	 /*
    public function actionIndex()
    {
        $searchModel = new TreasuryPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	*/
	
	 public function actionIndex()
    {
	    /*
        $searchModel = new TreasuryPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		*/
		

        $model = new TreasuryPayment();
        $searchModel = new TreasuryPaymentSearch();

        $loggedin=Yii::$app->user->identity->user_id;        
		
		$resultsAfterCheck=$model->checkUnCompleteBillTreasury();
		if($resultsAfterCheck !=0){
        $treasury_payment_id=$resultsAfterCheck->treasury_payment_id;
		}else{
		$treasury_payment_id=0;
		}
		
        $results1=$model->checkControlNumberStatus();
			$results_bill_number=(count($results1) == 0) ? '0' : $results1->treasury_payment_id;
		$EmployersBillPending=$model->checkBillPendingGovernmentEmployers();
        if($results_bill_number ==0 && $EmployersBillPending !=0){
			return $this->redirect(['generate-bill']);
			}
		$dataProviderBills=$searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderBills' => $dataProviderBills,'treasury_payment_id'=>$treasury_payment_id
        ]);
    }

    /**
     * Displays a single TreasuryPayment model.
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
     * Creates a new TreasuryPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TreasuryPayment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->treasury_payment_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TreasuryPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->treasury_payment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TreasuryPayment model.
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
     * Finds the TreasuryPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TreasuryPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TreasuryPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionGenerateBill()
    {
        $searchModel = new TreasuryPaymentDetailSearch();
        $model2 = new TreasuryPayment();
		$searchLoanRepayment = new TreasuryPaymentSearch();
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
            $repaymnet_reference_number="T".date("Y")."-".$model2->treasury_payment_id;
            $treasury_payment_id=$model2->treasury_payment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            
            $searchModel->insertAllGovernmentEmployersBill($treasury_payment_id);
            $totalAmount1=$model2->getAmountRequiredForPayment($treasury_payment_id);
            $model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$treasury_payment_id);			
			return $this->redirect(['confirm-payment', 'id' => $model2->treasury_payment_id]);            
        }
        //end requesting number
        
        }
        $dataProviderBills=$searchLoanRepayment->search(Yii::$app->request->queryParams);		
        return $this->render('generateBill', [
            'model' => $model2,'dataProviderBills'=>$dataProviderBills,'searchLoanRepayment' => $searchLoanRepayment,
            
        ]);
		
    }
	
	public function actionConfirmPayment($id)
    {    
	    $model = $this->findModel($id);
		$treasury_payment_id=$id;
        //$model2 = new LoanRepayment();
        $searchModel = new TreasuryPaymentDetailSearch();
		if ($model->load(Yii::$app->request->post())) {
		if($model->save()){
        
        if($treasury_payment_id >0){
            //requesting control number
            //this is for temporaly test
            $controlNumber=mt_rand (10,100);
            //end for temporaly test
          //end
            $model->updateConfirmPaymentandControlNo($treasury_payment_id,$controlNumber);
        //end requesting number
		
		   $sms="Kindly use the below control number for payment!";
           Yii::$app->getSession()->setFlash('success', $sms);
           return $this->redirect(['viewconfirmed-payment', 'id' => $model->treasury_payment_id]);
        }
		}
		}else {
            return $this->render('confirmPayment', [
                'model' => $model,
            ]);
        }
    }
	public function actionViewconfirmedPayment($id)
    {
	    //$this->layout="main_private";
        return $this->render('viewconfirmedPayment', [
            'model' => $this->findModel($id),
        ]);
    }
     public function actionReceipt()
    {
        $model = new TreasuryPayment();
        $searchModel = new TreasuryPaymentSearch();
        $loggedin=Yii::$app->user->identity->user_id;        
		$dataProviderBills=$searchModel->search(Yii::$app->request->queryParams);
        return $this->render('receipt', [
            'searchModel' => $searchModel,
            'dataProviderBills' => $dataProviderBills
        ]);
    }
}
