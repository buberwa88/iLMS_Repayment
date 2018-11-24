<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use backend\models\ContactForm;
use backend\modules\allocation\models\StudentExamResult;
use backend\modules\allocation\models\AdmissionStudentSearch;
use backend\modules\allocation\models\AdmissionStudent;
use backend\modules\allocation\models\AdmissionBatch;

//use common\components\Controller;
/**
 * Site controller
 */
class InstitutionController extends Controller {

//    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        $user_institution = \common\models\Staff::find(['user_id' => \Yii::$app->user->id])
                ->select('*,learning_institution.institution_name AS institution_name,learning_institution.institution_type AS institution_type')
                ->innerJoin('learning_institution', 'learning_institution.learning_institution_id=staff.learning_institution_id')
                ->one();
        if ($user_institution) {
            Yii::$app->session->set('is_institution_user', TRUE);
            Yii::$app->session->set('institution_name', $user_institution->institution_name);
            Yii::$app->session->set('institution_id', $user_institution->learning_institution_id);
            Yii::$app->session->set('institution_type', $user_institution->type);
        } else {
            Yii::$app->session->set('is_institution_user', FALSE);
            Yii::$app->session->set('institution_name', NULL);
            Yii::$app->session->set('institution_id', NULL);
            Yii::$app->session->set('institution_type', NULL);
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = "institution_main";
        if (Yii::$app->session->has('is_institution_user')) {
            $institution_id = Yii::$app->session->get('institution_id');
            $staff_type = Yii::$app->session->get('institution_type');
//            echo $staff_type;
            return $this->render('//institution/dashboard');
        }
    }

    public function actionExamResults() {
        $this->layout = "institution_main";
        $model = new \backend\modules\allocation\models\StudentExamResult();
        $modelExamResultSearch = new \backend\modules\allocation\models\StudentExamResultSearch();
        $confirmedExamReslt = $modelExamResultSearch->searchConfirmedExaminationByInstitution(NULL, Yii::$app->session['institution_id']);
        $pendingExamReslt = $modelExamResultSearch->searchPendingExaminationByInstitution(NULL, Yii::$app->session['institution_id']);
        $verifiedExamReslt = $modelExamResultSearch->searchVerifiedExaminationByInstitution(NULL, Yii::$app->session['institution_id']);
        return $this->render('ExamResults', [
                    'model' => $model,
                    'searchModel' => $modelExamResultSearch,
                    'confirmedExamReslt' => $confirmedExamReslt,
                    'pendingExamReslt' => $pendingExamReslt,
                    'verifiedExamReslt' => $verifiedExamReslt,
        ]);
    }

