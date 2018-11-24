<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\CriteriaQuestion;
use backend\modules\allocation\models\CriteriaQuestionSearch;
use backend\modules\allocation\models\CriteriaQuestionAnswer;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * CriteriaQuestionController implements the CRUD actions for CriteriaQuestion model.
 */
class CriteriaQuestionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
              $this->layout="default_main";
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
     * Lists all CriteriaQuestion models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new CriteriaQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'id'=>$id,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CriteriaQuestion model.
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
     * Creates a new CriteriaQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
          $model = new CriteriaQuestion();
          $model_criteria_question_answer = new CriteriaQuestionAnswer();
        if ($model->load(Yii::$app->request->post())) {
                  //check if exit 
                    $modelcriteria=  CriteriaQuestion::findOne(['criteria_id'=>$model->criteria_id,'academic_year_id'=>$model->academic_year_id,'parent_id'=>NULL]);
                      if(count($modelcriteria)){
                       $model->parent_id=$modelcriteria->parent_id;    
                       }
                    $model->save();
                   $model_criteria_question_answer->load(Yii::$app->request->post());
                   $model_criteria_question_answer->criteria_question_id=$model->criteria_question_id;
                   $model_criteria_question_answer->save(false);
            return $this->redirect(['index', 'id' => $model->criteria_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'criteria_id'=>$id,
                'model_criteria_question_answer' => $model_criteria_question_answer,
            ]);
        }
    }

    /**
     * Updates an existing CriteriaQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
            $model = $this->findModel($id);
            $model_criteria_question_answer = CriteriaQuestionAnswer::findone(['criteria_question_id' =>$id]);
               if(count($model_criteria_question_answer)==0){
             $model_criteria_question_answer = new CriteriaQuestionAnswer();          
               }
        if ($model->load(Yii::$app->request->post())&&$model->save()) {
                   $model_criteria_question_answer->load(Yii::$app->request->post());
                   $model_criteria_question_answer->criteria_question_id=$model->criteria_question_id;
                   $model_criteria_question_answer->save(false);
            return $this->redirect(['index', 'id' => $model->criteria_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_criteria_question_answer' => $model_criteria_question_answer,
            ]);
        }
    }

    /**
     * Deletes an existing CriteriaQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$modelall=$this->findModel($id);
               $modelall->delete();
        return $this->redirect(['index', 'id' => $model->criteria_id]);
    }

    /**
     * Finds the CriteriaQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CriteriaQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CriteriaQuestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
