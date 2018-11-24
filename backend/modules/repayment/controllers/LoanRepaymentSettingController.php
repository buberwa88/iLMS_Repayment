<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\LoanRepaymentSetting;
use backend\modules\repayment\models\LoanRepaymentSettingSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoanRepaymentSettingController implements the CRUD actions for LoanRepaymentSetting model.
 */
class LoanRepaymentSettingController extends Controller
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
     * Lists all LoanRepaymentSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoanRepaymentSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanRepaymentSetting model.
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
     * Creates a new LoanRepaymentSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LoanRepaymentSetting();
        $model->created_at=date("Y-m-d");
        $model->created_by=\Yii::$app->user->identity->user_id;
		//$model->start_date=date("Y-m-d");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		$loan_repayment_item_id=$model->loan_repayment_item_id;
		$loan_repayment_setting_id=$model->loan_repayment_setting_id;
		//$model->updateOldRepaymentItemSettings($loan_repayment_item_id,$loan_repayment_setting_id);
		    $sms = '<p>Information Successful Added.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    

    /**
     * Updates an existing LoanRepaymentSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		           $sms = '<p>Information Successful Updated.</p>';
                   Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanRepaymentSetting model.
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
     * Finds the LoanRepaymentSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanRepaymentSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanRepaymentSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionRepaymentItemtype($loan_repayment_item_value)
    {
		
		 //\backend\modules\application\models\Application::findOne(['application_id'=>$application_id]);
         $repayment_item_value=\backend\modules\repayment\models\LoanRepaymentItem::findOne(['loan_repayment_item_id'=>$loan_repayment_item_value]);
         if($repayment_item_value->item_code=='VRF'){
		 $itemCategory=1;
		 }else{
		 $itemCategory='';
		 }		 
        return $itemCategory;
    }
}
