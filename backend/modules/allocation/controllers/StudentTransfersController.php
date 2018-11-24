<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\StudentTransfers;
use backend\modules\allocation\models\StudentTransfersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \backend\modules\allocation\models\AdmissionStudent;

/**
 * StudentTransfersController implements the CRUD actions for StudentTransfers model.
 */
class StudentTransfersController extends Controller {

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
     * Lists all StudentTransfers models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new StudentTransfersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentTransfers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentTransfers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new StudentTransfers();
        //setting academic year to default current year
        $model->academic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
        //gettignstudent current programme
        if ($model->load(Yii::$app->request->post())) {
            $student_latest_admission = \backend\modules\allocation\models\AdmissionStudent::getLatestAdmissionByF4IndexNo($model->student_f4indexno, $model->student_reg_no);
            if ($student_latest_admission) {
                $model->admitted_student_id = $student_latest_admission->admission_student_id;
            }
            if ($model->save()) {
                //updating the students admission table
                $model_admission = AdmissionStudent::find('admitted_student_id=:adm_stundent_id', [':adm_stundent_id' => $model->admitted_student_id])->one();
                $model_admission->has_transfered = 1; ///transfter initiated
                $model_admission->save();
                return $this->redirect(['view', 'id' => $model->student_transfer_id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing StudentTransfers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        //setting academic year to default current year
        $model->academic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
        //gettignstudent current programme
        if ($model->load(Yii::$app->request->post())) {
            $student_latest_admission = \backend\modules\allocation\models\AdmissionStudent::getLatestAdmissionByF4IndexNo($model->student_f4indexno, $model->student_reg_no);
            if ($student_latest_admission) {
                $model->admitted_student_id = $student_latest_admission->admission_student_id;
            }
            if ($model->save()) {
                //updating the students admission table
                $model_admission = AdmissionStudent::find('admitted_student_id=:adm_stundent_id', [':adm_stundent_id' => $model->admitted_student_id])->one();
                $model_admission->has_transfered = 1; ///transfter initiated
                $model_admission->save();
                return $this->redirect(['view', 'id' => $model->student_transfer_id]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentTransfers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StudentTransfers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentTransfers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = StudentTransfers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStudentCurrentProgramme() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null && is_array($parents) && Count($parents) > 1) {
                $f4_indexno = trim(isset($parents[0]) ? $parents[0] : NULL);
                $reg_no = trim(isset($parents[1]) ? $parents[1] : NULL);
                if ($reg_no && $f4_indexno) {
                    $admission_data = \backend\modules\allocation\models\AdmissionStudent::getLatestAdmissionByF4IndexNo($f4_indexno, $reg_no);
                    foreach ($admission_data as $admission) {
                        $data = ['id' => $admission['programme_id'], 'name' => $admission->programme->programme_name . '(' . $admission->programme->programme_code . ')'];
                        array_push($out, $data);
                    }
                    echo \yii\helpers\Json::encode(['output' => $out]);
                    return;
                }
            }
        }
        echo \yii\helpers\Json::encode(['output' => '']);
    }

}
