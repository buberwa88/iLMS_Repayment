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
class ReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = "main_private";
    public function behaviors()
    {
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
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Report model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
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
    public function actionCreate()
    {
        $model = new Report();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
                
                $model->file_name = UploadedFile::getInstance($model, 'file_name');
               if($model->file_name != NULL && $model->file_name !=''){
                $model->file_name->saveAs(Yii::$app->params['reportTemplate'].$model->file_name);
                $extension=explode(".",$model->file_name);
                $model->file_name=$extension[0];
       }
                if($model->save()) {
            return $this->redirect(['index']);
                }} else {
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->validate()){ 
                
                $model->file_name = UploadedFile::getInstance($model, 'file_name');
               if($model->file_name != NULL && $model->file_name !=''){
                $model->file_name->saveAs(Yii::$app->params['reportTemplate'].$model->file_name);
                //$fileField="_formEmployerVerificationCode.php";
                $extension=explode(".",$model->file_name);
                $model->file_name=$extension[0];
               }
                if($model->save()) {
            return $this->redirect(['index']);
    }} else {
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
    public function actionDelete($id)
    {
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
    protected function findModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPrintReport() {
        $generatedBy="Printed By ".Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->surname;
        $model = new Report();
        //$model->scenario='exportReport';
        if ($model->load(Yii::$app->request->post())) {
        $category=$model->category;
        $id=$model->uniqid;
        $exportCategory=$model->exportCategory;
        }
        $modelReportTemplate = Report::findOne($id);
        $file_name = $modelReportTemplate->file_name;
        $reportName= strtoupper($modelReportTemplate->name." Report");
        
        if($exportCategory==1){
        
    $htmlContent = $this->renderPartial($file_name,['id' =>$id,'reportData'=>$this->reportGenerate($id),'reportName'=>$reportName]);
    $generated_by=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;
    
    
        if($file_name !='' && $file_name !=NULL){
 $mpdf = new mPDF(); 
 //$mpdf->showImageErrors = true;
 $mpdf->SetDefaultFontSize(8.0);
 $mpdf->useDefaultCSS2 = true; 
 $mpdf->SetTitle('Report');
 $mpdf->SetDisplayMode('fullpage');
 //$mpdf->SetHeader($header);
 $mpdf->SetFooter($generatedBy.'  |Page #{PAGENO} out of {nbpg} |Generated @ {DATE d/m/Y H:i:s}');
 $mpdf->WriteHTML($htmlContent);
return $mpdf->Output($reportName,"D");
    exit;
        }else{
           return $this->redirect(['index']); 
        }
        }else if($exportCategory==2){
                if($modelReportTemplate->name !='' && $modelReportTemplate->name !=NULL){
                    ob_start();
                    $this->GenerateExcel($this->reportGenerateExcel($id),$modelReportTemplate->name);
                    ob_clean();
                    ob_flush();   
                }else{
           return $this->redirect(['index']); 
        }
        }else{
           return $this->redirect(['index']);  
        }	
}

function reportGenerate($id) {
    $model = Report::findOne($id);
    $sql = $model->sql;
    //return $sql;
    $where = '';
    if (!empty($model->sql_where)) {
                    $where = ' where ' . $model->sql_where;
                }
    for ($i = 1; $i <= 5; $i++) {
                    $attr = 'input' . $i;
                    $column = 'column' . $i;
                    $condition = 'condition' . $i;
                    $type = 'type' . $i;
                    $typeValue = $model->$type;
                    $attrValue = $model->$attr;
                    $conditionValue = $model->$condition;
                    $columnValue = $model->$column;
                    if (!empty($_POST[$attr])) {
                        $value = $_POST[$attr];
                        if ($typeValue == 'date')
                            $value = date('Y-m-d', strtotime($value));

                        if ($condition == 'like') {
                            $mysearch = "$columnValue $conditionValue '%$value%'";
                        } else {
                            $mysearch = "$columnValue $conditionValue '$value'";
                        }
                        if (empty($where))
                            $where = " where $mysearch";
                        else
                            $where .= " and $mysearch";
                    }
                }
                $sql .= ' ' . $where;

                if (!empty($model->sql_group)) {
                    $sql .= ' group by ' . $model->sql_group;
                }

                if (!empty($model->sql_order)) {
                    $sql .= ' order by ' . $model->sql_order;
                }
                //$continue = false;
                $command = Yii::$app->db->createCommand($sql);
                $reportData=$command->queryAll();
                /*
                $row = $command->queryRow();
                $use_file = false;
                if (strlen($model->file_name) > 2)
                    $use_file = true;
                if (!empty($row)) {
                    $rs = $command->queryAll(false);
                    $keys = array_keys($row);
                    $continue = true;
                }
                 * 
                 */
    
return $reportData;    
}
function reportGenerateExcel($id) {
    $model = Report::findOne($id);
    $sql = $model->sql;
    //return $sql;
    $where = '';
    if (!empty($model->sql_where)) {
                    $where = ' where ' . $model->sql_where;
                }
    for ($i = 1; $i <= 5; $i++) {
                    $attr = 'input' . $i;
                    $column = 'column' . $i;
                    $condition = 'condition' . $i;
                    $type = 'type' . $i;
                    $typeValue = $model->$type;
                    $attrValue = $model->$attr;
                    $conditionValue = $model->$condition;
                    $columnValue = $model->$column;
                    if (!empty($_POST[$attr])) {
                        $value = $_POST[$attr];
                        if ($typeValue == 'date')
                            $value = date('Y-m-d', strtotime($value));

                        if ($condition == 'like') {
                            $mysearch = "$columnValue $conditionValue '%$value%'";
                        } else {
                            $mysearch = "$columnValue $conditionValue '$value'";
                        }
                        if (empty($where))
                            $where = " where $mysearch";
                        else
                            $where .= " and $mysearch";
                    }
                }
                $sql .= ' ' . $where;

                if (!empty($model->sql_group)) {
                    $sql .= ' group by ' . $model->sql_group;
                }

                if (!empty($model->sql_order)) {
                    $sql .= ' order by ' . $model->sql_order;
                }
                //$continue = false;
                $command = Yii::$app->db->createCommand($sql);
                /*
                $reportData=$command->queryAll();
                
                $row = $command->queryRow();
                $use_file = false;
                if (strlen($model->file_name) > 2)
                    $use_file = true;
                if (!empty($row)) {
                    $rs = $command->queryAll(false);
                    $keys = array_keys($row);
                    $continue = true;
                }
                 * 
                 */
    
return $command;    
}
     function GenerateExcel($command,$name){
         $generatedBy="Printed By ".Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->surname;
        //ob_start();
        $xlsName="report_".date("Y_m_d_h_m_s").".xls";



        //flush();

        //require_once('components/Classes/PHPExcel.php');

        //$objPHPExcel = new PHPExcel();
        $objPHPExcel = new \PHPExcel();

// Set document properties

        $objPHPExcel->getProperties()->setCreator($generatedBy)
            ->setLastModifiedBy($generatedBy)
            ->setTitle($name)
            ->setSubject($name)
            ->setDescription("An Excel document, generated from ".$generatedBy." by ".$generatedBy)
            ->setKeywords("office Excel report")
            ->setCategory($generatedBy." Generated File");


// Add some data
        $this->CellCreator($command,$objPHPExcel);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');


        $objWriter->save('php://output');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$xlsName");
        header("Pragma: no-cache");
        header("Expires: 0");
        exit;

        //return;
    }
   function CellCreator($command,$excelObject)
    {
        //$output = array();
        $rows = $command->queryOne();
        $query = $command->queryAll();
        //$columnArray=range('A','Z');
        $labelsArray=array_keys($rows);
        $excelObject->setActiveSheetIndex(0);
        $excelObject->getActiveSheet()->fromArray(array_values($labelsArray), NULL, 'A1');
        $excelObject->getActiveSheet()->fromArray(array_values($query), NULL, 'A2');
        return;

    }
}
