<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\GepgBill;
use backend\modules\application\models\GepgBillSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\application\rabbit\Producer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * GepgBillController implements the CRUD actions for GepgBill model.
 */
class GepgBillController extends Controller
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
     * Lists all GepgBill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GepgBillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GepgBill model.
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
     * Creates a new GepgBill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GepgBill();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GepgBill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
	 /*
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	*/
	
	public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->scenario = 'Cancell_bill';

        if ($model->load(Yii::$app->request->post())){
        $model->status=1;
        }
		if($model->load(Yii::$app->request->post()) && $model->save()) {
         //return $this->redirect(['view', 'id' => $model->id]);

         //take cancelled bill in queue
		    $reconMasterID=$model->id;
			$BillId1 = $model->bill_number;
			$SpCode='SP111';
			$SpSysId='LHESLB001';
            			//echo $SpReconcReqId;
			$dataToQueue = ["SpCode" => $SpCode, 
                                     "SpSysId"=>$SpSysId, 
                                     "BillId1"=>$BillId1]; 
                                     
            if($reconMasterID >0){
            Producer::queue("GePGBillCancellationRequestQueue", $dataToQueue);
			
			$query3 = "UPDATE gepg_bill SET cancel_requsted_status='0' WHERE id='".$reconMasterID."'";
             Yii::$app->db->createCommand($query3)->execute();
			 }
		//end take cancelled bill in queue

          return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GepgBill model.
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
     * Finds the GepgBill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GepgBill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GepgBill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
