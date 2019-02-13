<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\Refund;
use backend\modules\repayment\models\RefundSearch;
use yii\web\Controller;
//use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefundController implements the CRUD actions for Refund model.
 */
class RefundController extends Controller
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
     * Lists all Refund models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Refund model.
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
     * Creates a new Refund model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Refund();
        //$model1->scenario = 'employer_details';        
        if ($model->load(Yii::$app->request->post())) {
		$model->created_at=date("Y-m-d H:i:s");  
		$model->created_by=Yii::$app->user->identity->user_id;	
}		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    $sms = "Claim successful added";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['loan-beneficiary/view-loanee-details-refund', 'id' =>$id]);
			
        } else {
            return $this->render('create', [
                'model' => $model,'applicantID'=>$id,'upID'=>'0',
            ]);
        }
    }

    /**
     * Updates an existing Refund model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    $sms = "Claim successful updated";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view', 'id' => $model->refund_id]);
        } else {
            return $this->render('update', [
                'model' => $model,'applicantID'=>$model->applicant_id,'upID'=>'1',
            ]);
        }
    }

    /**
     * Deletes an existing Refund model.
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
     * Finds the Refund model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Refund the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Refund::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionViewRefund($id)
    {
	    $this->layout="default_main";
        return $this->render('viewRefund', [
            'model' => $this->findModel($id),
        ]);
    }
	public function actionRefundClaim($claim_category_value)
    {
         $this->layout="default_main";
         if($claim_category_value==1){
		 $claim_category=1;
		 }else if($claim_category_value==2){
		 $claim_category=2;
		 }else{
		 $claim_category='';
		 }
        return $claim_category;
    }
	public function actionApplicantName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $applicantId = $parents[0];
                $out = Refund::getApplicantName($applicantId);
                echo \yii\helpers\Json::encode(['output' => $out]);
                return;
            }
        }
    }
	public function actionRefundClaim2($claim_category_value)
    {
		 $this->layout="default_main";
		 //\backend\modules\application\models\Application::findOne(['application_id'=>$application_id]);
         $claim_category_value=\backend\modules\repayment\models\Refund::findOne(['refund_id'=>$claim_category_value]);
         if($claim_category_value->refund_id==1){
		 $claim_category=1;
		 }else if($claim_category_value->refund_id==2){
		 $claim_category=2;
		 }else{
		 $claim_category='';
		 }
        return $claim_category;
    }
}
