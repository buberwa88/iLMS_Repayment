<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\Question;
use backend\modules\application\models\QuestionSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->question_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Question;

        if ($model->load(Yii::$app->request->post())) {
             if($model->response_control == 'TEXTBOX' || $model->response_control == 'TEXTAREA'){
                $model->qresponse_source_id = NULL;
            }
            if($model->save()){
            
            return $this->redirect(['update', 'id' => $model->question_id]);
            }
        } 
            return $this->render('create', [
                'model' => $model,
            ]);
        
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->response_control == 'TEXTBOX' || $model->response_control == 'TEXTAREA'){
                $model->qresponse_source_id = NULL;
            }
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Successfully updated');
              return $this->redirect(['update', 'id' => $model->question_id]);
            }
        }
            return $this->render('update', [
                'model' => $model,
            ]);
        
    }
    
    
    public function actionQuestionResponse($question_id){
        $this->layout = '//simple_layout';
        $modelTable = Question::findOne($question_id);
        return $this->render('_form_response',[
            'modelTable'=>$modelTable,
        ]);
        
    }

    /**
     * Deletes an existing Question model.
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
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
