<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AdmissionStudent;
use backend\modules\allocation\models\AdmissionStudentSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\modules\allocation\models\AdmissionBatch;

/**
 * AdmissionStudentController implements the CRUD actions for AdmissionStudent model.
 */
class AdmissionStudentController extends Controller
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
     * Lists all AdmissionStudent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelConfirmed = new AdmissionStudentSearch();        
        $dataProviderConfirmed = $searchModelConfirmed->searchByCriteria(Yii::$app->request->queryParams,$status=1);
        ///////getting pending students for confirmation
        $searchModelPending = new AdmissionStudentSearch();
        $dataProviderPending = $searchModelPending->searchByCriteria(Yii::$app->request->queryParams,$status=0);
        return $this->render('index', [
            'searchModelConfirmed' => $searchModelConfirmed,
            'dataProviderConfirmed' => $dataProviderConfirmed,
            'searchModelPending' => $searchModelPending,
            'dataProviderPending' => $dataProviderPending,
        ]);
    }

    /**
     * Displays a single AdmissionStudent model.
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
     * Creates a new AdmissionStudent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
    public function actionCreate()
    {
        $model = new AdmissionStudent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->admission_student_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    */
    public function actionCreate()
    {
        
        $searchModelAdmissionStudent = new AdmissionStudentSearch();
		$modelAdmissionStudent = new AdmissionStudent();
                $modelAdmissionBatch = new AdmissionBatch();
                
        $loggedin = Yii::$app->user->identity->user_id;		
        $dataProvider = $searchModelAdmissionStudent->search(Yii::$app->request->queryParams);
                $modelAdmissionStudent->scenario = 'students_admission_bulk_upload';
            if ($modelAdmissionStudent->load(Yii::$app->request->post())) {
                $date_time = date("Y_m_d_H_i_s");
                $inputFiles1 = UploadedFile::getInstance($modelAdmissionStudent, 'students_admission_file');
         $modelAdmissionStudent->students_admission_file = UploadedFile::getInstance($modelAdmissionStudent, 'students_admission_file');                
                $modelAdmissionStudent->upload($date_time);
                $inputFiles = 'upload/' . $date_time . $inputFiles1;

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFiles);
                } catch (Exception $ex) {
                    die('Error');
                }
   
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();                
                if (strcmp($highestColumn, "I") == 0 && $highestRow >= 3) {
                    //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...
                    
                    
                    $row = 2;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);                   
                    //checking the template format
                    $s_sno=$rowData[0][0];
                    $F4IndexNo=$rowData[0][1];
                    $F6IndexNo=$rowData[0][2];
                    $AdmissionNo=$rowData[0][3];
                    $FirstName=$rowData[0][4];
                    $SecondName=$rowData[0][5];
                    $Surname=$rowData[0][6];
                    $Gender=$rowData[0][7];
                    $ProgrammeCode=$rowData[0][8];
                                       
                    if(strcmp($s_sno,'S/No')==0 && strcmp($F4IndexNo,'F4IndexNo')==0 && strcmp($F6IndexNo,'F6IndexNo')==0 && strcmp($AdmissionNo,'AdmissionNo')==0 && strcmp($FirstName,'FirstName')==0 && strcmp($SecondName,'SecondName')==0 && strcmp($Surname,'Surname')==0 && strcmp($Gender,'Gender')==0 && strcmp($ProgrammeCode,'ProgrammeCode')==0){
                    //end check template format
                        $sn=$s_sno;
                    if ($sn == '') {
                        unlink('upload/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['create']);
                    } else {
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'STUDENTS ADMISSION UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:G1', 'STUDENTS ADMISSION UPLOAD REPORT');

                        $rowCount = 3;
                        $s_no = 0;
                        $customTitle = ['SNo', 'F4IndexNo','F6IndexNo', 'AdmissionNo', 'FirstName','SecondName','Surname','Gender','ProgrammeCode','Upload Status', 'Failed Reason'];
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $customTitle[8]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $customTitle[9]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $customTitle[10]);
                                        
                                        //save batch
                                        $admissionBatchNumber=$modelAdmissionStudent->batch_number;
                                        $batchDetails=\backend\modules\allocation\models\AdmissionBatch::getAdmissionBatchID($admissionBatchNumber);
                                        if($batchDetails->admission_batch_id==''){
                                        $modelAdmissionBatch->academic_year_id=$modelAdmissionStudent->academic_year_id;
                                        $modelAdmissionBatch->batch_number=$modelAdmissionStudent->batch_number;
                                        $modelAdmissionBatch->batch_desc=$modelAdmissionStudent->batch_desc;                                    
                                        $modelAdmissionBatch->created_at=date("Y-m-d H:i:s"); 
                                        $modelAdmissionBatch->created_by=$loggedin; 
                                        $modelAdmissionBatch->save();
                                        $admissionBatchID=$modelAdmissionBatch->admission_batch_id;
                                        $academicYear=$modelAdmissionBatch->academic_year_id;
                                        }else{
                                        $admissionBatchID=$batchDetails->admission_batch_id;
                                        $academicYear=$batchDetails->academic_year_id;
                                        }

                                        //end save batch

                    for ($row = 3; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelAdmissionStudent = new AdmissionStudent();
                            $modelAdmissionStudent->scenario = 'students_admission_bulk_upload2';
                            $modelAdmissionStudent->f4indexno = AdmissionStudent::formatRowData($rowData[0][1]);
                            $modelAdmissionStudent->f6indexno = AdmissionStudent::formatRowData($rowData[0][2]);
                            $modelAdmissionStudent->admission_no = AdmissionStudent::formatRowData($rowData[0][3]);
                            $modelAdmissionStudent->firstname = AdmissionStudent::formatRowData($rowData[0][4]);
			    $modelAdmissionStudent->middlename = AdmissionStudent::formatRowData($rowData[0][5]);
                            $modelAdmissionStudent->surname = AdmissionStudent::formatRowData($rowData[0][6]);
			    $modelAdmissionStudent->gender = AdmissionStudent::formatRowData($rowData[0][7]);
                            $modelAdmissionStudent->course_code = AdmissionStudent::formatRowData($rowData[0][8]);
                            $programmDetails=\backend\modules\allocation\models\Programme::getProgrammeByProgrammeCode($modelAdmissionStudent->course_code);
                            
                            $modelAdmissionStudent->programme_id=$programmDetails->programme_id;  
                            $modelAdmissionStudent->institution_code=$programmDetails->institution_code;  
                            $modelAdmissionStudent->admission_batch_id=$admissionBatchID;
                            $modelAdmissionStudent->admission_status  = AdmissionStudent::STATUS_NOT_CONFIRMED;
                            $modelAdmissionStudent->academic_year_id=$academicYear;
                            $modelAdmissionStudent->study_year =1;
                            //$modelAdmissionStudent->batch_desc=$modelAdmissionStudent->batch_desc;
                            //$modelAdmissionStudent->students_admission_file=$modelAdmissionStudent->students_admission_file;
							//$modelGepgBill->date_created='';
                            $modelAdmissionStudent->validate();
                             $reason = '';
                             if($modelAdmissionStudent->hasErrors()){
                                $errors = $modelAdmissionStudent->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason.$value[0].'  ';									
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelAdmissionStudent->f4indexno);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelAdmissionStudent->f6indexno);
			        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelAdmissionStudent->admission_no);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelAdmissionStudent->firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelAdmissionStudent->middlename);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $modelAdmissionStudent->surname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $modelAdmissionStudent->gender);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $modelAdmissionStudent->course_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $reason);
                            unlink('upload/' . $date_time . $inputFiles1);
                                
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelAdmissionStudent->f4indexno);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelAdmissionStudent->f6indexno);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelAdmissionStudent->admission_no);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelAdmissionStudent->firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelAdmissionStudent->middlename);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $modelAdmissionStudent->surname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $modelAdmissionStudent->gender);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $modelAdmissionStudent->course_code);
                                $modelAdmissionStudent->save();
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, 'UPLOADED SUCCESSFUL');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, 'N/A');                              
										
                            }                            
                        }                                                        
		        unlink('upload/' . $date_time . $inputFiles1);                      
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="Admission students upload report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                        //$writer->save('upload'."/programmes_".$date_time.".xls");
                        $currentFileName="programmes_".$date_time.".xls";                        
                        
                        $sms ="Admissions students file submitted, kindly check the upload results in excel file!";                      
                        
                        Yii::$app->getSession()->setFlash('success', $sms);
                       // return $this->redirect(['bulk-upload']);
                        
                    }
                }else{
                    unlink('upload/' . $date_time . $inputFiles1);
                    $sms = '<p>Operation failed,excel template used has invalid format, please download sample from system and populate data!</p>';
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['create']);
                }
                    
                }
                else{
                        unlink('upload/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['create']);
                }
            }
        return $this->render('create', [
                'model' => $modelAdmissionStudent,
            ]);       
 
    }

    /**
     * Updates an existing AdmissionStudent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->admission_student_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdmissionStudent model.
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
     * Finds the AdmissionStudent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdmissionStudent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmissionStudent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDownloadTemplate()
{
    $path=Yii::getAlias('@webroot'). '/upload';
    $file=$path. '/admission_students_template.xlsx';
    if (file_exists($file)) {
        return Yii::$app->response->sendFile($file);
    } else {
        throw new \yii\web\NotFoundHttpException("{$file} is not found!");
    }
}
public function actionConfirmUploadedStudents()
    {	

                   $loggedin=Yii::$app->user->identity->user_id;        
		   $selection=(array)Yii::$app->request->post('selection');//typecasting
		   foreach($selection as $admission_student_id){
		   //$employedBeneficiary->confirmBeneficiaryByEmployer($employerID,$employed_beneficiary_id);
                   $admission_studentDetails = \backend\modules\allocation\models\AdmissionStudent::findOne(['admission_student_id' => $admission_student_id]);
                   $admission_studentDetails->admission_status =  1;
                   $admission_studentDetails->save();
		   }
		   if($admission_student_id !=''){
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
