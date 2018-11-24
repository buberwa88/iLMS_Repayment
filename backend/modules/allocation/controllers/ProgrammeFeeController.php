<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\ProgrammeCost;
use backend\modules\allocation\models\ProgrammeCostSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * ProgrammeFeeController implements the CRUD actions for ProgrammeFee model.
 */
class ProgrammeFeeController extends Controller {

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
     * Lists all ProgrammeFee models.
     * @return mixed
     */
//    public function actionIndex() {
//        $searchModel = new ProgrammeCostSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
    /**
     * Lists all Programme and their Fee yer Acaemic Year.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProgrammeCostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProgrammeFee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProgrammeFee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProgrammeCost();

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
     * Updates an existing ProgrammeFee model.
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
     * Deletes an existing ProgrammeFee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProgrammeFee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProgrammeFee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProgrammeFee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLoanItem($loan_item_value) {
        $this->layout = "default_main";

        $model = \backend\modules\allocation\models\LoanItem::findone($loan_item_value);
        return $model->rate_type;
    }

    public function actionGetprogrammename() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $learningId = $parents[0];
                //  $learningId=1;
                //  $programme_category_id =  implode(',', $parents[1]);
                $out = ProgrammeFee::getProgrammesIdAndNameByInstitution($learningId);

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    public function actionImport() {
        $model = new ProgrammeCost();
        $model->scenario = 'programme_cost_bulk_upload';
        if ($model->load(Yii::$app->request->post())) {

            $model_academic = \common\models\AcademicYear::findOne(["is_current" => 1]);
            /*
             * end 
             */
            $model->programmes_cost_import_file = UploadedFile::getInstance($model, 'programmes_cost_import_file');
            if ($model->programmes_cost_import_file != "") {
                $model->programmes_cost_import_file->saveAs('../uploadimage/upload/' . $model->programmes_cost_import_file->name);
                $model->programmes_cost_import_file = '../uploadimage/upload/' . $model->students_admission_file->name;
                //$model->save();
                $data = \moonland\phpexcel\Excel::widget([
                            'mode' => 'import',
                            'fileName' => $model->programmes_cost_import_file,
                            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                            'setIndexSheetByName' => FALSE, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                            'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
                if (count($data) > 0) {
                    $check = 0;
                    $objPHPExcelOutput = new \PHPExcel();
                    $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
                    $objPHPExcelOutput->setActiveSheetIndex(0);

                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'Sn');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B1', 'f4indexno');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C1', 'firstName');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D1', 'secondName');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E1', 'surname');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F1', 'programme_code');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G1', 'programme');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H1', 'institution_code');

                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I1', 'Comment');

