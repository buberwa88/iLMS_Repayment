<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AdmittedStudent;
use backend\modules\allocation\models\AdmittedStudentSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * AdmittedStudentController implements the CRUD actions for AdmittedStudent model.
 */
class AdmittedStudentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
         $this->layout="main_private";
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
     * Lists all AdmittedStudent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdmittedStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
  public function actionIndexall($id)
    {
       $this->layout="default_main";
        $searchModel = new AdmittedStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexall', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id,
        ]);
    }
    /**
     * Displays a single AdmittedStudent model.
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
     * Creates a new AdmittedStudent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdmittedStudent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Created!'
                        );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
  public function actionCreateall()
    {
        $this->layout="default_main";
        $model = new AdmittedStudent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                   Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Created!'
                        );
            return $this->redirect(['indexall','id'=> $model->admission_batch_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing AdmittedStudent model.
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
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
  public function actionUpdateall($id)
    {
        $this->layout="default_main";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                   Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfully Updated!'
                        );
            return $this->redirect(['indexall','id'=> $model->admission_batch_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing AdmittedStudent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
           $model=$model1=$this->findModel($id);
           $model1->delete();
        return $this->redirect(['index','id'=> $model->admission_batch_id]);
    }

    /**
     * Finds the AdmittedStudent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdmittedStudent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmittedStudent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