    function actionAddStudentExamResult() {
        $this->layout = "institution_main";
        $model = new StudentExamResult();
        $model->is_beneficiary = StudentExamResult::IS_BENEFICIARY_YES;
        $model->learning_institution_id = Yii::$app->session->get('institution_id');
        $model->scenario = 'add_students_examination_results';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->learning_institution_id == Yii::$app->session->get('institution_id')) {
                $model->learning_institution_id = Yii::$app->session->get('institution_id');
                if ($model->save()) {
                    return $this->redirect(['view-exam-result', 'id' => $model->student_exam_result_id]);
                    // return $this->redirect('view-exam-result', ['id' => $model->student_exam_result_id]);
                }
            } else {
                $sms = '<p>Operation failed</p>';
                Yii::$app->session->setFlash('failure', $sms);
            }
        }
        return $this->render('//institution/addStudentExamResult', [
                    'model' => $model,
        ]);
    }

    function actionViewExamResult($id) {
        $this->layout = "institution_main";
        $id = \yii\bootstrap\Html::encode($i);
        $model = StudentExamResult::find($id)->one();
        if ($model) {
            return $this->render('_view_details', ['model' => $model]);
        }
    }

    public function actionDownloadTemplate() {
        $path = Yii::getAlias('@webroot') . '/upload';
        $file = $path . '/students_exam_results_template.xlsx';
        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$file} is not found!");
        }
    }

    public function actionUploadStudentsExamResults() {
        $this->layout = "institution_main";
        $model = new StudentExamResult();
        $loggedin = Yii::$app->user->identity->user_id;
        $model->scenario = 'students_exam_results_upload';
        if ($model->load(Yii::$app->request->post())) {
            $model->students_exam_results_file = \yii\web\UploadedFile::getInstance($model, 'students_exam_results_file');
            if ($model->students_exam_results_file != "") {
                $model->students_exam_results_file->saveAs(Yii::$app->params['examination_data_upload_location'] . $model->students_exam_results_file->name);
                $model->students_exam_results_file = Yii::$app->params['examination_data_upload_location'] . $model->students_exam_results_file->name;
                //$model->save();
                $data = \moonland\phpexcel\Excel::widget([
                            'mode' => 'import',
                            'fileName' => $model->students_exam_results_file,
                            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                                // 'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
                if (count($data) > 0) {
                    $check = 0;
                    $objPHPExcelOutput = new \PHPExcel();
                    $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
                    $objPHPExcelOutput->setActiveSheetIndex(0);
                    ///EXCEL COLUMNS TO READ
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'Sn');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B1', 'InstitutionCode');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C1', 'AcademicYear');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D1', 'Semmester');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E1', 'RegistrationNo');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F1', 'F4indexno');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G1', 'ProgrammeCode');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H1', 'YOS');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I1', 'ExamStatus');

                    $rowCount = 2;
                    $s_no = 1; ///looping wothin each row and read the data in each column with column name case sensitive
                    foreach ($data as $datas12) {
                        ;
                        if (isset($datas12['InstitutionCode']) && isset($datas12['AcademicYear']) && isset($datas12['Semmester']) && isset($datas12['RegistrationNo']) && isset($datas12['F4indexno']) && isset($datas12['ProgrammeCode']) && isset($datas12['YOS']) && isset($datas12['ExamStatus'])) {

                            $LearningInstitution = $datas12["InstitutionCode"];
                            //gettin actual learning institution id
                            $LearningInstitution = \backend\modules\allocation\models\LearningInstitution::find()
                                    ->where(['institution_code' => $LearningInstitution])
                                    ->one();
                            if ($LearningInstitution) {
                                $LearningInstitution = $LearningInstitution->learning_institution_id;
                            } else {
                                $LearningInstitution = NULL;
                            }
                            $AcademicYear = $datas12["AcademicYear"];
                            //map academic year
                            $AcademicYear = \common\models\AcademicYear::find()
                                    ->where(['academic_year' => $AcademicYear])
                                    ->one();
                            if ($AcademicYear) {
                                $AcademicYear = $AcademicYear->academic_year_id;
                            } else {
                                $AcademicYear = NULL;
                            }

                            $Semmester = $datas12["Semmester"];
                            $registration_number = $datas12["RegistrationNo"];
                            $f4index = $datas12["F4indexno"];
//                            echo $datas12["ProgrammeCode"];
                            $programme_code = \backend\modules\allocation\models\Programme::find()
                                            ->where(['programme_code' => $datas12["ProgrammeCode"], 'learning_institution_id' => $LearningInstitution])->one();
//                            var_dump($programme_code->attributes);
//                            exit;
                            if ($programme_code) {
                                $programme_code = $programme_code->programme_id;
                            } else {
                                $programme_code = NULL;
                            }
                            $YearOfStudy = $datas12["YOS"];
                            ///Getting samstatus
                            $ExamStatus = \backend\modules\allocation\models\ExamStatus::getExamStatusIDByName($datas12["ExamStatus"]);

                            $empty_field = 0;
                            $comment_empt = "";
                            if ($LearningInstitution == "") {
                                $empty_field++;
                                $comment_empt.="Wrong Institution Code or Empty, ";
                            } if ($AcademicYear == "") {
                                $empty_field++;
                                $comment_empt.="Wrong Academic Year or Empty, ";
                            } if ($Semmester == "") {
                                $empty_field++;
                                $comment_empt.="Semmester is empty, ";
                            }
                            if ($registration_number == "") {
                                $empty_field++;
                                $comment_empt.=" Registration Number is empty  , ";
                            }
                            if ($f4index == "") {
                                $empty_field++;
                                $comment_empt.="Form 4 index Number is empty, ";
                            }
                            if ($programme_code == "") {
                                $empty_field++;
                                $comment_empt.=" Wrong Programme Code or Empty , ";
                            }
                            if ($YearOfStudy == "") {
                                $empty_field++;
                                $comment_empt.="Year Of Study is empty,";
                            }
                            if ($ExamStatus == "") {
                                $empty_field++;
                                $comment_empt.="Wrong Exam Status or empty,";
                            }

                            if ($empty_field == 0) {

                                #####################check if applicant has a programme on that registration number ,yos and programme_code#########
                                //$model_exit_proramme_id = StudentExamResult::findProgramme($programme_code, $registration_number, $YearOfStudy);
                                //if (count($model_exit_proramme_id) > 0) {
                                $exam_result_model = new StudentExamResult;
                                $exam_result_model->f4indexno = $f4index;
                                $exam_result_model->registration_number = $registration_number;
                                $exam_result_model->academic_year_id = $AcademicYear;
                                $exam_result_model->programme_id = $programme_code;
                                $exam_result_model->study_year = $YearOfStudy;

                                if ($exam_result_model->validStudent()) {

                                    ##############applicant exit in this academic year ###############
                                    $model_exit = StudentExamResult::find()
                                            ->where(['academic_year_id' => $AcademicYear, 'semester' => $Semmester, 'registration_number' => $registration_number, 'programme_id' => $programme->programme_id, 'study_year' => $YearOfStudy])
                                            ->andWhere('f4indexno=:f4indexno AND registration_number=:registation_no', [':f4indexno' => $f4index, ':registation_no' => $registration_number])
                                            ->exists();
                                    #################check end ######################################
                                    //SELECT pr.`programme_id` programme_id FROM `application` ap  join  programme pr   on ap.`programme_id`=pr.`programme_id`  where `programme_code`= AND `registration_number` AND `current_study_year`
                                    if (!$model_exit) {
//                                        $check12 = \backend\modules\application\models\Programme::findone(["learning_institution_id" => $model->learning_institution_id, "programme_code" => $programme_code]);
//                                        if (count($check12) == 0) {
//                                            $programme_status = 0;
//                                            $programme_id = NULL;
//                                        } else {
//                                            $programme_status = 1;
//                                            $programme_id = $check12["programme_id"];
//                                        }
                                        $exam_result_model->learning_institution_id = Yii::$app->session->get('institution_id');
                                        $exam_result_model->exam_status_id = $ExamStatus;
                                        $exam_result_model->semester = $Semmester;
                                        $exam_result_model->status = StudentExamResult::STATUS_DRAFT;
                                        $exam_result_model->is_last_semester = $model->is_last_semester;
                                        $exam_result_model->is_beneficiary = StudentExamResult::IS_BENEFICIARY_YES;
                                        $exam_result_model->created_by = Yii::$app->user->id;
//                                        $exam_result_model->programme_id = $programme_code;
                                        if (!$exam_result_model->save()) {

                                            $sms = 'Operation Failed,PLease Try again or check your data';
                                        } else {
                                            $sms = 'Operation Succcessful';
                                        }
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $LearningInstitution);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $AcademicYear);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $Semmester);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $registration_number);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $f4index);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $sms);

                                        $rowCount++;
                                        $s_no++;
