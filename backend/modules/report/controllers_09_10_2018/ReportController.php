<?php

namespace backend\modules\report\controllers;

use Yii;
use backend\modules\report\models\Report;
use backend\modules\report\models\ReportSearch;
use yii\web\Controller;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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

    public function actionViewOperation($id) {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
            //var_dump(Yii::$app->request->post());
            //exit;
            $model->file_name = UploadedFile::getInstance($model, 'file_name');
            if ($model->file_name != NULL && $model->file_name != '') {
                $model->file_name->saveAs(Yii::$app->params['reportTemplate'] . $model->file_name);
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
        $generatedBy = "Printed By " . Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname;
        $model = new Report();
        //$model->scenario='exportReport';
        if ($model->load(Yii::$app->request->post())) {
            $category = $model->category;
            $id = $model->uniqid;
            $pageIdentify = $model->pageIdentify;
            $exportCategory = $model->exportCategory;



            $modelReportTemplate = Report::findOne($id);
            $sql = $modelReportTemplate->sql;
            //return $sql;
            $where = '';
            $reportFilter = '';
            $reportFilterFinal = '';
            if (!empty($modelReportTemplate->sql_where)) {
                $where = ' where ' . $modelReportTemplate->sql_where;
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
                                $reportFilter = "$fieldValue  is  $applicantCategory->applicant_category AND ";
                            } else if ($typeValue == 'sex') {
                                if ($value == 'M') {
                                    $reportFilter = "$fieldValue  is  Male AND ";
                                } else {
                                    $reportFilter = "$fieldValue  is  Female AND ";
                                }
                            }else if ($typeValue == 'institution') {
                                $institution_name = \frontend\modules\application\models\LearningInstitution::findOne($value);
                                $reportFilter = "$fieldValue  is  $institution_name->institution_name AND ";
                            }else if ($typeValue == 'loan_item') {
                                $item_name = \backend\modules\allocation\models\LoanItem::findOne($value);
                                $reportFilter = "$fieldValue  is  $item_name->item_name AND ";
                            }else if ($typeValue == 'country') {
                                $country_name = \frontend\modules\application\models\Country::findOne($value);
                                $reportFilter = "$fieldValue  is  $country_name->country_name AND ";
                            }else if ($typeValue == 'programme_group') {
                                $group_name = \backend\modules\allocation\models\ProgrammeGroup::findOne($value);
                                $reportFilter = "$fieldValue  is  $group_name->group_name AND ";
                            }else if ($typeValue == 'scholarship_type') {
                                $scholarship_name = \backend\modules\allocation\models\ScholarshipDefinition::findOne($value);
                                $reportFilter = "$fieldValue  is  $scholarship_name->scholarship_name AND ";
                            }else if ($typeValue == 'academic_year') {
                                $academic_year = \common\models\AcademicYear::findOne($value);
                                $reportFilter = "$fieldValue  is  $academic_year->academic_year AND ";
                            } else {
                                $reportFilter = "$fieldValue  is  $value AND ";
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
                }
            }

            $sql .= ' ' . $where;

            if (!empty($modelReportTemplate->sql_group)) {
                $sql .= ' group by ' . $modelReportTemplate->sql_group;
            }

            if (!empty($modelReportTemplate->sql_order)) {
                $sql .= ' order by ' . $modelReportTemplate->sql_order;
            }
        }
        if (empty($reportFilterFinal)) {
            $reportFilterFinal_F = "";
        } else {
            $reportFilterFinal_F = " of " . preg_replace('/\W\w+\s*(\W*)$/', '$1', $reportFilterFinal);
        }
        $file_name = $modelReportTemplate->file_name;
        $reportName = "<strong>" . strtoupper($modelReportTemplate->name . " Report " . $reportFilterFinal_F) . "</strong>";
        $reportNameExcel = $modelReportTemplate->name . " Report " . $reportFilterFinal_F;
        $reportLabel = "report_" . date("Y_m_d_h_m_s");

        $dataExists = count($this->reportGenerate($sql));
        if ($dataExists > 0) {
            if ($exportCategory == 1) {

                if ($file_name != '' && $file_name != NULL) {
                    $htmlContent = $this->renderPartial($file_name, ['id' => $id, 'reportData' => $this->reportGenerate($sql), 'reportName' => $reportName]);
                    $generated_by = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname;



                    $mpdf = new mPDF();
                    //$mpdf->showImageErrors = true;
                    $mpdf->SetDefaultFontSize(8.0);
                    $mpdf->useDefaultCSS2 = true;
                    $mpdf->SetTitle('Report');
                    $mpdf->SetDisplayMode('fullpage');
                    //$mpdf->SetHeader($header);
                    $mpdf->SetFooter($generatedBy . '  |Page #{PAGENO} out of {nbpg} |Generated @ {DATE d/m/Y H:i:s}');
                    $mpdf->WriteHTML($htmlContent);
                    return $mpdf->Output($reportLabel, "D");
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

}
