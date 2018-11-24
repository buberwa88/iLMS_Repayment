<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\DisbursementSetting;
use backend\modules\disbursement\models\DisbursementSettingSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DisbursementSettingController implements the CRUD actions for DisbursementSetting model.
 */
class DisbursementSettingController extends Controller
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
     * Lists all DisbursementSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new DisbursementSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DisbursementSetting model.
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
     * Creates a new DisbursementSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
     
        $model = new DisbursementSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Created!'
                        );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DisbursementSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully updated!'
                        );
            return $this->redirect(['update', 'id' => $model->disbursement_setting_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DisbursementSetting model.
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
     * Finds the DisbursementSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DisbursementSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DisbursementSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
