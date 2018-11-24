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
                    //'delete>[c' ='POST'],
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
    public function actionIndexpending()
    {
         $this->layout = "default_main";
        $searchModel= new StudentExamResultSearch();
        $dataProvider= $searchModel->searchByCriteria(Yii::$app->request->queryParams,0);
 
        return $this->render('_pending_studexamresult', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        
        ]);
    }
    public function actionIndexconfirm()
    {
         $this->layout = "default_main";
        $searchModel= new StudentExamResultSearch();
        $dataProvider= $searchModel->searchByCriteria(Yii::$app->request->queryParams,1);
 
        return $this->render('_confirmed_studexamresult', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        
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
             $this->layout = "default_main";
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
   public function actionCreatec()
    {
             $this->layout = "default_main";
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
//    public function actionUploadStudentsexamResults()
//    {
//            $this->layout = "default_main";
//            
//                $searchModelStudentExamResult = new StudentExamResultSearch();
//		$modelStudentExamResult = new StudentExamResult();
//        $loggedin = Yii::$app->user->identity->user_id;		
//        $dataProvider = $searchModelStudentExamResult->search(Yii::$app->request->queryParams);
//                $modelStudentExamResult->scenario = 'students_exam_results_upload';
//            if ($modelStudentExamResult->load(Yii::$app->request->post())) {
//                $date_time = date("Y_m_d_H_i_s");
//                $inputFiles1 = UploadedFile::getInstance($modelStudentExamResult, 'students_exam_results_file');
//                $modelStudentExamResult->students_exam_results_file = UploadedFile::getInstance($modelStudentExamResult, 'students_exam_results_file');                
//                $modelStudentExamResult->upload($date_time);
//                $inputFiles = 'upload/' . $date_time . $inputFiles1;
//
//                try {
//                    $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
//                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
//                    $objPHPExcel = $objReader->load($inputFiles);
//                } catch (Exception $ex) {
//                    die('Error');
//                }
//                $academicYear= $modelStudentExamResult->academic_year_id;
//                $is_last_semester= $modelStudentExamResult->is_last_semester;
//                $semester=$modelStudentExamResult->semester;
//   
//                $sheet = $objPHPExcel->getSheet(0);
//                $highestRow = $sheet->getHighestRow();
//                $highestColumn = $sheet->getHighestColumn();                
//                if (strcmp($highestColumn, "F") == 0 && $highestRow >= 3) {
//                    //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...
//                    $row = 2;
//                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);                   
//                    //checking the template format
//                    $s_sno=$rowData[0][0];
//                    $RegistrationNumber=$rowData[0][1];
//                    $F4IndexNo=$rowData[0][2];
//                    $YearOfStudy=$rowData[0][3];
//                    $ProgramCode=$rowData[0][4];
//                    $Status=$rowData[0][5];
//                                       
//                    if(strcmp($s_sno,'S/No')==0 && strcmp($RegistrationNumber,'RegistrationNumber')==0 && strcmp($F4IndexNo,'F4IndexNo')==0 && strcmp($YearOfStudy,'YearOfStudy')==0 && strcmp($ProgramCode,'ProgramCode')==0 && strcmp($Status,'Status')==0){
//                    //end check template format
//                        $sn=$s_sno;
//                    if ($sn == '') {
//                        unlink('upload/' . $date_time . $inputFiles1);
//                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
//                        Yii::$app->getSession()->setFlash('error', $sms);
//                        return $this->redirect(['upload-studentsexam-results']);
//                    } else {
//                        $objPHPExcelOutput = new \PHPExcel();
//                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
//                        $objPHPExcelOutput->setActiveSheetIndex(0);
//                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'STUDENTS EXAM. RESULTS UPLOAD REPORT');
//                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:G1', 'STUDENTS EXAM. RESULTS UPLOAD REPORT');
//
//                        $rowCount = 3;
//                        $s_no = 0;
//                        $customTitle = ['SNo', 'RegistrationNumber','F4IndexNo', 'YearOfStudy', 'ProgramCode' ,'Status' , 'Upload Status', 'Failed Reason'];
//                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
//                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
//                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
//                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
//                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
//                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
//		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
//		    $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
//
//                    for ($row = 3; $row <= $highestRow; ++$row) {
//                            $s_no++;
//                            $rowCount++;
//                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
//                            $modelStudentExamResult = new StudentExamResult();
//                            $modelStudentExamResult->scenario = 'students_exam_results_upload2';
//                            $modelStudentExamResult->registration_number = StudentExamResult::formatRowData($rowData[0][1]);
//                            $modelStudentExamResult->f4indexno  = StudentExamResult::formatRowData($rowData[0][2]);
//			    $modelStudentExamResult->study_year  = StudentExamResult::formatRowData($rowData[0][3]);
//                            $modelStudentExamResult->programmeCode = StudentExamResult::formatRowData($rowData[0][4]);
//			    $modelStudentExamResult->examStatus1 = StudentExamResult::formatRowData($rowData[0][5]);
//                            $modelStudentExamResult->academic_year_id=$academicYear;
//                            $modelStudentExamResult->is_last_semester=$is_last_semester;
//                            
//                            $examDetails=\backend\modules\allocation\models\ExamStatus::getExamStatusID($modelStudentExamResult->examStatus1);         
//                            $modelStudentExamResult->exam_status_id=$examDetails->exam_status_id;
//                            
//                    $programmDetails=\backend\modules\allocation\models\Programme::getProgrammeByProgrammeCode($modelStudentExamResult->programmeCode);
//                            
//                            $modelStudentExamResult->programme_id=$programmDetails->programme_id;                            
//                            $modelStudentExamResult->semester = $semester;
//                            //$modelStudentExamResult->learning_institution_id=$learningInstitutionID;
//                            //$modelStudentExamResult->is_active  = StudentExamResult::STATUS_PENDING;
//                            //$programmeGroupCode = \backend\modules\allocation\models\ProgrammeGroup::getProgrammGroupID($programmeGroupCode);
//                            //$modelProgramme->learning_institution_id=1;
//                            //$modelProgramme->programme_group_id=$programmeGroupCode->programme_group_id;
//							//$modelGepgBill->date_created='';
//                            $modelStudentExamResult->validate();
//                             $reason = '';
//                             if($modelStudentExamResult->hasErrors()){
//                                $errors = $modelStudentExamResult->errors;
//                                foreach ($errors as $key => $value) {
//                                    $reason = $reason.$value[0].'  ';									
//                                }
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelStudentExamResult->registration_number);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelStudentExamResult->f4indexno);
//			        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelStudentExamResult->study_year);
//				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelStudentExamResult->programmeCode);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelStudentExamResult->examStatus1);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'UPLOADED FAILED');
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $reason);
//                            unlink('upload/' . $date_time . $inputFiles1);
//                                
//                            } else {
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelStudentExamResult->registration_number);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelStudentExamResult->f4indexno);
//				$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelStudentExamResult->study_year);
//				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelStudentExamResult->programmeCode);
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelStudentExamResult->examStatus1);
//                                $modelStudentExamResult->save();
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'UPLOADED SUCCESSFUL');
//                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, 'N/A');                              
//										
//                            }                            
//                        }                                                        
//		        unlink('upload/' . $date_time . $inputFiles1);                      
//                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
//                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
//                        header('Content-Type: application/vnd.ms-excel');
//                        header('Content-Disposition: attachment;filename="Programmes upload report.xls"');
//                        header('Cache-Control: max-age=0');
//                        $writer->save('php://output');
//                        //$writer->save('upload'."/programmes_".$date_time.".xls");
//                        $currentFileName="programmes_".$date_time.".xls";                        
//                        
//                        $sms ="Programmes file submitted, kindly check the upload results in excel file!";                      
//                        
//                        Yii::$app->getSession()->setFlash('success', $sms);
//                       // return $this->redirect(['bulk-upload']);
//                        
//                    }
//                }else{
//                    unlink('upload/' . $date_time . $inputFiles1);
//                    $sms = '<p>Operation failed,excel template used has invalid format, please download sample from system and populate data!</p>';
//                    Yii::$app->getSession()->setFlash('error', $sms);
//                    return $this->redirect(['upload-studentsexam-results']);
//                }
//                    
//                }
//                else{
//                        unlink('upload/' . $date_time . $inputFiles1);
//                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
//                        Yii::$app->getSession()->setFlash('error', $sms);
//                        return $this->redirect(['upload-studentsexam-results']);
//                }
//            }
//        return $this->render('uploadStudentsexamResults', [
//                    'model'=>$modelStudentExamResult,
//        ]);
//        
//    }
    public function actionUploadStudentsexamResults()
    {
            $this->layout = "default_main";
                $model= new StudentExamResult();
                $loggedin = Yii::$app->user->identity->user_id;		
               if ($model->load(Yii::$app->request->post())) {
                  $model->students_exam_results_file=UploadedFile::getInstance($model,'students_exam_results_file');
                 if($model->students_exam_results_file!=""){
                   $model->students_exam_results_file->saveAs('../staff/upload/temp/'.$model->students_exam_results_file->name);                  
                    $model->students_exam_results_file='../staff/upload/temp/'.$model->students_exam_results_file->name;
                    //$model->save();
                    $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import', 
                        'fileName' => $model->students_exam_results_file, 
                        'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                        'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                       // 'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                    ]);
                       if(count($data)>0){
                           $check=0;
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
        
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1','Sn');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B1','f4indexno');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C1', 'firstName');
			        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D1', 'secondName');
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E1', 'surname');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F1', 'programme_code');
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('G1','programme');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H1','institution_code');
                                
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I1', 'Comment');
                      
                        $rowCount = 2;
                        $s_no = 1;
                 foreach ($data as $datas12){
                 //check if exit
                
                 foreach ($datas12 as $label=>$value){
//                   print_r($);
//                         //print_r($datas12);
//                     exit();
                       if($label=="f4indexno"){
                       $check+=0;    
                       }
                       else if($label=="RegistrationNumber"){
                       $check+=0;    
                       }
                      else if($label=="YearOfStudy"){
                       $check+=0;    
                       }
                     else if($label=="programme_code"){
                       $check+=0;    
                       }
                   else if($label=="Status"){
                       $check+=0;    
                       }
                   else if($label=="Sn"){
                       $check+=0;    
                       }
                   else{
                        if($label!=""){
                        $check+=1;
                        
                        }
                       }
                    //end label checking
                #########################
                ######## not a required formate ########
                            
                    if($check==0){
                           $f4index=$datas12["f4indexno"];
                        
                           $YearOfStudy=$datas12["YearOfStudy"];
                           $registration_number=$datas12["RegistrationNumber"];
                           $programme_code=$datas12["programme_code"];
                          
                               $empty_field=0;
                               $comment_empt="";
                                  if($f4index==""){
                                   $empty_field++;  
                                  $comment_empt.="Form 4 index Number is empty, ";
                                    }
                                 if($YearOfStudy==""){
                                   $empty_field++;  
                                   $comment_empt.="Year Of Study is empty,";
                                  }
                                if($registration_number==""){
                                 $empty_field++; 
                                 $comment_empt.=" Registration Number is empty  , ";
                                  }
                                if($programme_code==""){
                                  $empty_field++;  
                                 $comment_empt.=" Empty Programme Code , ";
                                  }
                                
                               if($empty_field==0){
                  #####################check if applicant has a programme on that registration number ,yos and programme_code#########
                  $model_exit_proramme_id=  StudentExamResult::findProgramme($programme_code,$registration_number,$YearOfStudy);
                      if(count($model_exit_proramme_id)>0){
                  ##############applicant exit in this academic year ###############
                    $model_exit=  StudentExamResult::findone(['f4indexno'=>$datas12["f4indexno"],'academic_year_id'=>$model->academic_year_id,'registration_number'=>$registration_number,'programme_id'=>$programme_id,'study_year'=>$YearOfStudy]);
                  #################check end ######################################
                    //SELECT pr.`programme_id` programme_id FROM `application` ap  join  programme pr   on ap.`programme_id`=pr.`programme_id`  where `programme_code`= AND `registration_number` AND `current_study_year`
                      if(count($model_exit)==0){
                
                  $check12=  \backend\modules\application\models\Programme::findone(["learning_institution_id"=>$model->learning_institution_id, "programme_code"=>$programme_code]);
//                     $programId=$check12["programme_id"];
                  if(count($check12)==0){
                     $programme_status=0;
                      $programme_id=NULL;
                      }
                      else{
                      $programme_status=1;  
                      $programme_id=$check12["programme_id"];
                      }
                      $modelsp= new AdmissionStudent();
                            $modelsp->f4indexno=$f4index;
                            $modelsp->study_year=1;///settinf default student study year to be first year
                            $modelsp->programme_id=$programme_id;
                            $modelsp->firstname=$datas12["firstName"];
                            $modelsp->middlename=$datas12["secondName"];
                            $modelsp->surname=$datas12["surname"];
                            $modelsp->course_code=$datas12["programme_code"];
                            $modelsp->admission_status=$programme_status;
                            $modelsp->institution_code=$datas12["institution_code"];
                            $modelsp->academic_year_id=$model_academic->academic_year_id;
                            $modelsp->created_by=  Yii::$app->user->id;
                            $modelsp->has_reported=1;
                     if($modelsp->save(false)){
                         
                     }
                     else{
//                     print_r($modelsp->errors); 
//                     exit();
                     }
                   }
                   else{
                       //Applicant already exit 
                     
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $registration_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $f4index);
			        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $YearOfStudy);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $status);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'Already Exist');
                         $rowCount++;
                         $s_no++;
                   }
                  }
                    else{
                       //Applicant already exit 
                     
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $registration_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $f4index);
			        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $YearOfStudy);
				$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $status);
			 
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'Failed ! The combination of registration Number,programme code and year of study');
                         $rowCount++;
                         $s_no++;
                   }
                   //end
           // Yii::$app->session->setFlash('success', 'Information Upload Successfully'); 
                    }
                    else{
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
                    }
                   else{
              Yii::$app->session->setFlash('error', 'Sorry ! The Excel Label are case sensitive download new formate or change Label Name');            
                   }
                 }
                 }
                       }
                 
             
                }
               }
        return $this->render('uploadStudentsexamResults', [
                    'model'=>$model,
        ]);
        
    }
    /**
     * Updates an existing StudentExamResult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$url)
    {
             $this->layout = "default_main";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([$url]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdatec($id)
    {
             $this->layout = "default_main";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['indexconfirm']);
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
    public function actionDeletec($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['indexconfirm']);
    }
  public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['indexpending']);
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
