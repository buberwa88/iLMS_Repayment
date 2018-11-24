<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\DisbursementSchedule;
use backend\modules\disbursement\models\DisbursementScheduleSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * DisbursementScheduleController implements the CRUD actions for DisbursementSchedule model.
 */
class DisbursementScheduleController extends Controller {

    /**
     * @inheritdoc
     */
    public $layout = "main_private";

    public function behaviors() {
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
     * Lists all DisbursementSchedule models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DisbursementScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DisbursementSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DisbursementSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new DisbursementSchedule();
        // $model1 = new \backend\modules\disbursement\models\DisbursementTaskAssignment();
        if ($model->load(Yii::$app->request->post())) {
            //check if exist
            $checkexitdata = 0;
            if ($model->from_amount != "" && $model->to_amount != "") {
                $sqlall = "SELECT * FROM disbursement_schedule WHERE operator_name='Between' AND from_amount<='{$model->from_amount}' AND to_amount>='{$model->to_amount}'";
                $modelp = Yii::$app->db->createCommand($sqlall)->queryAll();
                if (count($modelp) == 0) {
                    $checkexitdata = 1;
                }
            } else {
                $sqlall = "SELECT * FROM disbursement_schedule WHERE from_amount<='{$model->from_amount}' AND to_amount>='{$model->from_amount}'";
                $modelp = Yii::$app->db->createCommand($sqlall)->queryAll();
                if (count($modelp) == 0) {
                    $checkexit = DisbursementSchedule::find()->where(['operator_name' => 'Greater than'])->all();
                    if (count($checkexit) == 0) {
                        $checkexitdata = 1;
                    }
                }
            }
            //end
            if ($checkexitdata == 1) {
                $model->save();
                Yii::$app->getSession()->setFlash(
                        'success', 'Data Successfully saved!'
                );
            } else {
                Yii::$app->getSession()->setFlash(
                        'warning', 'Data already exist!'
                );
            }
            return $this->redirect(['index', 'id' => $model->disbursement_schedule_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                            // 'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DisbursementSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursement_schedule_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DisbursementSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DisbursementSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DisbursementSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = DisbursementSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
