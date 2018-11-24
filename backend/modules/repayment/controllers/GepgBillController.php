<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\GepgBill;
use backend\modules\repayment\models\GepgBillSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

//use frontend\modules\application\rabbit\Producer;
//use PhpAmqpLib\Connection\AMQPStreamConnection;
//use PhpAmqpLib\Message\AMQPMessage;

/**
 * GepgBillController implements the CRUD actions for GepgBill model.
 */
class GepgBillController extends Controller
{
    /**
     * @inheritdoc
     */
	 public $layout="main_private";
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
     * Lists all GepgBill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GepgBillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GepgBill model.
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
     * Creates a new GepgBill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GepgBill();
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GepgBill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
	 /*
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	*/
	
	public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'Cancell_bill';
        if ($model->load(Yii::$app->request->post())){
        $model->status=1;
        }
		if($model->load(Yii::$app->request->post()) && $model->save()) {

		//take cancelled bill in queue
		    $reconMasterID=$model->id;
			$BillId1 = $model->bill_number;
			$SpCode='SP111';
			$SpSysId='LHESLB001';
            			//echo $SpReconcReqId;
			$dataToQueue = ["SpCode" => $SpCode, 
                                     "SpSysId"=>$SpSysId, 
                                     "BillId1"=>$BillId1]; 
                                     
            if($reconMasterID >0){
            //Producer::queue("GePGBillCancellationRequestQueue", $dataToQueue);
			
			$query3 = "UPDATE gepg_bill SET cancel_requsted_status='0' WHERE id='".$reconMasterID."'";
             Yii::$app->db->createCommand($query3)->execute();
			 }
		//end take cancelled bill in queue
		
          return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GepgBill model.
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
     * Finds the GepgBill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GepgBill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GepgBill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
		
		public function actionUploadControllNumber() {
        $this->layout = "main_private";		
        $searchModelGepgBill = new GepgBillSearch();
		$modelGepgBill = new GepgBill();
        $loggedin = Yii::$app->user->identity->user_id;		
        $dataProvider = $searchModelGepgBill->search(Yii::$app->request->queryParams);
                $modelGepgBill->scenario = 'Control_number_upload2';
            if ($modelGepgBill->load(Yii::$app->request->post())) {
                $date_time = date("Y_m_d_H_i_s");
                $inputFiles1 = UploadedFile::getInstance($modelGepgBill, 'controlNumberFile');
                $modelGepgBill->controlNumberFile = UploadedFile::getInstance($modelGepgBill, 'controlNumberFile');
                $modelGepgBill->upload($date_time);
                $inputFiles = 'uploadscontrolnumber/' . $date_time . $inputFiles1;

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

                if (strcmp($highestColumn, "D") == 0 && $highestRow >= 2) {
                    //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...
                    $row = 2;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $sn = $rowData[0][0];
                    if ($sn == '') {
                        unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                    } else {
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'CONTROL NUMBERS UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:F1', 'CONTROL NUMBER UPLOAD REPORT');

                        $rowCount = 2;
                        $s_no = 0;
                        $customTitle = ['SNo', 'BILL NUMBER', 'CONTROL NUMBER', 'DATE', 'UPLOAD STATUS', 'FAILED REASON'];
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);

                    for ($row = 2; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelGepgBill = new GepgBill();
                            $modelGepgBill->scenario = 'Control_number_upload';
                            $modelGepgBill->bill_number = GepgBill::formatRowData($rowData[0][1]);
                            $modelGepgBill->control_number = GepgBill::formatRowData($rowData[0][2]);
							$modelGepgBill->date_created = GepgBill::formatRowData($rowData[0][3]);
							//$modelGepgBill->date_created='';
							$control_number=$modelGepgBill->control_number;
							$bill_number=$modelGepgBill->bill_number;
                            $modelGepgBill->validate();
                             $reason = '';
                             if($modelGepgBill->hasErrors()){
                                $errors = $modelGepgBill->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason.$value[0].'  ';									
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelGepgBill->bill_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelGepgBill->control_number);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelGepgBill->date_created);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $reason);
                            unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelGepgBill->bill_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelGepgBill->control_number);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelGepgBill->date_created);
                                $modelGepgBill->save();
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, 'UPLOADED SUCCESSFUL');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, 'N/A');

                            $query3Bill = "UPDATE gepg_bill SET control_number ='".$control_number."' WHERE bill_number='".$bill_number."'";
                            Yii::$app->db->createCommand($query3Bill)->execute(); 								
                            }
                        }
						unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:F' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="control number upload report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                    }
                }
                else{
                        unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                }
            }
        return $this->render('uploadcontrollnumber', [
                    'model'=>$modelGepgBill,
        ]);
    }
	
	public function actionUploadError()
    {
        $this->layout="main_private"; 
        $model = new GepgBill();
        return $this->render('upload_error', [
            'model' =>$model,
        ]);
    }
	
}