                    $rowCount = 2;
                    $s_no = 1;
                    foreach ($data as $datas12) {
                        //check if exit
                        foreach ($datas12 as $label => $value) {
                            //print_r($label);
                            if ($label == "f4indexno") {
                                $check+=0;
                            } else if ($label == "firstName") {
                                $check+=0;
                            } else if ($label == "secondName") {
                                $check+=0;
                            } else if ($label == "surname") {
                                $check+=0;
                            } else if ($label == "programme_code") {
                                $check+=0;
                            } else if ($label == "programme") {
                                $check+=0;
                            } else if ($label == "institution_code") {
                                $check+=0;
                            } else if ($label == "Sn") {
                                $check+=0;
                            } else {
                                if ($label != "") {
                                    $check+=1;
                                }
                            }
                        }
                        // echo $datas12;

                        if ($check == 0) {
                            $f4index = $datas12["f4indexno"];

                            $firstname = $datas12["firstName"];
                            $middlename = $datas12["secondName"];
                            $lastname = $datas12["surname"];
                            $programme_code = $datas12["programme_code"];
                            $programme_name = $datas12["programme"];
                            $institution_code = $datas12["institution_code"];
                            $empty_field = 0;
                            $comment_empt = "";
                            if ($f4index == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Form 4 index Number , ";
                            }
                            if ($firstname == "") {
                                $empty_field++;
                                $comment_empt.=" Empty first Name ,";
                            }
                            if ($lastname == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Last Name , ";
                            }
                            if ($programme_code == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Programme Code , ";
                            }
                            if ($institution_code == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Institution Code ";
                            }
                            if ($empty_field == 0) {
                                ##############applicant exit in this academic year ###############
                                $model_exit = AdmissionStudent::findAll(['f4indexno' => $datas12["f4indexno"], 'academic_year_id' => $model_academic->academic_year_id]);
                                #################check end ######################################
                                if (count($model_exit) == 0) {

                                    $check12 = \backend\modules\application\models\Programme::findone(["learning_institution_id" => $model->learning_institution_id, "programme_code" => $programme_code]);
//                     $programId=$check12["programme_id"];
                                    if (count($check12) == 0) {
                                        $programme_status = 0;
                                        $programme_id = NULL;
                                    } else {
                                        $programme_status = 1;
                                        $programme_id = $check12["programme_id"];
                                    }
                                    $modelsp = new AdmissionStudent();
                                    $modelsp->f4indexno = $f4index;
                                    $modelsp->study_year = 1; ///settinf default student study year to be first year
                                    $modelsp->programme_id = $programme_id;
                                    $modelsp->firstname = $datas12["firstName"];
                                    $modelsp->middlename = $datas12["secondName"];
                                    $modelsp->surname = $datas12["surname"];
                                    $modelsp->course_code = $datas12["programme_code"];
                                    $modelsp->admission_status = $programme_status;
                                    $modelsp->institution_code = $datas12["institution_code"];
                                    $modelsp->academic_year_id = $model_academic->academic_year_id;
                                    $modelsp->created_by = Yii::$app->user->id;
                                    $modelsp->has_reported = 1;
                                    if ($modelsp->save(false)) {
                                        
                                    } else {
//                     print_r($modelsp->errors); 
//                     exit();
                                    }
                                } else {
                                    //Applicant already exit 

                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $f4index);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $firstname);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $middlename);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $lastname);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $programme_code);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_name);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $institution_code);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, 'Already Exist');
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
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $f4index);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $lastname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_name);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $institution_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $comment_empt);
                                $rowCount++;
                                $s_no++;
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'Sorry ! The Excel Label are case sensitive download new formate or change Label Name');
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'The Excel File Selected Is empty');
                }
            }
            $objPHPExcelOutput->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
            $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Admission students upload report.xls"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            return $this->render('importFee', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('importFee', [
                        'model' => $model,
            ]);
        }
    }

    /*
     * import progrmme costs basedon the agreed format
     */

    public function actionImportFee() {

        $model = new ProgrammeCost();

        if ($model->load(Yii::$app->request->post())) {
            /*
             * Academic year
             */
            $model_academic = \common\models\AcademicYear::findOne(["is_current" => 1]);
            /*
             * end 
             */
            $model->students_admission_file = UploadedFile::getInstance($model, 'students_admission_file');
            if ($model->students_admission_file != "") {
                $model->students_admission_file->saveAs('../uploadimage/upload/' . $model->students_admission_file->name);
                $model->students_admission_file = '../uploadimage/upload/' . $model->students_admission_file->name;
                //$model->save();
                $data = \moonland\phpexcel\Excel::widget([
                            'mode' => 'import',
                            'fileName' => $model->students_admission_file,
                            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                            'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
//                    print_r($data);
//                    exit();
                if (count($data) > 0) {
                    $check = 0;
                    $objPHPExcelOutput = new \PHPExcel();
                    $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
                    $objPHPExcelOutput->setActiveSheetIndex(0);

                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'Sn');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B1', 'f4indexno');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C1', 'firstName');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D1', 'secondName');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E1', 'surname');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F1', 'programme_code');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G1', 'programme');
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H1', 'institution_code');

                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I1', 'Comment');

                    $rowCount = 2;
                    $s_no = 1;
                    foreach ($data as $datas12) {
                        //check if exit
                        foreach ($datas12 as $label => $value) {
                            //print_r($label);
                            if ($label == "f4indexno") {
                                $check+=0;
                            } else if ($label == "firstName") {
                                $check+=0;
                            } else if ($label == "secondName") {
                                $check+=0;
                            } else if ($label == "surname") {
                                $check+=0;
                            } else if ($label == "programme_code") {
                                $check+=0;
                            } else if ($label == "programme") {
                                $check+=0;
                            } else if ($label == "institution_code") {
                                $check+=0;
                            } else if ($label == "Sn") {
                                $check+=0;
                            } else {
                                if ($label != "") {
                                    $check+=1;
                                }
                            }
                        }
                        // echo $datas12;

                        if ($check == 0) {
                            $f4index = $datas12["f4indexno"];

                            $firstname = $datas12["firstName"];
                            $middlename = $datas12["secondName"];
                            $lastname = $datas12["surname"];
                            $programme_code = $datas12["programme_code"];
                            $programme_name = $datas12["programme"];
                            $institution_code = $datas12["institution_code"];
                            $empty_field = 0;
                            $comment_empt = "";
                            if ($f4index == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Form 4 index Number , ";
                            }
                            if ($firstname == "") {
                                $empty_field++;
                                $comment_empt.=" Empty first Name ,";
                            }
                            if ($lastname == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Last Name , ";
                            }
                            if ($programme_code == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Programme Code , ";
                            }
                            if ($institution_code == "") {
                                $empty_field++;
                                $comment_empt.=" Empty Institution Code ";
                            }
                            if ($empty_field == 0) {
                                ##############applicant exit in this academic year ###############
                                $model_exit = AdmissionStudent::findAll(['f4indexno' => $datas12["f4indexno"], 'academic_year_id' => $model_academic->academic_year_id]);
                                #################check end ######################################
                                if (count($model_exit) == 0) {

                                    $check12 = \backend\modules\application\models\Programme::findone(["learning_institution_id" => $model->learning_institution_id, "programme_code" => $programme_code]);
//                     $programId=$check12["programme_id"];
                                    if (count($check12) == 0) {
                                        $programme_status = 0;
                                        $programme_id = NULL;
                                    } else {
                                        $programme_status = 1;
                                        $programme_id = $check12["programme_id"];
                                    }
                                    $modelsp = new AdmissionStudent();
                                    $modelsp->f4indexno = $f4index;
                                    $modelsp->study_year = 1; ///settinf default student study year to be first year
                                    $modelsp->programme_id = $programme_id;
                                    $modelsp->firstname = $datas12["firstName"];
                                    $modelsp->middlename = $datas12["secondName"];
                                    $modelsp->surname = $datas12["surname"];
                                    $modelsp->course_code = $datas12["programme_code"];
                                    $modelsp->admission_status = $programme_status;
                                    $modelsp->institution_code = $datas12["institution_code"];
                                    $modelsp->academic_year_id = $model_academic->academic_year_id;
                                    $modelsp->created_by = Yii::$app->user->id;
                                    $modelsp->has_reported = 1;
                                    if ($modelsp->save(false)) {
                                        
                                    } else {
//                     print_r($modelsp->errors); 
//                     exit();
                                    }
                                } else {
                                    //Applicant already exit 

                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $f4index);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $firstname);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $middlename);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $lastname);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $programme_code);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_name);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $institution_code);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, 'Already Exist');
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
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $f4index);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $lastname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $programme_name);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $institution_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $comment_empt);
                                $rowCount++;
                                $s_no++;
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'Sorry ! The Excel Label are case sensitive download new formate or change Label Name');
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'The Excel File Selected Is empty');
                }
            }
            $objPHPExcelOutput->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
            $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Admission students upload report.xls"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            return $this->render('create', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

}