//                                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
//                                        $objWriter->save('php://output');
                                    } else {
                                        //Applicant already exit 
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $LearningInstitution);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $AcademicYear);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $Semmester);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $registration_number);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $f4index);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_code);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $YearOfStudy);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $ExamStatus);
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, 'Results already Exist for this Student');
                                        $rowCount++;
                                        $s_no++;
                                    }
                                } else {

                                    //Applicant already exit 
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $LearningInstitution);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $AcademicYear);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $Semmester);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $registration_number);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $f4index);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_code);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $YearOfStudy);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $ExamStatus);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, 'Failed !Student Admission data for the Selected Academic Year Doesnot exist');
                                    $rowCount++;
                                    $s_no++;
                                }
                                //end
                                // Yii::$app->session->setFlash('success', 'Information Upload Successfully'); 
                            } else {
                                /*
                                 * Empty field
                                 */

                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $LearningInstitution);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $AcademicYear);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $Semmester);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $registration_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $f4index);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $YearOfStudy);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $ExamStatus);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $comment_empt);
                                $rowCount++;
                                $s_no++;
                            }
                        } else {
                            Yii::$app->session->setFlash('failure', 'Sorry ! Please use the correct excel format.Excel Column Labela are also case sensitive download new formate or change Label Name');
                        }
