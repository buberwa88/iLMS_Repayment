<?php

namespace backend\modules\report\controllers;

use Yii;
use backend\modules\report\models\Report;
use backend\modules\report\models\ReportSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use mPDF;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends Controller {

    /**
     * @inheritdoc
     */
    public $layout = "main_private";

    public function behaviors() {
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
     * Lists all Report models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAllReports() {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->searchAllReportFilter(Yii::$app->request->queryParams);

        return $this->render('all_reports', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Report model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewOperation($id){
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->searchAllReportFilter(Yii::$app->request->queryParams);
        return $this->render('viewOperation', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Report();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            var_dump(Yii::$app->request->post());
//            exit;
            $model->file_name = UploadedFile::getInstance($model, 'file_name');
            if ($model->file_name != NULL && $model->file_name != '') {
                $report_template_nme=Yii::$app->params['reportTemplate'] . $model->file_name;
                //$model->file_name->saveAs(chmod($report_template_nme,0777));
                $model->file_name->saveAs($report_template_nme);
                $extension = explode(".", $model->file_name);
                $model->file_name = $extension[0];
            }
            if ($model->save()) {
                $sms = "<p>Report Created Successful</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->file_name = UploadedFile::getInstance($model, 'file_name');
            if ($model->file_name != NULL && $model->file_name != '') {
                $model->file_name->saveAs(Yii::$app->params['reportTemplate'] . $model->file_name);
                //$fileField="_formEmployerVerificationCode.php";
                $extension = explode(".", $model->file_name);
                $model->file_name = $extension[0];
            } else {
                $getDetails = \backend\modules\report\models\Report::findOne($id);
                $model->file_name = $getDetails->file_name;
            }
            if ($model->save()) {
                $sms = "<p>Information Updated Successful</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        
        $this->findModel($id)->delete();
        \backend\modules\report\models\ReportAccess::deleteAll(['report_id' => $id]);
        \backend\modules\report\models\PopularReport::deleteAll(['report_id' => $id]);        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintReport() {
        // $generatedBy = "Printed By " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname;
        $generatedBy = NULL;
        $searchParams = array();
        $model = new Report();
        //$model->scenario='exportReport';
        if ($model->load(Yii::$app->request->post())) {
//            var_dump($model->attributes);
//            exit;
            $category = $model->category;
            $id = $model->uniqid;
            $pageIdentify = $model->pageIdentify;
            $exportCategory = $model->exportCategory;
			$export_mode = $model->export_mode;
            $modelReportTemplate = Report::findOne($id);
            $sql = $modelReportTemplate->sql;
            $sql_subquery = $modelReportTemplate->sql_subquery;
            //return $sql;
            $where = $subquery_where = '';
            $reportFilter = '';
            $reportFilterFinal = '';
            $applicantCategorySet = '';
            if (!empty($modelReportTemplate->sql_where)) {
                $where = ' where ' . $modelReportTemplate->sql_where;
            }
            if (!empty($modelReportTemplate->sql_subquery_where)) {
                $subquery_where = ' where ' . $modelReportTemplate->sql_subquery_where;
            }
            $results = \backend\modules\report\models\ReportFilterSetting::find()
                    ->select('number_of_rows')
                    ->where(['is_active' => '1'])
                    ->orderBy(['report_filter_setting_id' => SORT_DESC])
                    ->one();
            //$number_of_rows=$results->number_of_rows;
            $number_of_rows = 15;
            for ($i = 1; $i <= $number_of_rows; $i++) {
                $attr = 'input' . $i;
                $column = 'column' . $i;
                $condition = 'condition' . $i;
                $type = 'type' . $i;
                $field = 'field' . $i;
                $typeValue = $modelReportTemplate->$type;
                $attrValue = $model->$attr;
                $conditionValue = $modelReportTemplate->$condition;
                $columnValue = $modelReportTemplate->$column;
                $fieldValue = $modelReportTemplate->$field;
                if (!empty($model->$attr)) {
                    $value = $model->$attr;

                    if ($typeValue == 'date')
                        $value = date('Y-m-d', strtotime($value));

                    if ($conditionValue == 'like') {
                        $mysearch = "$columnValue $conditionValue '%" . $value . "%'";
                        $reportFilter = "$fieldValue $conditionValue $value AND ";
                    } else {
                        $mysearch = "$columnValue $conditionValue '$value'";
                        if ($typeValue == 'date') {
                            $reportFilter = "$fieldValue  $value AND ";
                        } else {
                            if ($typeValue == 'applicant_category') {
                                $applicantCategory = \backend\modules\application\models\ApplicantCategory::findOne($value);
                                $reportFilter = "$fieldValue  :  $applicantCategory->applicant_category AND ";
                                $applicantCategorySet = $value;
                                $searchParams['applicant_category'] = $value;
                            } else if ($typeValue == 'sex') {
                                if ($value == 'M') {
                                    $reportFilter = "$fieldValue  :  Male AND ";
                                } else {
                                    $reportFilter = "$fieldValue  :  Female AND ";
                                }
                                $searchParams['sex'] = $value;
                            } else if ($typeValue == 'institution') {
                                $institution_name = \frontend\modules\application\models\LearningInstitution::findOne($value);
                                $reportFilter = "$fieldValue  :  $institution_name->institution_code AND ";
                                $searchParams['sex'] = $value;
                            } else if ($typeValue == 'loan_item') {
                                $item_name = \backend\modules\allocation\models\LoanItem::findOne($value);
                                $reportFilter = "$fieldValue  :  $item_name->item_name AND ";
                                $searchParams['loan_item']=$value;
                            } else if ($typeValue == 'country') {
                                $country_name = \frontend\modules\application\models\Country::findOne($value);
                                $reportFilter = "$fieldValue  :  $country_name->country_name AND ";
                                $searchParams['country']=$value;
                            } else if ($typeValue == 'programme_group') {
                                $group_name = \backend\modules\allocation\models\ProgrammeGroup::findOne($value);
                                $reportFilter = "$fieldValue  :  $group_name->group_name AND ";
                                 $searchParams['programme_group']=$value;
                            } else if ($typeValue == 'scholarship_type') {
                                $scholarship_name = \backend\modules\allocation\models\ScholarshipDefinition::findOne($value);
                                $reportFilter = "$fieldValue  :  $scholarship_name->scholarship_name AND ";
                                $searchParams['scholarship_type']=$value;
                            } else if ($typeValue == 'academic_year') {
                                $academic_year = \common\models\AcademicYear::findOne($value);
                                $reportFilter = "$fieldValue : $academic_year->academic_year AND ";
                                $searchParams['academic_year']=$value;
                            } else if ($typeValue == 'allocation_batch') {
                                $allocation_batch = \backend\modules\allocation\models\AllocationBatch::findOne($value);
                                $reportFilter = "$fieldValue : $allocation_batch->batch_number AND ";
                                $searchParams['allocation_batch']=$value;
                            }else if ($typeValue == 'form_storage') {
                                $formStorage = \common\models\FormStorage::findOne($value);
                                $reportFilter = "$fieldValue : $formStorage->folder_number AND ";
                                $searchParams['folder_number']=$value;
                            }else if ($typeValue == 'user') {
                                $userVal = \common\models\User::findOne($value);
								$nameUser=$userVal->firstname." ".$userVal->surname;
                                $reportFilter = "$fieldValue : $nameUser AND ";
                                $searchParams['user_id']=$value;
                            } else {
                                $reportFilter = "$fieldValue  :  $value AND ";
                            }
                        }

                        //$mysearch = "$columnValue $conditionValue '%".$value."%'";
                    }
                    if (empty($where)) {
                        $where = " where $mysearch";
                        $reportFilterFinal = $reportFilter;
                    } else {
                        $where .= " and $mysearch";
                        $reportFilterFinal.=$reportFilter;
                    }

                    if (empty($subquery_where)) {
                        $subquery_where = " where $mysearch";
                    } else {
                        $subquery_where .= " and $mysearch";
                    }
                }
            }

            $sql .= ' ' . $where;
            $sql_subquery .= ' ' . $subquery_where;

            if (!empty($modelReportTemplate->sql_group)) {
                $sql .= ' group by ' . $modelReportTemplate->sql_group;
            }

            if (!empty($modelReportTemplate->sql_order)) {
                $sql .= ' order by ' . $modelReportTemplate->sql_order;
            }

            if (!empty($modelReportTemplate->sql_subquery_group)) {
                $sql_subquery .= ' group by ' . $modelReportTemplate->sql_subquery_group;
            }

            if (!empty($modelReportTemplate->sql_subquery_order)) {
                $sql_subquery .= ' order by ' . $modelReportTemplate->sql_subquery_order;
            }
        }
        if (empty($reportFilterFinal)) {
            $reportFilterFinal_F = "";
        } else {
            $reportFilterFinal_F = "  " . preg_replace('/\W\w+\s*(\W*)$/', '$1', $reportFilterFinal);
        }
        $file_name = $modelReportTemplate->file_name;
        $printed_on = "Printed on " . date('l F d Y H:i A', time());
        $reportName = "<strong><center>" . strtoupper($modelReportTemplate->name . " Report <br>" . $reportFilterFinal_F) . "<br/> " . $printed_on . "<center/></strong>";
        $reportNameExcel = $modelReportTemplate->name . " Report " . $reportFilterFinal_F;
        $reportLabel = "report_" . date("Y_m_d_h_m_s");

        $dataExists = count($this->reportGenerate($sql));
        if ($dataExists > 0) {
            if ($exportCategory == 1) {

                if ($file_name != '' && $file_name != NULL) {
                    
                    if($modelReportTemplate->printing_mode ==1){
                     $this->renderPartial($file_name, ['id' => $id, 'reportData' => $this->reportGenerate($sql), 'reportSubQuery' => $sql_subquery, 'applicantCategory' => $applicantCategorySet, 'reportName' => $reportName, 'searchParams' => $searchParams]);   
                    }
                    
                    $htmlContent = $this->renderPartial($file_name, ['id' => $id, 'reportData' => $this->reportGenerate($sql), 'reportSubQuery' => $sql_subquery, 'applicantCategory' => $applicantCategorySet, 'reportName' => $reportName, 'searchParams' => $searchParams]);
                    
                    $generated_by = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname;

                      if($export_mode ==1){
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }else{
					$mpdf = new mPDF();
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
					$mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />                     
           </td>          
         </tr>
         <tr><td width='100%'>$reportName</td></tr>
             <tr><td width='100%'></td></tr>
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "D");
                    exit;
                } else {
                    $sms = "<p>Error: No Template Available</p>";
                    Yii::$app->getSession()->setFlash('danger', $sms);
                    if ($pageIdentify == '1') {
                        return $this->redirect(['view', 'id' => $id]);
                    } else if ($pageIdentify == '2') {
                        return $this->redirect(['view-operation', 'id' => $id]);
                    } else if ($pageIdentify == '3') {
                        return $this->redirect(['/report/popular-report/view', 'id' => $id]);
                    }
                }
            } else if ($exportCategory == 2) {
                if ($modelReportTemplate->name != '' && $modelReportTemplate->name != NULL) {
                    ob_start();
                    $this->GenerateExcel($this->reportGenerateExcel($sql), $reportNameExcel);
                    ob_clean();
                    ob_flush();
                } else {
                    $sms = "<p>Error: Missing Report Name</p>";
                    Yii::$app->getSession()->setFlash('danger', $sms);
                    if ($pageIdentify == '1') {
                        return $this->redirect(['view', 'id' => $id]);
                    } else if ($pageIdentify == '2') {
                        return $this->redirect(['view-operation', 'id' => $id]);
                    } else if ($pageIdentify == '3') {
                        return $this->redirect(['/report/popular-report/view', 'id' => $id]);
                    }
                }
            } else {
                $sms = "<p>Error: Missing Export Category</p>";
                Yii::$app->getSession()->setFlash('danger', $sms);
                if ($pageIdentify == '1') {
                    return $this->redirect(['view', 'id' => $id]);
                } else if ($pageIdentify == '2') {
                    return $this->redirect(['view-operation', 'id' => $id]);
                } else if ($pageIdentify == '3') {
                    return $this->redirect(['/report/popular-report/view', 'id' => $id]);
                }
            }
        } else {
            $sms = "<p>No record found</p>";
            Yii::$app->getSession()->setFlash('danger', $sms);
            if ($pageIdentify == '1') {
                return $this->redirect(['view', 'id' => $id]);
            } else if ($pageIdentify == '2') {
                return $this->redirect(['view-operation', 'id' => $id]);
            } else if ($pageIdentify == '3') {
                return $this->redirect(['/report/popular-report/view', 'id' => $id]);
            }
        }
    }

    function reportGenerate($sql) {
        $command = Yii::$app->db->createCommand($sql);
        $reportData = $command->queryAll();
        return $reportData;
    }

    function reportGenerateExcel($sql) {
        $command = Yii::$app->db->createCommand($sql);
        return $command;
    }

    function GenerateExcel($command, $name) {
        $generatedBy = "Printed By " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname;
        //ob_start();
        $xlsName = "report_" . date("Y_m_d_h_m_s") . ".xls";



        //flush();
        //require_once('components/Classes/PHPExcel.php');
        //$objPHPExcel = new PHPExcel();
        $objPHPExcel = new \PHPExcel();

// Set document properties

        $objPHPExcel->getProperties()->setCreator($generatedBy)
                ->setLastModifiedBy($generatedBy)
                ->setTitle($name)
                ->setSubject($name)
                ->setDescription("An Excel document, generated from " . $generatedBy . " by " . $generatedBy)
                ->setKeywords("office Excel report")
                ->setCategory($generatedBy . " Generated File");


// Add some data
        $this->CellCreator($command, $objPHPExcel, $name);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');


        $objWriter->save('php://output');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$xlsName");
        header("Pragma: no-cache");
        header("Expires: 0");
        exit;

        //return;
    }

    function CellCreator($command, $excelObject, $name) {
        //$output = array();
        $headerReport = strtoupper($name);
        $rows = $command->queryOne();
        $query = $command->queryAll();
        //$columnArray=range('A','Z');
        $labelsArray = array_keys($rows);
        $excelObject->setActiveSheetIndex(0);

        $styleArray = array('font' => array('bold' => true,
            )
        );

        $fromCol = 'A';
        $toCol = 'CU';
        $fromRow = 2;
        $toRow = 2;
        $cellRange = $fromCol . $fromRow . ':' . $toCol . $toRow;

        $excelObject->getActiveSheet()->SetCellValue('A1', $headerReport);
        $excelObject->setActiveSheetIndex(0)->mergeCells('A1:CU1', $headerReport);
        $excelObject->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
        $excelObject->getActiveSheet()->fromArray(array_values($labelsArray), NULL, 'A2');
        $excelObject->getActiveSheet()->getStyle($cellRange)->applyFromArray($styleArray);
        $excelObject->getActiveSheet()->fromArray(array_values($query), NULL, 'A3');
        return;
    }

    // UserController.php
// NOTE: You must set controller access rules for this action
// below to allow only specific user(s) to delete the image
    public function actionDeleteImage($id) {
        $model = Report::findOne($id);
        if ($model->deleteImage()) {
            //Yii::$app->session->setFlash('success', 
            //'Your image was removed successfully. Upload another by clicking Browse below');
            $sms = "<p>Your File was removed successfully. Upload another by clicking Browse below</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['update', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Error removing file. Please try again later or contact the system admin.');
        }
        return $this->render('update', ['model' => $model]);
    }
    
    
    public function actionPrintReportStudents() {
        // $generatedBy = "Printed By " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname;
        $generatedBy = NULL;
        $searchParams = array();
        $model = new Report();
        $modelApplication = new \backend\modules\application\models\Application();
        //$model->scenario='exportReport';
        //if($modelApplication->load(Yii::$app->request->post())){
            
            if (isset($_POST['Application'])) {
            $posted_data = Yii::$app->request->post();
            $id = $posted_data['Application']['uniqid'];
            $application_id = $posted_data['Application']['application_id'];
            $applicant_id = $posted_data['Application']['applicant_id'];
			$export_mode = $posted_data['Application']['export_mode'];
            if($id==''){
                $reportName="";
                $htmlContent="";
                      if($id !=4){
                    $mpdf = new mPDF();
                      }else{
                      
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />                     
           </td>          
         </tr>
         <tr><td width='100%'>$reportName</td></tr>
             <tr><td width='100%'></td></tr>
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                
            }
        //}
        //if ($model->load(Yii::$app->request->post())) {
//            var_dump($model->attributes);
//            exit;
            $category = $model->category;
            $exportCategory = $posted_data['Application']['exportCategory'];
            $pageIdentify = $posted_data['Application']['pageIdentifyStud'];
            $applicant_id = $posted_data['Application']['applicant_id'];
            $modelReportTemplate = Report::findOne($id);
            $sql = $modelReportTemplate->sql;
            $sql_subquery = $modelReportTemplate->sql_subquery;
            //return $sql;
            $where = $subquery_where = '';
            $reportFilter = '';
            $reportFilterFinal = '';
            $applicantCategorySet = '';
            $file_name = $modelReportTemplate->file_name;
            $printed_on = "Printed on " . date('l F d Y H:i A', time());            
            $resultsBanks=\backend\modules\repayment\models\BankAccount::find()->joinWith(['bank'])->all();
            $desc='';
            $count1=0;
                    foreach($resultsBanks AS $resultsBanksFound){
                        //if($count1==0){
                    $desc.=$resultsBanksFound->bank->bank_name." - ".$resultsBanksFound->account_number."<br/>";
                        //}
                    /*
                        if($count1==1){
                    $desc1=$resultsBanksFound->bank->bank_name." - ".$resultsBanksFound->account_number;
                        }
                        if($count1==2){
                    $desc2=$resultsBanksFound->bank->bank_name." - ".$resultsBanksFound->account_number;
                        }
                     * 
                     */
                        ++$count1;
                    }
                    if($id==19){
             $custtomerState="<br/><strong>CUSTOMER STATEMENT : REPAYMENTS</strong>";           
             $pritedOnside=$printed_on;
            }else if($id==20){
            $custtomerState="<br/><strong>CUSTOMER STATEMENT : REPAYMENT SCHEDULE</strong>";           
             $pritedOnside=$printed_on;
            }else{
			 $custtomerState="<hr>
         <strong>CUSTOMER STATEMENT</strong>
           <hr>"; 
             $pritedOnside="Loan Collection Acounts:<br/>".$desc."<br/>".$printed_on;	
			}
            if($modelReportTemplate->printing_mode ==1){
                     $reportLabel = "report_" . date("Y_m_d_h_m_s");
                     $printedBy="Printed By: " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname."<br/><br/>Verified By : ______________________________________________ ";
                     $htmlContent = $this->renderPartial($file_name, ['applicant_id' => $applicant_id]);
                     
                     
                     if($export_mode ==1){
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }else{
					$mpdf = new mPDF();
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->setAutoBottomMargin = 'stretch';
                    $logoHESLB=Yii::$app->params['HESLBlogo'].'logohelsb_new.jpg';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
            <img class='img' src='".$logoHESLB."' alt='' style='height: 70px;width: 70px;'>
             <br />
             Plot No. 8, Block No. 46; Sam Nujoma Rd; P.O Box 76068 Dar es Salaam, <strong>Tanzania</strong><br/>
             <strong>Tel: </strong>(General) +255 22 22772432/22772433;  <strong>Fax: </strong> +255 22 2700286; <strong>Email:</strong>repayment@heslb.go.tz;<br/>
             <strong>Website:</strong>www.heslb.go.tz
           </td>          
         </tr>
         <tr>
         <td width='100%' style='margin: 1%;text-align: center;'>
          ".$custtomerState."
           </td>
           </tr>
             

       </table></div>");

                    $mpdf->SetFooter($printedBy.'  |Page {PAGENO} of {nbpg} |<div style="text-align:left;font-size: 6pt;">'.$pritedOnside.'</div>');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                     
                    }
                    //exit;
            if (!empty($modelReportTemplate->sql_where)) {
                $where = ' where ' . $modelReportTemplate->sql_where.' AND allocation.application_id='.$application_id;
            }
            if (!empty($modelReportTemplate->sql_subquery_where)) {
                $subquery_where = ' where ' . $modelReportTemplate->sql_subquery_where.' AND allocation.application_id='.$application_id;
            }
            $results = \backend\modules\report\models\ReportFilterSetting::find()
                    ->select('number_of_rows')
                    ->where(['is_active' => '1'])
                    ->orderBy(['report_filter_setting_id' => SORT_DESC])
                    ->one();
            
              $getStudent = \backend\modules\application\models\Application::findBySql('SELECT user.firstname AS firstname,user.middlename,user.surname,education.registration_number AS regNumber,education.completion_year  FROM application INNER JOIN applicant ON  applicant.applicant_id=application.applicant_id INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN education ON education.application_id=application.application_id WHERE application.application_id = "'.$application_id.'" AND education.application_id ="'.$application_id.'" AND education.level="OLEVEL"')->one();
               $fullName="STUDENT NAME: ".$getStudent->firstname." ".$getStudent->middlename." ".$getStudent->surname." : ".$getStudent->regNumber.".".$getStudent->completion_year;
            
            //$number_of_rows=$results->number_of_rows;
            $number_of_rows = 15;
            $sql .= ' ' . $where;
            $sql_subquery .= ' ' . $subquery_where;

            if (!empty($modelReportTemplate->sql_group)) {
                $sql .= ' group by ' . $modelReportTemplate->sql_group;
            }

            if (!empty($modelReportTemplate->sql_order)) {
                $sql .= ' order by ' . $modelReportTemplate->sql_order;
            }

            if (!empty($modelReportTemplate->sql_subquery_group)) {
                $sql_subquery .= ' group by ' . $modelReportTemplate->sql_subquery_group;
            }

            if (!empty($modelReportTemplate->sql_subquery_order)) {
                $sql_subquery .= ' order by ' . $modelReportTemplate->sql_subquery_order;
            }
        //}
        }
        /*
        if (empty($reportFilterFinal)) {
            $reportFilterFinal_F = "";
        } else {
            $reportFilterFinal_F = "  " . preg_replace('/\W\w+\s*(\W*)$/', '$1', $reportFilterFinal);
        }
         * 
         */
        $reportFilterFinal_F=$fullName;
        $file_name = $modelReportTemplate->file_name;
        $printed_on = "Printed on " . date('l F d Y H:i A', time());
        $reportName = "<strong><center>" . strtoupper($modelReportTemplate->name . " Report <br>" . $reportFilterFinal_F) . "<br/> " . $printed_on . "<center/></strong>";
        $reportNameExcel = $modelReportTemplate->name . " Report " . $reportFilterFinal_F;
        $reportLabel = "report_" . date("Y_m_d_h_m_s");

        $dataExists = count($this->reportGenerate($sql));
        if ($dataExists > 0) {
            if ($exportCategory == 1) {

                if ($file_name != '' && $file_name != NULL) {
                    $htmlContent = $this->renderPartial($file_name, ['id' => $id, 'reportData' => $this->reportGenerate($sql), 'reportSubQuery' => $sql_subquery, 'applicantCategory' => $applicantCategorySet, 'reportName' => $reportName, 'searchParams' => $searchParams]);
                    $generated_by = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname;

                      if($export_mode ==1){
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }else{
					$mpdf = new mPDF();
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $logoHESLB=Yii::$app->params['HESLBlogo'].'logohelsb_new.jpg';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
          <td width='5%' style='text-align: left;'>
        <img class='img' src='".$logoHESLB."' alt='' style='height: 70px;width: 70px;'><br /></b>
            </td>
           <td width='95%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br /><br />
             $reportName
           </td>          
         </tr>         
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                }
            } 
        } else {
            $reportName="";
                $htmlContent="";
                      if($id !=4){
                    $mpdf = new mPDF();
                      }else{
                      
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />                     
           </td>          
         </tr>
         <tr><td width='100%'>$reportName</td></tr>
             <tr><td width='100%'></td></tr>
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                
        }
    }
	
	public function actionPrintReportStudaccount() {
        // $generatedBy = "Printed By " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname;
        $generatedBy = NULL;
        $searchParams = array();
        $model = new Report();
        $modelApplication = new \backend\modules\application\models\Application();
        //$model->scenario='exportReport';
        //if($modelApplication->load(Yii::$app->request->post())){
            
            if (isset($_POST['Application'])) {
            $posted_data = Yii::$app->request->post();
            $id = $posted_data['Application']['uniqid'];
            $application_id = $posted_data['Application']['application_id'];
            $applicant_id = $posted_data['Application']['applicant_id'];
			$export_mode = $posted_data['Application']['export_mode'];
            if($id==''){
                $reportName="";
                $htmlContent="";
                      if($id !=4){
                    $mpdf = new mPDF();
                      }else{
                      
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />                     
           </td>          
         </tr>
         <tr><td width='100%'>$reportName</td></tr>
             <tr><td width='100%'></td></tr>
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                
            }
        //}
        //if ($model->load(Yii::$app->request->post())) {
//            var_dump($model->attributes);
//            exit;
            $category = $model->category;
            $exportCategory = $posted_data['Application']['exportCategory'];
            $pageIdentify = $posted_data['Application']['pageIdentifyStud'];
            $applicant_id = $posted_data['Application']['applicant_id'];
            $modelReportTemplate = Report::findOne($id);
            $sql = $modelReportTemplate->sql;
            $sql_subquery = $modelReportTemplate->sql_subquery;
            //return $sql;
            $where = $subquery_where = '';
            $reportFilter = '';
            $reportFilterFinal = '';
            $applicantCategorySet = '';
            $file_name = $modelReportTemplate->file_name;
            $printed_on = "Printed on " . date('l F d Y H:i A', time());            
            $resultsBanks=\backend\modules\repayment\models\BankAccount::find()->joinWith(['bank'])->all();
            $desc='';
            $count1=0;
                    foreach($resultsBanks AS $resultsBanksFound){
                        //if($count1==0){
                    $desc.=$resultsBanksFound->bank->bank_name." - ".$resultsBanksFound->account_number."<br/>";
                        //}
                    /*
                        if($count1==1){
                    $desc1=$resultsBanksFound->bank->bank_name." - ".$resultsBanksFound->account_number;
                        }
                        if($count1==2){
                    $desc2=$resultsBanksFound->bank->bank_name." - ".$resultsBanksFound->account_number;
                        }
                     * 
                     */
                        ++$count1;
                    }
                    if($id==19){
             $custtomerState="<br/><strong>CUSTOMER STATEMENT : REPAYMENTS</strong>";           
             $pritedOnside=$printed_on;
            }else{
             $custtomerState="<hr>
         <strong>CUSTOMER STATEMENT</strong>
           <hr>"; 
             $pritedOnside="Loan Collection Acounts:<br/>".$desc."<br/>".$printed_on;
            }
            if($modelReportTemplate->printing_mode ==1){
                     $reportLabel = "report_" . date("Y_m_d_h_m_s");
                     $printedBy="Printed By: " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname."<br/><br/>Verified By : ______________________________________________ ";
                     $htmlContent = $this->renderPartial($file_name, ['applicant_id' => $applicant_id]);
                     
                     
                     if($export_mode ==1){
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }else{
					$mpdf = new mPDF();
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->setAutoBottomMargin = 'stretch';
                    $logoHESLB=Yii::$app->params['HESLBlogo'].'logohelsb_new.jpg';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
            <img class='img' src='".$logoHESLB."' alt='' style='height: 70px;width: 70px;'>
             <br />
             Plot No. 8, Block No. 46; Sam Nujoma Rd; P.O Box 76068 Dar es Salaam, <strong>Tanzania</strong><br/>
             <strong>Tel: </strong>(General) +255 22 22772432/22772433;  <strong>Fax: </strong> +255 22 2700286; <strong>Email:</strong>repayment@heslb.go.tz;<br/>
             <strong>Website:</strong>www.heslb.go.tz
           </td>          
         </tr>
         <tr>
         <td width='100%' style='margin: 1%;text-align: center;'>
          ".$custtomerState."
           </td>
           </tr>
             

       </table></div>");

                    $mpdf->SetFooter($printedBy.'  |Page {PAGENO} of {nbpg} |<div style="text-align:left;font-size: 6pt;">'.$pritedOnside.'</div>');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                     
                    }
                    //exit;
            if (!empty($modelReportTemplate->sql_where)) {
                $where = ' where ' . $modelReportTemplate->sql_where.' AND allocation.application_id='.$application_id;
            }
            if (!empty($modelReportTemplate->sql_subquery_where)) {
                $subquery_where = ' where ' . $modelReportTemplate->sql_subquery_where.' AND allocation.application_id='.$application_id;
            }
            $results = \backend\modules\report\models\ReportFilterSetting::find()
                    ->select('number_of_rows')
                    ->where(['is_active' => '1'])
                    ->orderBy(['report_filter_setting_id' => SORT_DESC])
                    ->one();
            /*
            $getStudent = \backend\modules\application\models\Application::find()
                    ->select('user.firstname,user.middlename,user.surname,education.registration_number,education.completion_year')
                    ->joinWith('applicant')
                    ->joinWith('applicant.user')
                    ->joinWith('educations')
                    ->where(['application.application_id' => $application_id,'education.application_id'=>$application_id,'education.level'=>'OLEVEL'])
                    ->one();
             * 
             */
            
              $getStudent = \backend\modules\application\models\Application::findBySql('SELECT user.firstname AS firstname,user.middlename,user.surname,education.registration_number AS regNumber,education.completion_year  FROM application INNER JOIN applicant ON  applicant.applicant_id=application.applicant_id INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN education ON education.application_id=application.application_id WHERE application.application_id = "'.$application_id.'" AND education.application_id ="'.$application_id.'" AND education.level="OLEVEL"')->one();
               $fullName="STUDENT NAME: ".$getStudent->firstname." ".$getStudent->middlename." ".$getStudent->surname." : ".$getStudent->regNumber.".".$getStudent->completion_year;
            
            //$number_of_rows=$results->number_of_rows;
            $number_of_rows = 15;
			
            $sql .= ' ' . $where;
            $sql_subquery .= ' ' . $subquery_where;

            if (!empty($modelReportTemplate->sql_group)) {
                $sql .= ' group by ' . $modelReportTemplate->sql_group;
            }

            if (!empty($modelReportTemplate->sql_order)) {
                $sql .= ' order by ' . $modelReportTemplate->sql_order;
            }

            if (!empty($modelReportTemplate->sql_subquery_group)) {
                $sql_subquery .= ' group by ' . $modelReportTemplate->sql_subquery_group;
            }

            if (!empty($modelReportTemplate->sql_subquery_order)) {
                $sql_subquery .= ' order by ' . $modelReportTemplate->sql_subquery_order;
            }
        //}
        }
        /*
        if (empty($reportFilterFinal)) {
            $reportFilterFinal_F = "";
        } else {
            $reportFilterFinal_F = "  " . preg_replace('/\W\w+\s*(\W*)$/', '$1', $reportFilterFinal);
        }
         * 
         */
        $reportFilterFinal_F=$fullName;
        $file_name = $modelReportTemplate->file_name;
        $printed_on = "Printed on " . date('l F d Y H:i A', time());
        $reportName = "<strong><center>" . strtoupper($modelReportTemplate->name . " Report <br>" . $reportFilterFinal_F) . "<br/> " . $printed_on . "<center/></strong>";
        $reportNameExcel = $modelReportTemplate->name . " Report " . $reportFilterFinal_F;
        $reportLabel = "report_" . date("Y_m_d_h_m_s");

        $dataExists = count($this->reportGenerate($sql));
        if ($dataExists > 0) {
            if ($exportCategory == 1) {

                if ($file_name != '' && $file_name != NULL) {
                    $htmlContent = $this->renderPartial($file_name, ['id' => $id, 'reportData' => $this->reportGenerate($sql), 'reportSubQuery' => $sql_subquery, 'applicantCategory' => $applicantCategorySet, 'reportName' => $reportName, 'searchParams' => $searchParams]);
                    $generated_by = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname;

                      if($export_mode ==1){
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }else{
					$mpdf = new mPDF();
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $logoHESLB=Yii::$app->params['HESLBlogo'].'logohelsb_new.jpg';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
          <td width='5%' style='text-align: left;'>
        <img class='img' src='".$logoHESLB."' alt='' style='height: 70px;width: 70px;'><br /></b>
            </td>
           <td width='95%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br /><br />
             $reportName
           </td>          
         </tr>         
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                }
            } 
        } else {
            $reportName="";
                $htmlContent="";
                      if($id !=4){
                    $mpdf = new mPDF();
                      }else{
                      
                    $mpdf = new mPDF('c','A4-L','','',5,5,30,25,10,10);
                      }
                    //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //$mpdf->showImageErrors = true;
                    //$mpdf->SetHTMLHeader('','',true);
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />                     
           </td>          
         </tr>
         <tr><td width='100%'>$reportName</td></tr>
             <tr><td width='100%'></td></tr>
       </table></div>");

                    

                    $mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel . '.pdf', "I");
                    exit;
                
        }
    }

}
