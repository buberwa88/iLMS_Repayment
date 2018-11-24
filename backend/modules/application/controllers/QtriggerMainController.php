<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\QtriggerMain;
use backend\modules\application\models\QtriggerMainSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * QtriggerMainController implements the CRUD actions for QtriggerMain model.
 */
class QtriggerMainController extends Controller
{
    public function behaviors()
    {
         $this->layout = "main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all QtriggerMain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QtriggerMainSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single QtriggerMain model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->qtrigger_main_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new QtriggerMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QtriggerMain;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($_POST['response'] as $key => $value) {
               $m = new \backend\modules\application\models\Qtrigger();
               $m->qtrigger_main_id = $model->qtrigger_main_id;
               $m->qpossible_response_id = $value;
               $m->save();
            }
            
            foreach ($_POST['questions'] as $key => $value) {
               $m = new \backend\modules\application\models\QnsToTrigger();
               $m->qtrigger_main_id = $model->qtrigger_main_id;
               $m->question_id = $value;
               $m->save();
            }
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing QtriggerMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
                $model =  QtriggerMain::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \backend\modules\application\models\Qtrigger::deleteAll("qtrigger_main_id = {$id} ");
            foreach ($_POST['response'] as $key => $value) {
               $m = new \backend\modules\application\models\Qtrigger();
               $m->qtrigger_main_id = $model->qtrigger_main_id;
               $m->qpossible_response_id = $value;
               $m->save();
            }
            
            foreach ($_POST['questions'] as $key => $value) {
                \backend\modules\application\models\QnsToTrigger::deleteAll("qtrigger_main_id = {$id}");
               $m = new \backend\modules\application\models\QnsToTrigger();
               $m->qtrigger_main_id = $model->qtrigger_main_id;
               $m->question_id = $value;
               $m->save();
            }
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing QtriggerMain model.
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
     * Finds the QtriggerMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QtriggerMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QtriggerMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
