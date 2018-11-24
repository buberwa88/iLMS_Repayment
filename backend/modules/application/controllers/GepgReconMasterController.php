<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\GepgReconMaster;
use backend\modules\application\models\GepgReconMasterSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\modules\application\rabbit\Producer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * GepgReconMasterController implements the CRUD actions for GepgReconMaster model.
 */
class GepgReconMasterController extends Controller
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
     * Lists all GepgReconMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GepgReconMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GepgReconMaster model.
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
     * Creates a new GepgReconMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GepgReconMaster();
        $model->created_at=date("Y-m-d H:i:s");
		$model->created_by=Yii::$app->user->identity->user_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {


//take reconciliation request in queue
		$recoID=$model->recon_master_id;
		$query1 = " SELECT * FROM gepg_recon_master WHERE  recon_master_id='".$recoID."'";
        $Result1 = Yii::$app->db->createCommand($query1)->queryOne();
               
			$reconMasterID = $Result1['recon_master_id'];
			$SpReconcReqId = $reconMasterID;
			$SpCode='SP111';
			$SpSysId='LHESLB001';
			$TnxDt=$Result1['recon_date'];
			$ReconcOpt='1';
            			//echo $SpReconcReqId;
			$dataToQueue = ["SpReconcReqId" => $SpReconcReqId, 
                                     "SpCode"=>$SpCode, 
                                     "SpSysId"=>$SpSysId, 
                                     "TnxDt"=>$TnxDt, 
                                      "ReconcOpt"=>$ReconcOpt];
            if($reconMasterID > 0){
            Producer::queue("GePGReconciliationRequestQueue", $dataToQueue);
			}
		//end take reconciliation request in queue

		    $sms = '<p>Reconciliation Successful created.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GepgReconMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->recon_master_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GepgReconMaster model.
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
     * Finds the GepgReconMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GepgReconMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GepgReconMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
