<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\LearningInstitutionFee;
use backend\modules\allocation\models\LearningInstitutionFeeSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

//use common\components\Controller;

/**
 * LearningInstitutionFeeController implements the CRUD actions for LearningInstitutionFee model.
 */
class LearningInstitutionFeeController extends \yii\web\Controller {

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
     * Lists all LearningInstitutionFee models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LearningInstitutionFeeSearch();
        $dataProvider = $searchModel->searchNonHigherLearningInstitution(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LearningInstitutionFee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LearningInstitutionFee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LearningInstitutionFee();
        $model->scenario = 'create_update';
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
     * Updates an existing LearningInstitutionFee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'create_update';
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
     * Deletes an existing LearningInstitutionFee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LearningInstitutionFee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LearningInstitutionFee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LearningInstitutionFee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionClone() {
        $model = new LearningInstitutionFee;
        $model->scenario = 'clone_fee';
        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = $model->updated_by = Yii::$app->user->id;
            if ($model->validate()) {

                $source_school_fees = LearningInstitutionFee::getSchoolFeesByAcademicYearID($model->source_academic_year);
                $count_list = count($source_school_fees);
                $count_saved = 0;
//                echo $count_list;
//                exit;
                if ($source_school_fees) {
                    foreach ($source_school_fees as $source_school_fee) {
                        $clon_fee = new LearningInstitutionFee;
                        $clon_fee->learning_institution_id = $source_school_fee->learning_institution_id;
                        $clon_fee->academic_year_id = $model->destination_academic_year;
                        $clon_fee->fee_amount = $source_school_fee->fee_amount;
                        $clon_fee->study_level = $source_school_fee->study_level;
                        $clon_fee->created_by = Yii::$app->user->id;
                        if ($clon_fee->save()) {
                            $count_saved++;
                        }
                    }
                }
                if ($count_saved) {
                    $sms = 'Clone Operation Successful, ' . $count_saved . ' Records out of ' . $count_list . ' have been Cloned';
                    Yii::$app->session->setFlash('success', $sms);
                    $model->attributes = NULL;
                } else {
                    $sms = 'Clone Operation failed, No Records has been Cloned';
                    Yii::$app->session->setFlash('failure', $sms);
                }
            }
        }
        return $this->render('cloneFee', [
                    'model' => $model
        ]);
    }

}