//                        }
                    }
                }
            }
        }
        return $this->render('uploadStudentsexamResults', [
                    'model' => $model,
        ]);
    }

    public function actionConfirmStudentsExam() {

        $loggedin = Yii::$app->user->identity->user_id;
        $selection = (array) Yii::$app->request->post('selection'); //typecasting
        foreach ($selection as $student_exam_result_id) {
            //$employedBeneficiary->confirmBeneficiaryByEmployer($employerID,$employed_beneficiary_id);
            $studentsResultsDetails = \backend\modules\allocation\models\StudentExamResult::findOne(['student_exam_result_id' => $student_exam_result_id]);
            $studentsResultsDetails->confirmed = 1;
            $studentsResultsDetails->save();
        }
        if ($student_exam_result_id != '') {
            $sms = "Students successful confirmed!";
            Yii::$app->getSession()->setFlash('success', $sms);
        }
        /*
          if($employed_beneficiary_id ==''){
          $sms=" Error: No any beneficiary selected!";
          Yii::$app->getSession()->setFlash('error', $sms);
          }
         * 
         */
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing StudentExamResult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStudentExamsResultUpdate($id) {
        $this->layout = "institution_main";
        $id = \yii\helpers\Html::encode($id);
        $model = \backend\modules\allocation\models\base\StudentExamResult::find()->where(['student_exam_result_id' => $id])->one();
        if ($model->status == StudentExamResult::STATUS_DRAFT OR $model->status == StudentExamResult::STATUS_VERIFIED) {
            $model->created_at = Date('Y-m-d H:i:s', time());
            $model->created_by = Yii::$app->user->id;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['institution/view-exam-result', 'id' => $id]);
            }
            return $this->render('update', [
                        'model' => $model,
            ]);
        } else {
            $this->redirect(['institution/exam-results']);
        }
    }

    /*
     * FOR ALL HLI INSTIITUIONS
     */

    function actionStudentAdmissions() {
        $this->layout = "institution_main";
        $searchModelConfirmed = new AdmissionStudentSearch();
        $searchModelConfirmed->learning_institution_id = \Yii::$app->session->get('institution_id');
        $dataProviderConfirmed = $searchModelConfirmed->searchByCriteria(Yii::$app->request->queryParams, $status = AdmissionStudent::STATUS_CONFIRMED);
        ///////getting pending students for confirmation
        $searchModelPending = new AdmissionStudentSearch();
        $searchModelPending->learning_institution_id = \Yii::$app->session->get('institution_id');
        $dataProviderPending = $searchModelPending->searchByCriteria(Yii::$app->request->queryParams, $status = AdmissionStudent::STATUS_NOT_CONFIRMED);
        return $this->render('admissionStudent', [
                    'searchModelConfirmed' => $searchModelConfirmed,
                    'dataProviderConfirmed' => $dataProviderConfirmed,
                    'searchModelPending' => $searchModelPending,
                    'dataProviderPending' => $dataProviderPending,
        ]);
    }

    /*
     * FOR TCU
     */

    function actionFreshersStudentAdmissions() {
        $this->layout = "institution_main";
        $searchModelConfirmed = new AdmissionStudentSearch();
        $searchModelConfirmed->study_year = 1; //alow only first year
        $dataProviderConfirmed = $searchModelConfirmed->searchByCriteria(Yii::$app->request->queryParams, $status = AdmissionStudent::STATUS_CONFIRMED);
        ///////getting pending students for confirmation
        $searchModelPending = new AdmissionStudentSearch();
        $searchModelPending->study_year = 1; //allow only first year
       
        $dataProviderPending = $searchModelPending->searchByCriteria(Yii::$app->request->queryParams, $status = AdmissionStudent::STATUS_NOT_CONFIRMED);
        return $this->render('admissionStudent', [
                    'searchModelConfirmed' => $searchModelConfirmed,
                    'dataProviderConfirmed' => $dataProviderConfirmed,
                    'searchModelPending' => $searchModelPending,
                    'dataProviderPending' => $dataProviderPending,
        ]);
    }

    public function actionUploadStudentsAdmission() {
        $model = new AdmissionStudent();
        $this->layout = "institution_main";
        $model->scenario = 'students_admission_bulk_upload';
        /*
         * gettijg current Academic year
         */
        $model_academic = \common\models\AcademicYear::getCurrentYearDetails();

        if ($model->load(Yii::$app->request->post())) {
            $model->students_admission_file = \yii\web\UploadedFile::getInstance($model, 'students_admission_file');
            //CHECKING  ADMISSION BATCH DETAIL
            ///Managinf admision Batch details
            $batch = new AdmissionBatch;
            $batch->academic_year_id = $model->academic_year_id;
            $batch->batch_number = $model->batch_number;
            $batch->batch_desc = $model->batch_desc;
            $batch->created_by = Yii::$app->user->id;
            $batch->dump_type = AdmissionBatch::DUMP_TYPE_FILE;
            $batch->dump_file_name = $model->students_admission_file;

            if ($batch->validate()) {

                if ($model->students_admission_file != "") {
                    $model->students_admission_file->saveAs(Yii::$app->params['tcu_admission_data_upload_location'] . $model->students_admission_file->name);
                    $model->students_admission_file = Yii::$app->params['tcu_admission_data_upload_location'] . $model->students_admission_file->name;
                    $data = \moonland\phpexcel\Excel::widget([
                                'mode' => 'import',
                                'fileName' => $model->students_admission_file,
                                'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                                'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                                'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                    ]);
                    //validating batch
                    ///creating/saving batch details
                    $batch_exists = AdmissionBatch::find()->where(['batch_number' => $batch->batch_number, 'academic_year_id' => $batch->academic_year_id])->one();
                    if (!$batch_exists) {
                        $batch->save();
                    } else {
                        $batch = $batch_exists;
                    }
                    if (count($data) > 0) {
                        ///checking the exceldata
                        $check = 0;
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);

                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'Sn');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B1', 'f4_index_no');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C1', 'first_name');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D1', 'second_name');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E1', 'surname');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F1', 'programme_code');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G1', 'programme');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('H1', 'institution_code');
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('I1', 'comment');


                        $rowCount = 2;
                        $s_no = 1;
                        $success = 0;
                        foreach ($data as $datas12) {
                            $comment_empt = "";
                            $empty_field = $check = 0;
                            //columns validation
                            if (isset($datas12["f4_index_no"]) && empty($datas12["f4_index_no"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty Form 4 index Number , ";
                            }
                            if (isset($datas12["first_name"]) && empty($datas12["first_name"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty first Name ,";
                            }
                            if (isset($datas12["middle_name"]) && empty($datas12["middle_name"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty Middle Name , ";
                            }
                            if (isset($datas12["surname"]) && empty($datas12["surname"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty Surname , ";
                            }
                            if (isset($datas12["programme_code"]) && empty($datas12["programme_code"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty Programme Code , ";
                            }
                            if (isset($datas12["programme"]) && empty($datas12["programme"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty Programme";
                            }
                            if (isset($datas12["institution_code"]) && empty($datas12["institution_code"])) {
                                $check+=0;
                                $empty_field++;
                                $comment_empt.=" Empty Institution Code ";
                            }

                            if ($check == 0) {
                                $f4index = trim($datas12["f4_index_no"]);
                                $firstname = trim($datas12["first_name"]);
                                $middlename = trim($datas12["middle_name"]);
                                $lastname = trim($datas12["surname"]);
                                $programme_code = trim($datas12["programme_code"]);
                                $programme_name = trim($datas12["programme"]);
                                $institution_code = trim($datas12["institution_code"]);
                                ////preparing the outup/upload results output excel row
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $f4index);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $lastname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_name);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $institution_code);
                                //end uploading results excel

                                if ($empty_field == 0) {
                                    ##############applicant exit in this academic year ###############
                                    $model_exit = AdmissionStudent::find()->where(['f4indexno' => $f4index, 'academic_year_id' => $model_academic->academic_year_id])->exists();
                                    #################check end ######################################
                                    if (!$model_exit) {
                                        $check_programme = \backend\modules\application\models\Programme::find()->where(["learning_institution_id" => $model->learning_institution_id, "programme_code" => $programme_code])->one();
                                        ///validate programme existance in the given university
                                        if ($check_programme) {
                                            $programme_status = 1;
                                            $programme_id = $check_programme->programme_id;
                                        } else {
                                            $programme_status = 0;
                                            $programme_id = NULL;
                                        }
                                        $modelsp = new AdmissionStudent();
                                        $modelsp->admission_batch_id = $batch->admission_batch_id;
                                        $modelsp->f4indexno = $f4index;
                                        $modelsp->programme_id = $programme_id;
                                        $modelsp->firstname = $firstname;
                                        $modelsp->middlename = $middlename;
                                        $modelsp->surname = $lastname;
                                        $modelsp->course_code = $programme_code;
                                        $modelsp->course_description = $programme_name;
                                        $modelsp->institution_code = $institution_code;
                                        $modelsp->study_year = 1; ///setting default student study year to be first year
                                        $modelsp->academic_year_id = $model_academic->academic_year_id;
                                        $modelsp->admission_status = AdmissionStudent::STATUS_NOT_CONFIRMED;
                                        $modelsp->programme_status = $programme_status;
                                        $modelsp->admission_type = AdmissionStudent::ADMISSION_TYPE_FRESHERS;
                                        $modelsp->created_by = Yii::$app->user->id;
                                        $modelsp->has_reported = AdmissionStudent::HAS_REPORTED_NO;
                                        $modelsp->has_transfered = AdmissionStudent::HAS_NO_TRANSFER; //setting default for student transafer
                                        if ($modelsp->save()) {
                                            $success++;
                                            $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $comment_empt . ': Successful: ' . $comment);
                                        } else {
                                            $errors = $modelsp->errors;
                                            $comment = NULL;
                                            if ($errors) {
                                                foreach ($errors as $key => $error) {
                                                    $comment .=':' . $error[0];
                                                }
                                            }
                                            $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $comment_empt . ': Failed Operation: ' . $comment);
                                        }
                                        $rowCount++;
                                        $s_no++;
                                    } else {
                                        //Applicant already exit 
                                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $comment_empt . ': Student Already Exist');
                                        $rowCount++;
                                        $s_no++;
                                    }
                                } else {
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $comment_empt);
                                    $rowCount++;
                                    $s_no++;
                                }
                            } else {
                                Yii::$app->session->setFlash('failure', 'Sorry ! The Excel Label are case sensitive download new formate or change Label Name');
                            }
                        }
                        if ($success) {
                            Yii::$app->session->setFlash('success', 'Operation Done Successful ' . $success . ' Records Uploaded Successful');
                            $model->attributes = $modelsp->attributes = NULL;
                        } else {
                            Yii::$app->session->setFlash('success', 'Operation Done Successful ' . $success . ' Records Uploaded Successful');
                            $model->attributes = $modelsp->attributes = NULL;
                            if (!$batch_exists) {
                                $batch->delete();
                            }
                        }
                        ///reloading the page
                        $this->redirect(['institution/upload-students-admission']);
                        ///write outup to file
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="Admission students upload report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                    } else {
                        Yii::$app->session->setFlash('error', 'The Excel File Selected Is empty');
                    }
                }
            }
        }
        ////form current acaemic year
        $model->academic_year_id = $model_academic->academic_year_id;
        return $this->render('uploadAdmissionData', [
                    'model' => $model,
        ]);
    }

    public function actionConfirmUploadedStudents() {
        if (isset($_POST['selection']) && count($_POST['selection'])) {
            $count = 0;
            foreach ($_POST['selection'] as $key => $value) {
                if ((int) $value > 0) {
                    $student = AdmissionStudent::validFresherStudentAdmissionByID($value);
                    if ($student) {
                        $student->admission_status = AdmissionStudent::STATUS_CONFIRMED;
                        if ($student->save()) {
                            $count++;
                        }
                    }
                }
            }
            if ($count) {
                $sms = 'Operation Completed, "' . $count . '" students approved';
                Yii::$app->session->setFlash('success', $sms);
            } else {
                $sms = 'Operation Failed,Please check';
                Yii::$app->session->setFlash('failure', $sms);
            }
        }

        $this->redirect(['institution/student-admissions']);
    }

    public function actionVerifyUploadedStudents() {
//        var_dump($_POST);
    }

}
