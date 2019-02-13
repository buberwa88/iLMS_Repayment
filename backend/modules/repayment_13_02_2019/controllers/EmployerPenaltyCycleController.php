<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\EmployerPenaltyCycle;
use backend\modules\repayment\models\EmployerPenaltyCycleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployerPenaltyCycleController implements the CRUD actions for EmployerPenaltyCycle model.
 */
class EmployerPenaltyCycleController extends Controller {

    public $layout = "main_private";

    /**
     * @inheritdoc
     */
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
     * Lists all EmployerPenaltyCycle models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EmployerPenaltyCycleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployerPenaltyCycle model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmployerPenaltyCycle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new EmployerPenaltyCycle();
        $model->created_by = \Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s', time());
        //setting config type
        $model->cycle_type = EmployerPenaltyCycle::REPAYMENT_CYCLE_GENERAL;
        if (!empty($model->employer_id) && is_int($model->employer_id)) {
            $model->cycle_type = EmployerPenaltyCycle::REPAYMENT_CYCLE_EMPLOYER;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_penalty_cycle_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmployerPenaltyCycle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->updated_by = \Yii::$app->user->id;
        $model->updated_at = date('Y-m-d H:i:s', time());
        //setting config type
        $model->cycle_type = EmployerPenaltyCycle::REPAYMENT_CYCLE_GENERAL;
        if (!empty($model->employer_id) && is_int($model->employer_id)) {
            $model->cycle_type = EmployerPenaltyCycle::REPAYMENT_CYCLE_EMPLOYER;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_penalty_cycle_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmployerPenaltyCycle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmployerPenaltyCycle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployerPenaltyCycle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EmployerPenaltyCycle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
