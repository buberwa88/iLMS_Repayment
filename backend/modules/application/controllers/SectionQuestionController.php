<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\SectionQuestion;
use backend\modules\application\models\SectionQuestionSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * SectionQuestionController implements the CRUD actions for SectionQuestion model.
 */
class SectionQuestionController extends Controller
{
    public function behaviors()
    {
        $this->layout = "main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   // 'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SectionQuestion models.
     * @return mixed
     */
    public function actionIndex($question_id)
    {
        $this->layout = "default_main";
        
        $model = new SectionQuestion;

        if ($model->load(Yii::$app->request->post())) {
            $model->question_id = $question_id;
            if($model->save()){
            return $this->redirect(['index', 'question_id' => $question_id]);
            }
        }
        
        $searchModel = new SectionQuestionSearch;
        $condition = "question_id = {$question_id} ";
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $condition);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model'=>$model,
            'question_id' => $question_id,
        ]);
    }

    /**
     * Displays a single SectionQuestion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->section_question_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new SectionQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SectionQuestion;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->section_question_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SectionQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->section_question_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SectionQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $m = $this->findModel($id);
        $question_id = $m->question_id;
        $m->delete();
        return $this->redirect(['index','question_id'=>$question_id]);
    }

    /**
     * Finds the SectionQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SectionQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SectionQuestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
