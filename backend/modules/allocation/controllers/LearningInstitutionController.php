<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\LearningInstitution;
use backend\modules\allocation\models\LearningInstitutionSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * LearningInstitutionController implements the CRUD actions for LearningInstitution model.
 */
class LearningInstitutionController extends Controller {

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
     * Lists all LearningInstitution models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LearningInstitutionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LearningInstitution model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        
        $session = Yii::$app->session;
        if (isset($session['learning_institution_id'])){
            $session->remove('learning_institution_id');
            unset($session['learning_institution_id']);
            
            $session['learning_institution_id'] =$id;
        }
        else{
            
            $session['learning_institution_id'] =$id;
        }
        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LearningInstitution model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LearningInstitution();

        if ($model->load(Yii::$app->request->post())) {
            //checking of the country selected if Tanzania( Country code 'TZA' or 'TZ') then validate the ward
            if ($model->country == 'TZ' OR $model->country == 'TZA') {
                $model->scenario = LearningInstitution::TZ_INSTITUTION; ///setting a condition for TZ institutions to validat the ward field
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash(
                        'success', 'Data Successfully Created!'
                );
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LearningInstitution model.
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
     * Deletes an existing LearningInstitution model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LearningInstitution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LearningInstitution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LearningInstitution::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
