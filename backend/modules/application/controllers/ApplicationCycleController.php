<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\ApplicationCycle;
use backend\modules\application\models\ApplicationCycleSearch;
use common\models\AcademicYear;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * ApplicationCycleController implements the CRUD actions for ApplicationCycle model.
 */
class ApplicationCycleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout = "main_private";
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
     * Lists all ApplicationCycle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationCycleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $current_year = AcademicYear::find()->where(['is_current' => 1])->one();
        $model = ApplicationCycle::find()->where(['academic_year_id' => $current_year->academic_year_id])->one();
        if(!isset($model)){
            $model = new ApplicationCycle();
        }
       
         if (isset($_POST['ApplicationCycle'])) {
          $data_post = Yii::$app->request->post();
          $model->academic_year_id = $data_post['ApplicationCycle']['academic_year_id'];
          $model->application_cycle_status_id = $data_post['ApplicationCycle']['application_cycle_status_id'];
          $model->application_status_remark = $data_post['ApplicationCycle']['application_status_remark'];
          $model->save();
       }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single ApplicationCycle model.
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
     * Creates a new ApplicationCycle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApplicationCycle();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->application_cycle_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ApplicationCycle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->application_cycle_id]);
             return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ApplicationCycle model.
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
     * Finds the ApplicationCycle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApplicationCycle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApplicationCycle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

