<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\DisbursementUserStructure;
use backend\modules\disbursement\models\DisbursementUserStructureSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * DisbursementUserStructureController implements the CRUD actions for DisbursementUserStructure model.
 */
class DisbursementUserStructureController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all DisbursementUserStructure models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisbursementUserStructureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DisbursementUserStructure model.
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
     * Creates a new DisbursementUserStructure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DisbursementUserStructure();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Created!'
                        );
            return $this->redirect(['view', 'id' => $model->disbursement_user_structure_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DisbursementUserStructure model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Updated!'
                        );
            return $this->redirect(['view', 'id' => $model->disbursement_user_structure_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DisbursementUserStructure model.
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
     * Finds the DisbursementUserStructure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DisbursementUserStructure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DisbursementUserStructure::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
