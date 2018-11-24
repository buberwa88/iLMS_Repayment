<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\QpossibleResponse;
use backend\modules\application\models\QpossibleResponseSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * QpossibleResponseController implements the CRUD actions for QpossibleResponse model.
 */
class QpossibleResponseController extends Controller
{
    public function behaviors()
    {
        $this->layout = "main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all QpossibleResponse models.
     * @return mixed
     */
    public function actionIndex($question_id)
    {
        $this->layout = "default_main";
        
        $model = new QpossibleResponse;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->question_id = $question_id;
            if($model->save()){
            return $this->redirect(['index', 'question_id' => $question_id]);
            }
        }
        
        $searchModel = new QpossibleResponseSearch;
        $condition = "question_id = {$question_id} ";
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $condition);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model'=>$model,
            'question_id'=>$question_id,
        ]);
    }

    /**
     * Displays a single QpossibleResponse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->qpossible_response_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new QpossibleResponse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QpossibleResponse;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->qpossible_response_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing QpossibleResponse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "default_main";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'question_id' => $model->question_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing QpossibleResponse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $question_id = $model->question_id;
        $model->delete();
        return $this->redirect(['index','question_id'=>$question_id]);
    }

    /**
     * Finds the QpossibleResponse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QpossibleResponse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QpossibleResponse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
