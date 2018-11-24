<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\EmployerPenaltyPayment;
use frontend\modules\repayment\models\EmployerPenaltyPaymentSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployerSearch;

/**
 * EmployerPenaltyPaymentController implements the CRUD actions for EmployerPenaltyPayment model.
 */
class EmployerPenaltyPaymentController extends Controller
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
     * Lists all EmployerPenaltyPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
	    $model = new EmployerPenaltyPayment();
        $searchModel = new EmployerPenaltyPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			//'model' => $model,
        ]);
    }
	
	public function actionPenaltyPaymentsView()
    {
	     $this->layout="default_main";
        $searchModel = new EmployerPenaltyPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('penaltyPaymentsView', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployerPenaltyPayment model.
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
     * Creates a new EmployerPenaltyPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmployerPenaltyPayment();
        $employerModel = new EmployerSearch();
		$loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
		$employer_id=$employer2->employer_id;
        if ($model->load(Yii::$app->request->post())) {	
        $countResults=\frontend\modules\repayment\models\EmployerPenaltyPayment::find()
			->where(['employer_id'=>$employer_id])
			->andWhere(['or',
           ['payment_status'=>NULL],
           ['payment_status'=>''],
		   ])->one();
		   
		   if(count($countResults) > 0){
			$employer_penalty_payment_id=$countResults->employer_penalty_payment_id;
            $newAmount=\frontend\modules\repayment\models\EmployerPenaltyPayment::findOne($employer_penalty_payment_id);
            $newAmount->payment_status=0;
            $newAmount->save();
            $finalemployer_penalty_payment_id=$employer_penalty_payment_id;			
		   }else{
			$couuntEmployerBillPNT=\frontend\modules\repayment\models\EmployerPenaltyPayment::find()->where(['employer_id'=>$employer_id])->count();	
			$model->payment_date=date("Y-m-d");
			$model->created_at=date("Y-m-d H:i:s");
			$controlNumber=mt_rand (100,1000);
			$newBiLLCount=$couuntEmployerBillPNT +1;
			$model->bill_number=$employer_id."EPNT".$newBiLLCount;
			$model->control_number=$controlNumber;
			$model->date_control_requested=date("Y-m-d H:i:s");
			$model->date_control_received =date("Y-m-d H:i:s");
			//$model->pay_method_id=4;
			$model->payment_status=0;		
			$model->employer_id = $employer2->employer_id;	
			$model->save();
            $finalemployer_penalty_payment_id=$model->employer_penalty_payment_id;		
		   }
		
		    $sms="Kindly use the below control number for payment!";
           Yii::$app->getSession()->setFlash('success', $sms);
           return $this->redirect(['view', 'id' =>$finalemployer_penalty_payment_id]);
            //return $this->redirect(['create']);
			
        } else {
            return $this->render('create', [
                'model' => $model,'employerID'=>$employer2->employer_id
            ]);
        }
    }

    /**
     * Updates an existing EmployerPenaltyPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_penalty_payment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmployerPenaltyPayment model.
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
     * Finds the EmployerPenaltyPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployerPenaltyPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployerPenaltyPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionAdjustAmountPenalty()
    {
	    $this->layout="default_main";
		$employerModel = new EmployerSearch();
        $model = new EmployerPenaltyPayment();
        $model->scenario='employer_penalty_payment';		
		$loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employer_id=$employer2->employer_id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {			
			$countResults=\frontend\modules\repayment\models\EmployerPenaltyPayment::find()
			->where(['employer_id'=>$employer_id])
			->andWhere(['or',
           ['payment_status'=>NULL],
           ['payment_status'=>''],
        ])->one();
			if(count($countResults) > 0){
			$employer_penalty_payment_id=$countResults->employer_penalty_payment_id;
            $totalamount=$model->amount;
            $newAmount=\frontend\modules\repayment\models\EmployerPenaltyPayment::findOne($employer_penalty_payment_id);
            $newAmount->amount= $totalamount;
            $newAmount->save();			
			}else{
			$couuntEmployerBillPNT=\frontend\modules\repayment\models\EmployerPenaltyPayment::find()->where(['employer_id'=>$employer_id])->count();	
			$model->payment_date=date("Y-m-d");
			$model->created_at=date("Y-m-d H:i:s");
			$controlNumber=mt_rand (100,1000);
			$newBiLLCount=$couuntEmployerBillPNT +1;
			$model->bill_number=$employer_id."EPNT".$newBiLLCount;
			$model->control_number=$controlNumber;
			$model->date_control_requested=date("Y-m-d H:i:s");
			$model->date_control_received =date("Y-m-d H:i:s");
			//$model->pay_method_id=4;
			//$model->payment_status=0;		
			$model->employer_id = $employer2->employer_id;	
			$model->save();
			}
           $sms="Amount successful adjusted, Kindly confirm payment!";
           Yii::$app->getSession()->setFlash('success', $sms);			
		return $this->redirect(['create']);
		} else {
            return $this->render('adjustAmountPenalty', [
                'model' => $model,
            ]);
        }
    }
}
