<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\CriteriaField;
use backend\modules\allocation\models\CriteriaFieldSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * CriteriaFieldController implements the CRUD actions for CriteriaField model.
 */
class CriteriaFieldController extends Controller
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
     * Lists all CriteriaField models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new CriteriaFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
            'searchModel' => $searchModel,
             'id'=>$id,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CriteriaField model.
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
     * Creates a new CriteriaField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new CriteriaField();

        if ($model->load(Yii::$app->request->post())) {
                  //check if exit 
//                    $modelcriteria= CriteriaField::findOne(['criteria_id'=>$model->criteria_id,'academic_year_id'=>$model->academic_year_id,'parent_id'=>NULL]);
//                      if(count($modelcriteria)){
//                       $model->parent_id=$modelcriteria->parent_id;    
//                       }
                    $model->save();
            return $this->redirect(['index', 'id' => $model->criteria_id]);
        } else {
            return $this->render('create', [
                'criteria_id'=>$id,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CriteriaField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->criteria_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CriteriaField model.
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
     * Finds the CriteriaField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CriteriaField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CriteriaField::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
