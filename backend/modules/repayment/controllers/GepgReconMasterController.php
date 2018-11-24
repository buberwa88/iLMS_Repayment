<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\GepgReconMaster;
use backend\modules\repayment\models\GepgReconMasterSearch;
use backend\modules\repayment\models\GepgBill;
use backend\modules\repayment\models\GepgBillSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use frontend\modules\application\rabbit\Producer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * GepgReconMasterController implements the CRUD actions for GepgReconMaster model.
 */
class GepgReconMasterController extends Controller
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
     * Lists all GepgReconMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GepgReconMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GepgReconMaster model.
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
     * Creates a new GepgReconMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GepgReconMaster();
        $model->created_at=date("Y-m-d H:i:s");
		$model->created_by=Yii::$app->user->identity->user_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		//take reconciliation request in queue
		$recoID=$model->recon_master_id;
		$query1 = " SELECT * FROM gepg_recon_master WHERE  recon_master_id='".$recoID."'";
        $Result1 = Yii::$app->db->createCommand($query1)->queryOne();
               
			$reconMasterID = $Result1['recon_master_id'];
			$SpReconcReqId = $reconMasterID;
			$SpCode='SP111';
			$SpSysId='LHESLB001';
			$TnxDt=$Result1['recon_date'];
			$ReconcOpt='1';
            			//echo $SpReconcReqId;
			$dataToQueue = ["SpReconcReqId" => $SpReconcReqId, 
                                     "SpCode"=>$SpCode, 
                                     "SpSysId"=>$SpSysId, 
                                     "TnxDt"=>$TnxDt, 
                                      "ReconcOpt"=>$ReconcOpt];
            if($reconMasterID > 0){
            //Producer::queue("GePGReconciliationRequestQueue", $dataToQueue);
			}
		//end take reconciliation request in queue
		
		    $sms = '<p>Reconciliation Successful created.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GepgReconMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->recon_master_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GepgReconMaster model.
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
     * Finds the GepgReconMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GepgReconMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GepgReconMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionUploadPaymentRecon() {
        $this->layout = "main_private";		
        $searchModelGepgBill = new GepgReconMasterSearch();
		$modelGepgBill = new GepgReconMaster();
        $loggedin = Yii::$app->user->identity->user_id;		
        $dataProvider = $searchModelGepgBill->search(Yii::$app->request->queryParams);
                $modelGepgBill->scenario = 'upload_payment_recon2';
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
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'PAYMENT RECON. UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:F1', 'PAYMENT RECON. UPLOAD REPORT');

                        $rowCount = 2;
                        $s_no = 0;
                        $customTitle = ['SNo', 'RECEIPT NUMBER', 'AMOUNT PAID', 'DATE', 'UPLOAD STATUS', 'FAILED REASON'];
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
                            $modelGepgBill = new GepgReconMaster();
                            $modelGepgBill->scenario = 'upload_payment_recon';
                            $modelGepgBill->receipt_number = GepgReconMaster::formatRowData($rowData[0][1]);
                            $modelGepgBill->amount_paid = GepgReconMaster::formatRowData($rowData[0][2]);
							$modelGepgBill->recon_date = GepgReconMaster::formatRowData($rowData[0][3]);
							//$modelGepgBill->date_created='';
							$receipt_number=$modelGepgBill->receipt_number;
							$amount_paid=$modelGepgBill->amount_paid;
							$recon_date=$modelGepgBill->recon_date;
                            $modelGepgBill->validate();
                             $reason = '';
                             if($modelGepgBill->hasErrors()){
                                $errors = $modelGepgBill->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason.$value[0].'  ';									
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelGepgBill->receipt_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelGepgBill->amount_paid);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelGepgBill->recon_date);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $reason);
                            unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelGepgBill->receipt_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelGepgBill->amount_paid);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelGepgBill->recon_date);
                                $modelGepgBill->save();
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, 'UPLOADED SUCCESSFUL');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, 'N/A');
							
                            $query3Application = "UPDATE application SET control_number ='".$control_number."',date_control_received='".$dateContr."' WHERE bill_number='".$bill_number."'";
                            Yii::$app->db->createCommand($query3Application)->execute();							

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
        return $this->render('uploadpaymentrecon', [
                    'model'=>$modelGepgBill,
        ]);
    }
	
	public function actionUploadError()
    {
        $this->layout="main_private"; 
        $model = new GepgCnumber();
        return $this->render('upload_error', [
            'model' =>$model,
        ]);
    }
}
