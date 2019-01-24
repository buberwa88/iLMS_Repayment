<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\GepgBillProcessingSetting;
use backend\modules\repayment\models\GepgBillProcessingSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GepgBillProcessingSettingController implements the CRUD actions for GepgBillProcessingSetting model.
 */
class GepgBillProcessingSettingController extends Controller
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
     * Lists all GepgBillProcessingSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$control_number=null,$bill_number=null,$date_control_received=null
        //echo $control_number."<br/>".$bill_number."<br/>".$date_control_received;exit;
        $searchModel = new GepgBillProcessingSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GepgBillProcessingSetting model.
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
     * Creates a new GepgBillProcessingSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GepgBillProcessingSetting();
        $model->created_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$sms = '<p>Information Successful Updated.</p>';
            //Yii::$app->getSession()->setFlash('success', $sms);
            ###########GePG Important part############
            //$billNumber='RPEMP88888';
            //$control_number='647474647474';
            //$billPrefix = substr($billNumber, 0, 5);
            //$date_control_received=date("Y-m-d H:i:s");
            //$operationType=\backend\modules\repayment\models\GepgBillProcessingSetting::RECEIVE_CONTROL_NO;
            //$results_url=\backend\modules\repayment\models\GepgBillProcessingSetting::getBillPrefix($billPrefix,$operationType);
            //return $this->redirect(['index']);
            $sms = '<p>Information Successful Updated.</p>';
            //$sms = $results_url->bill_processing_uri;
            Yii::$app->getSession()->setFlash('success', $sms);
            //return $this->redirect([$results_url->bill_processing_uri,'control_number'=>$control_number,'bill_number'=>$billNumber,'date_control_received'=>$date_control_received]);
            return $this->redirect(['index']);
            ###########end GePG important part#############
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GepgBillProcessingSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_by=Yii::$app->user->identity->user_id;
        $model->updated_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GepgBillProcessingSetting model.
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
     * Finds the GepgBillProcessingSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GepgBillProcessingSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GepgBillProcessingSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
