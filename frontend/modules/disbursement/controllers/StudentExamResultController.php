<?php

namespace frontend\modules\disbursement\controllers;

use Yii;
use backend\modules\allocation\models\StudentExamResult;
use backend\modules\allocation\models\StudentExamResultSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class StudentExamResultController extends \yii\web\Controller {
    /**
     * StudentExamResultController implements the CRUD actions for StudentExamResult model.
     */

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $this->layout = "main_hls_public";
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
     * Lists all StudentExamResult models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new StudentExamResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentExamResult model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentExamResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new StudentExamResult();

        if ($model->load(Yii::$app->request->post())) {

            /*
             * find the student 
             */
            $modelappl = \backend\modules\application\models\Application::findOne(["registration_number" => $model->registration_number]);
            /*
             * end 
             */
            $model->programme_id = $modelappl->programme_id;
            $model->f4indexno = $modelappl->f4indexno;
            $model->save();
            return $this->redirect(['view', 'id' => $model->student_exam_result_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionImportData() {
        $model = new StudentExamResult();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->file) {
                $model->save();
            }
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            //if($model->t!=""){
            $model->file->saveAs('uploadimage/upload/' . $model->file->name);
            $model->file = 'uploadimage/upload/' . $model->file->name;
            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $model->file,
                        'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                        'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                            //'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);
            $check = 0;
            $new_data = $updated_data = 0;

//            $arrayrejected[0] = array('RegistrationNumber' => 23, 'f4index#' => 2412, 'Name' => "micki", 'YearOfStudy' => 3, 'Sex' => 'F', 'Programme' => 'BSC SE', 'STATUS' => "Pass");
//            //$arrayrejected[1]=array('RegistrationNumber'=>23,'f4index#'=>2412,'Name'=>"micki",'YearOfStudy'=>3,'Sex'=>'F','Programme'=>'BSC SE','STATUS'=>"Pass");
//
//            print_r($arrayrejected);
//            exit();
            $arrayrejected=array();
            $m=0;
            if (count($data) > 0) {
                $arrayrejected = array();
                foreach ($data as $data12 => $datas12) {
                    foreach ($datas12 as $label => $key) {
                        ///print_r($label);
                        if ($label == "RegistrationNumber") {
                            $check+=0;
                        } else if ($label == "f4index#") {
                            $check+=0;
                        } else if ($label == "Name") {
                            $check+=0;
                        } else if ($label == "YearOfStudy") {
                            $check+=0;
                        } else if ($label == "Sex") {
                            $check+=0;
                        } else if ($label == "ProgrameName") {
                            $check+=0;
                        } else if ($label == "STATUS") {
                            $check+=0;
                        } else if ($label == "S/N") {
                            $check+=0;
                        }
                        else if ($label == "Comment") {
                            $check+=0;
                        }
                        else {
                            if ($label != "") {
                                $check+=1;
                                echo $label;
                            }
                        }

                        //$arrayrejected=array('RegistrationNumber'=>);
                    }
                    /*
                     * check if student exist or not 
                     */

                    /*
                     * end check student
                     */
                    /*
                     * Exam status  does not 
                     */
                    $f4 = $datas12["f4index#"];
                    $regNo = $datas12["RegistrationNumber"];
                    $yos = $datas12["YearOfStudy"];
                    $empty = 0;
                    if ($f4 == "") {
                        $comment = "Empty f4 Index #";
                        $arrayrejected[$m] = array('RegistrationNumber' => $regNo, 'f4index#' => $f4, 'Name' => $datas12["Name"], 'YearOfStudy' => $datas12["YearOfStudy"], 'Sex' => $datas12["Sex"], 'ProgrameName' => $datas12["ProgrameName"], 'STATUS' => $datas12["STATUS"], 'Comment' => $comment);
                        $empty+=1;
                        $m++;
                    }
                    if ($regNo == "") {
                        $comment = "Empty registration #";
                        $arrayrejected[$m] = array('RegistrationNumber' => $regNo, 'f4index#' => $f4, 'Name' => $datas12["Name"], 'YearOfStudy' => $datas12["YearOfStudy"], 'Sex' => $datas12["Sex"], 'ProgrameName' => $datas12["ProgrameName"], 'STATUS' => $datas12["STATUS"], 'Comment' => $comment);
                        $empty+=1;
                          $m++;
                    }
                    if ($yos == "") {
                        $comment = "Empty year of study";
                        $arrayrejected[$m] = array('RegistrationNumber' => $regNo, 'f4index#' => $f4, 'Name' => $datas12["Name"], 'YearOfStudy' => $datas12["YearOfStudy"], 'Sex' => $datas12["Sex"], 'ProgrameName' => $datas12["ProgrameName"], 'STATUS' => $datas12["STATUS"], 'Comment' => $comment);
                        $empty+=1;
                           $m++;
                    }
                    /*
                     * end log
                     */
                    if ($empty == 0) {
                        if ($check == 0) {
                            /*
                             * Check if exit in that university
                             */
                            $learnId = Yii::$app->session["learn_institution_id"];

                            $sqltest = Yii::$app->db->createCommand("SELECT count(*) FROM `application` ap join education ed on ap.`application_id`=ed.`application_id` join programme pr on pr.`programme_id`=ap.`programme_id` WHERE pr.`learning_institution_id`='{$learnId}' AND ap.`registration_number`='{$regNo}' AND  ed.`registration_number`='{$f4}'")->queryScalar();

                            /*
                             * end check
                             */
                            if (count($sqltest) > 0) {
                                $modeldata = \backend\modules\allocation\models\ExamStatus::find()->where(["like", 'status_desc', $datas12["STATUS"]])->one();
                                //insert data 
                                // echo $modeldata->exam_status_id;
                                //  print_r($modeldata);
                                // exit();
                                //print_r($data);
                                if (count($modeldata) > 0) {
                                    /*
                                     * check if exit
                                     */
                                    $modelexit = StudentExamResult::find()->where(["f4indexno" => $f4, "registration_number" => $regNo, 'academic_year_id' => $model->academic_year_id, 'study_year' => $datas12["YearOfStudy"], 'semester' => $model->semester])->all();
                                    if (count($modelexit) == 0) {
                                        $modelall = new StudentExamResult();
                                                $modelall->f4indexno = $datas12["f4index#"];
                                                $modelall->registration_number = $datas12["RegistrationNumber"];
                                                $modelall->academic_year_id = $model->academic_year_id;
                                                //$modelall->programme_id=;
                                                $modelall->study_year = $datas12["YearOfStudy"];
                                                $modelall->exam_status_id = $modeldata->exam_status_id;
                                                $modelall->semester = $model->semester;
                                        $modelall->save(false);
                                        $new_data+=1;
                                    } else {
                                        $sql = Yii::$app->db->createCommand("Update student_exam_result set exam_status_id='{$modeldata->exam_status_id}' where f4indexno='{$datas12["f4index#"]}' AND registration_number='{$datas12["RegistrationNumber"]}' AND academic_year_id='{$model->academic_year_id}' AND study_year='{$datas12["YearOfStudy"]}' AND semester='{$model->semester}'")->execute();
                                        $updated_data+=1;
                                    }
                                } else {
                                    /*
                                     * Exam status  does not 
                                     */
                                    $comment = "Incorrect Exam Status";
                                    $arrayrejected[$m] = array('RegistrationNumber' => $regNo, 'f4index#' => $f4, 'Name' => $datas12["Name"], 'YearOfStudy' => $datas12["YearOfStudy"], 'Sex' => $datas12["Sex"], 'ProgrameName' => $datas12["ProgrameName"], 'STATUS' => $datas12["STATUS"], 'Comment' => $comment);
                                    /*
                                     * end log
                                     */
                                       $m++;
                                }
                            } else {
                                /*
                                 * Applicant does not exit in this university
                                 */
                                $comment = "The combination Not Found";
                                $arrayrejected[$m] = array('RegistrationNumber' => $regNo, 'f4index#' => $f4, 'Name' => $datas12["Name"], 'YearOfStudy' => $datas12["YearOfStudy"], 'Sex' => $datas12["Sex"], 'ProgrameName' => $datas12["ProgrameName"], 'STATUS' => $datas12["STATUS"], 'Comment' => $comment);
                                /*
                                 * end log
                                 */
                                   $m++;
                            }
                        }
                    }
                    //end
                }
                Yii::$app->session->setFlash('success', "Well done  data processed successfully ; new data inserted is $new_data upadated  data is $updated_data ");
            }
             //print_r($arrayrejected);
             //exit();
                     if(count($arrayrejected)>0){
           return $this->renderPartial('rejected_examp_list.php',["model"=>$arrayrejected]);             
                     }
            return $this->redirect(['student-exam-result/index']);
        } else {
            return $this->render('import', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StudentExamResult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->student_exam_result_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StudentExamResult model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StudentExamResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentExamResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = StudentExamResult::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
