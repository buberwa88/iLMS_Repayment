<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\ScholarshipDefinition;
use backend\modules\allocation\models\ScholarshipDefinitionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ScholarshipDefinitionController implements the CRUD actions for ScholarshipDefinition model.
 */
class ScholarshipDefinitionController extends Controller {

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
     * Lists all ScholarshipDefinition models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ScholarshipDefinitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ScholarshipDefinition model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $active = '';
        if (\Yii::$app->session['active_tab']) {
            $active = \Yii::$app->session['active_tab'];
        }
        if ($model) {
//getting learning institutions unde the programme
            $model_learning_institution = \backend\modules\allocation\models\ScholarshipLearningInstitution::getInstitutionsById($id);
//getting programmes under the given scholarship
            $model_programme = \backend\modules\allocation\models\ScholarshipProgramme::getProgrammesById($id);
//getting grant loan items
            $model_loan_item = \backend\modules\allocation\models\ScholarshipLoanItem::getLoanItemsById($id);
//getting programmes students
            $model_student = \backend\modules\allocation\models\ScholarshipStudent::getStudentsById($id);
            $model_study_level = \backend\modules\allocation\models\ScholarshipStudyLevel::getStudylevelsByGrantId($id);

            return $this->render('view', [
                        'model' => $model, 'active' => $active,
                        'model_learning_institution' => $model_learning_institution,
                        'model_programme' => $model_programme,
                        'model_loan_item' => $model_loan_item,
                        'model_student' => $model_student,
                        'model_study_level' => $model_study_level
            ]);
        }
    }

    /**
     * Creates a new ScholarshipDefinition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ScholarshipDefinition();
        $model->is_active = ScholarshipDefinition::STATUS_ACTIVE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->scholarship_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ScholarshipDefinition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->scholarship_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAddStudent($id) {
        \Yii::$app->session['active_tab'] = 'tab3';
        $model = $this->findModel($id);
        $student = New \backend\modules\allocation\models\ScholarshipStudent();
        $student->scholarship_id = $model->scholarship_id;
        if (Yii::$app->request->post('ScholarshipStudent')) {
            if ($student->scholarship_id == $id) {
                $student->attributes = Yii::$app->request->post('ScholarshipStudent');
                try {
                    if ($student->save()) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }

        return $this->render('addStudent', [
                    'model' => $model, 'student' => $student
        ]);
    }

    public function actionAddInstitution($id) {
        \Yii::$app->session['active_tab'] = 'tab4';
        $model = $this->findModel($id);
        $institution = New \backend\modules\allocation\models\ScholarshipLearningInstitution();
        $institution->scholarship_id = $model->scholarship_id;
        if (Yii::$app->request->post('ScholarshipLearningInstitution')) {
            if ($institution->scholarship_id == $id) {
                $institution->attributes = Yii::$app->request->post('ScholarshipLearningInstitution');
                $academic_year_id = $institution->academic_year_id;
                try {
                    $count = 0;
                    //loping in the institution list for each model
                    foreach ($institution->learning_institution_id as $key => $institution) {
                        $institutions = New \backend\modules\allocation\models\ScholarshipLearningInstitution();
                        $institutions->learning_institution_id = $institution;
                        $institutions->scholarship_id = $id;
                        $institutions->academic_year_id = $academic_year_id;
                        if ($institutions->save()) {
                            $count++;
                        }
                    }

                    if ($count > 0) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }

        return $this->render('addInstitution', [
                    'model' => $model, 'institution' => $institution
        ]);
    }

    public function actionAddProgramme($id) {
        \Yii::$app->session['active_tab'] = 'tab5';
        $model = $this->findModel($id);
        $programme = New \backend\modules\allocation\models\ScholarshipProgramme();
        $programme->scholarship_id = $model->scholarship_id;
        if (Yii::$app->request->post('ScholarshipProgramme')) {
            if ($programme->scholarship_id == $id) {
                $programme->attributes = Yii::$app->request->post('ScholarshipProgramme');
                $academic_year_id = $programme->academic_year_id;
                try {
                    $count = 0;
                    //loping in the institution list for each model
                    foreach ($programme->programme_id as $key => $programme_id) {
                        $programmes = New \backend\modules\allocation\models\ScholarshipProgramme();
                        $programmes->scholarship_id = $id;
                        $programmes->programme_id = $programme_id;
                        $programmes->academic_year_id = $academic_year_id;
                        if ($programmes->save()) {
                            $count++;
                        }
                    }
                    if ($count > 0) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {

                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }

        return $this->render('addProgramme', [
                    'model' => $model, 'programme' => $programme
        ]);
    }

    public function actionAddStudyLevel($id) {
        \Yii::$app->session['active_tab'] = 'tab2';
        $model = $this->findModel($id);
        $study_level = New \backend\modules\allocation\models\ScholarshipStudyLevel();
        $study_level->scholarship_definition_id = $model->scholarship_id;
        if (Yii::$app->request->post('ScholarshipStudyLevel')) {
            if ($study_level->scholarship_definition_id == $id) {
                $study_level->attributes = Yii::$app->request->post('ScholarshipStudyLevel');
                $academic_year_id = $study_level->academic_year_id;
                try {
                    $count = 0;
                    //loping in the institution list for each model
                    foreach ($study_level->applicant_category_id as $key => $study_level_id) {
                        $study_levels = New \backend\modules\allocation\models\ScholarshipStudyLevel();
                        $study_levels->scholarship_definition_id = $id;
                        $study_levels->applicant_category_id = $study_level_id;
                        $study_levels->academic_year_id = $academic_year_id;
                        if ($study_levels->save()) {
                            $count++;
                        }
                    }
                    if ($count > 0) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {

                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }

        return $this->render('addStudyLevel', [
                    'model' => $model, 'study_level' => $study_level
        ]);
    }

    public function actionAddLoanItem($id) {
        \Yii::$app->session['active_tab'] = 'tab1';
        $model = $this->findModel($id);
        $loan_item = New \backend\modules\allocation\models\ScholarshipLoanItem();
        $loan_item->scholarship_definition_id = $model->scholarship_id;
        if (Yii::$app->request->post('ScholarshipLoanItem')) {
            if ($loan_item->scholarship_definition_id == $id) {
                $loan_item->attributes = Yii::$app->request->post('ScholarshipLoanItem');

                try {
                    if ($loan_item->save()) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {
                    var_dump($exception);
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }
        return $this->render('addLoanItem', [
                    'model' => $model, 'loan_item' => $loan_item
        ]);
    }

    /**
     * Deletes an existing ScholarshipDefinition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ScholarshipDefinition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ScholarshipDefinition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ScholarshipDefinition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
