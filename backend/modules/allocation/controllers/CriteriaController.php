<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\Criteria;
use backend\modules\allocation\models\CriteriaQuestionAnswer;
use backend\modules\allocation\models\CriteriaQuestion;
use backend\modules\allocation\models\CriteriaField;
use backend\modules\allocation\models\CriteriaSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * CriteriaController implements the CRUD actions for Criteria model.
 */
class CriteriaController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all Criteria models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CriteriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Criteria model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Criteria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Criteria();
         
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

    /**
     * Updates an existing Criteria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
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
    /**
     * Deletes an existing Criteria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
       $model=$this->findModel($id);
         try {
          if($model->delete());
//print_r($model);
//exit();
       } catch (\PDOException $e) {
    $error = 'The item you are trying to delete is associated with other records';
    // The exact error message is $e->getMessage();
    $this->set('error', $error);
   }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Criteria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Criteria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Criteria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetresponse() {

        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $table_name = $parents[0];
                $out = Criteria::getResponse($table_name);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    public function actionGettableColumnName() {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $table_name = $parents[0];
                $out = Criteria::getTableColumnName($table_name);

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    public function actionGetform() {
        $id = Yii::$app->request->post("categoryId");
        if ($id == 1) {
            $model = new CriteriaField();
            return $this->renderAjax('../criteria-field/create', [
                        'model' => $model,
            ]);
        } else {
           // echo "Mickidadi";
        }
    }

}
