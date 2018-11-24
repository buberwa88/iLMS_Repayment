<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\Disbursement;
use backend\modules\disbursement\models\DisbursementSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * DisbursementController implements the CRUD actions for Disbursement model.
 */
class DisbursementController extends Controller
{
    /**
     * @inheritdoc
     */
     public $layout = "main_private";
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
     * Lists all Disbursement models.
     * @return mixed
     */
    public function actionIndex()
    {
         
        $searchModel = new DisbursementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDisbursed($id)
    {
         $this->layout="default_main"; 
        $searchModel = new DisbursementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('disbursed_list', [
            'searchModel' => $searchModel,
            'id'=>$id,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionMydisbursement($id)
    {
         $this->layout="default_main"; 
        $searchModel = new DisbursementSearch();
        $dataProvider = $searchModel->searchmy(Yii::$app->request->queryParams,$id);

        return $this->render('mydisbursement', [
            'searchModel' => $searchModel,
            'id'=>$id,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Disbursement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $this->layout="default_main"; 
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Disbursement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Disbursement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursement_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id'=>$id
            ]);
        }
    }

    /**
     * Updates an existing Disbursement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
            $this->layout="default_main"; 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                  
            return $this->redirect(['view', 'id' => $model->disbursement_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Disbursement model.
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
     * Finds the Disbursement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Disbursement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Disbursement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
