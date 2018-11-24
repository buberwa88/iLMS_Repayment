<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\StudentExamResult;
use backend\modules\allocation\models\StudentExamResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StudentExamResultController implements the CRUD actions for StudentExamResult model.
 */
class StudentExamResultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all StudentExamResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelConfirmedStudExamReslt = new StudentExamResultSearch();
        $dataProviderConfirmedStudExamReslt = $searchModelConfirmedStudExamReslt->searchByCriteria(Yii::$app->request->queryParams,$status=1);
        ///get pending uploaded students examination results
        $searchModelPendingStudExamReslt = new StudentExamResultSearch();
        $dataProviderPendingStudExamReslt = $searchModelPendingStudExamReslt->searchByCriteria(Yii::$app->request->queryParams,$status=0);
        

        return $this->render('index', [
            'searchModelConfirmedStudExamReslt' => $searchModelConfirmedStudExamReslt,
            'dataProviderConfirmedStudExamReslt' => $dataProviderConfirmedStudExamReslt,
            'searchModelPendingStudExamReslt' => $searchModelPendingStudExamReslt,
            'dataProviderPendingStudExamReslt' => $dataProviderPendingStudExamReslt,
        ]);
    }

    /**
     * Displays a single StudentExamResult model.
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
     * Creates a new StudentExamResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentExamResult();
        $model->scenario = 'add_students_examination_results';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionUploadStudentsexamResults()
    {
            
        $searchModelStudentExamResult = new StudentExamResultSearch();
		$modelStudentExamResult = new StudentExamResult();
                
        $loggedin = Yii::$app->user->identity->user_id;		
        $dataProvider = $searchModelStudentExamResult->search(Yii::$app->request->queryParams);
                $modelStudentExamResult->scenario = 'students_exam_results_upload';
            if ($modelStudentExamResult->load(Yii::$app->request->post())) {
                $date_time = date("Y_m_d_H_i_s");
                $inputFiles1 = UploadedFile::getInstance($modelStudentExamResult, 'students_exam_results_file');
                $modelStudentExamResult->students_exam_results_file = UploadedFile::getInstance($modelStudentExamResult, 'students_exam_results_file');                
                $modelStudentExamResult->upload($date_time);
                $inputFiles = 'upload/' . $date_time . $inputFiles1;

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFiles);
                } catch (Exception $ex) {
                    die('Error');
                }
                $academicYear= $modelStudentExamResult->academic_year_id;
                $is_last_semester= $modelStudentExamResult->is_last_semester;
                $semester=$modelStudentExamResult->semester;
   
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();                
                if (strcmp($highestColumn, "F") == 0 && $highestRow >= 3) {
                    //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...
                    
                    
                    $row = 2;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);                   
                    //checking the template format
                    $s_sno=$rowData[0][0];
                    $RegistrationNumber=$rowData[0][1];
                    $F4IndexNo=$rowData[0][2];
                    $YearOfStudy=$rowData[0][3];
                    $ProgramCode=$rowData[0][4];
                    $Status=$rowData[0][5];
                                       
                    if(strcmp($s_sno,'S/No')==0 && strcmp($RegistrationNumber,'RegistrationNumber')==0 && strcmp($F4IndexNo,'F4IndexNo')==0 && strcmp($YearOfStudy,'YearOfStudy')==0 && strcmp($ProgramCode,'ProgramCode')==0 && strcmp($Status,'Status')==0){
                    //end check template format
                        $sn=$s_sno;
                    if ($sn == '') {
                        unlink('upload/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-studentsexam-results']);
                    } else {
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'STUDENTS EXAM. RESULTS UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:G1', 'STUDENTS EXAM. RESULTS UPLOAD REPORT');

                        $rowCount = 3;
                        $s_no = 0;
                        $customTitle = ['SNo', 'RegistrationNumber','F4IndexNo', 'YearOfStudy', 'ProgramCode' ,'Status' , 'Upload Status', 'Failed Reason'];
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);

                    for ($row = 3; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelStudentExamResult = new StudentExamResult();
                            $modelStudentExamResult->scenario = 'students_exam_results_upload2';
                            $modelStudentExamResult->registration_number = StudentExamResult::formatRowData($rowData[0][1]);
                            $modelStudentExamResult->f4indexno  = StudentExamResult::formatRowData($rowData[0][2]);
			    $modelStudentExamResult->study_year  = StudentExamResult::formatRowData($rowData[0][3]);
                            $modelStudentExamResult->programmeCode = StudentExamResult::formatRowData($rowData[0][4]);
			    $modelStudentExamResult->examStatus1 = StudentExamResult::formatRowData($rowData[0][5]);
                            $modelStudentExamResult->academic_year_id=$academicYear;
                            $modelStudentExamResult->is_last_semester=$is_last_semester;
                            
                            $examDetails=\backend\modules\allocation\models\ExamStatus::getExamStatusID($modelStudentExamResult->examStatus1);         
                            $modelStudentExamResult->exam_status_id=$examDetails->exam_status_id;
                            
                    $programmDetails=\backend\modules\allocation\models\Programme::getProgrammeByProgrammeCode($modelStudentExamResult->programmeCode);
                            
                            $modelStudentExamResult->programme_id=$programmDetails->programme_id;                            
                            $modelStudentExamResult->semester = $semester;
                            //$modelStudentExamResult->learning_institution_id=$learningInstitutionID;
                            //$modelStudentExamResult->is_active  = StudentExamResult::STATUS_PENDING;
                            //$programmeGroupCode = \backend\modules\allocation\models\ProgrammeGroup::getProgrammGroupID($programmeGroupCode);
                            //$modelProgramme->learning_institution_id=1;
                            //$modelProgramme->programme_group_id=$programmeGroupCode->programme_group_id;
							//$modelGepgBill->date_created='';
                            $modelStudentExamResult->validate();
                             $reason = '';
                             if($modelStudentExamResult->hasErrors()){
                                $errors = $modelStudentExamResult->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason.$value[0].'  ';									
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelStudentExamResult->registration_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelStudentExamResult->f4indexno);
			        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelStudentExamResult->study_year);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelStudentExamResult->programmeCode);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelStudentExamResult->examStatus1);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $reason);
                            unlink('upload/' . $date_time . $inputFiles1);
                                
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelStudentExamResult->registration_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelStudentExamResult->f4indexno);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelStudentExamResult->study_year);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelStudentExamResult->programmeCode);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelStudentExamResult->examStatus1);
                                $modelStudentExamResult->save();
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'UPLOADED SUCCESSFUL');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, 'N/A');                              
										
                            }                            
                        }                                                        
		        unlink('upload/' . $date_time . $inputFiles1);                      
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="Programmes upload report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                        //$writer->save('upload'."/programmes_".$date_time.".xls");
                        $currentFileName="programmes_".$date_time.".xls";                        
                        
                        $sms ="Programmes file submitted, kindly check the upload results in excel file!";                      
                        
                        Yii::$app->getSession()->setFlash('success', $sms);
                       // return $this->redirect(['bulk-upload']);
                        
                    }
                }else{
                    unlink('upload/' . $date_time . $inputFiles1);
                    $sms = '<p>Operation failed,excel template used has invalid format, please download sample from system and populate data!</p>';
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['upload-studentsexam-results']);
                }
                    
                }
                else{
                        unlink('upload/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-studentsexam-results']);
                }
            }
        return $this->render('uploadStudentsexamResults', [
                    'model'=>$modelStudentExamResult,
        ]);
        
    }

    /**
     * Updates an existing StudentExamResult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
    public function actionDelete($id)
    {
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
    protected function findModel($id)
    {
        if (($model = StudentExamResult::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
        public function actionDownloadTemplate()
{
    $path=Yii::getAlias('@webroot'). '/upload';
    $file=$path. '/students_exam_results_template.xlsx';
    if (file_exists($file)) {
        return Yii::$app->response->sendFile($file);
    } else {
        throw new \yii\web\NotFoundHttpException("{$file} is not found!");
    }
}
public function actionConfirmStudentsExam()
    {	

                   $loggedin=Yii::$app->user->identity->user_id;        
		   $selection=(array)Yii::$app->request->post('selection');//typecasting
		   foreach($selection as $student_exam_result_id){
		   //$employedBeneficiary->confirmBeneficiaryByEmployer($employerID,$employed_beneficiary_id);
                   $studentsResultsDetails = \backend\modules\allocation\models\StudentExamResult::findOne(['student_exam_result_id' => $student_exam_result_id]);
                   $studentsResultsDetails->confirmed  =  1;
                   $studentsResultsDetails->save();
		   }
		   if($student_exam_result_id !=''){
		   $sms="Students successful confirmed!";
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
}
