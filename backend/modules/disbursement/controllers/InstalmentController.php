<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\Instalment;
use backend\modules\disbursement\models\InstalmentSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * InstalmentController implements the CRUD actions for Instalment model.
 */
class InstalmentController extends Controller
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
     * Lists all Instalment models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new InstalmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Instalment model.
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
     * Creates a new Instalment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    
        $model = new Instalment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfuly Created!'
                        );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Instalment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfuly Updated!'
                        );
            return $this->redirect(['update', 'id' => $model->instalment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Instalment model.
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
     * Finds the Instalment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Instalment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Instalment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
