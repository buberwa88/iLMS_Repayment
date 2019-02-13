<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\PayMethod;
use backend\modules\repayment\models\PayMethodSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayMethodController implements the CRUD actions for PayMethod model.
 */
class PayMethodController extends Controller
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
     * Lists all PayMethod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayMethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayMethod model.
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
     * Creates a new PayMethod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayMethod();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Updates an existing PayMethod model.
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
		if (Yii::$app->request->isAjax) {
        return $this->renderAjax('update', [
            'model' => $this->findModel($id),
        ]);
    }else{
            return $this->render('update', [
                'model' => $model,
            ]);
			}
        }
    }

    /**
     * Deletes an existing PayMethod model.
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
     * Finds the PayMethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayMethod::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
