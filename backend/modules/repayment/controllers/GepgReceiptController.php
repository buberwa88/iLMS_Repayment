<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\GepgReceipt;
use backend\modules\repayment\models\GepgReceiptSearch;
use backend\modules\repayment\models\GepgBill;
use backend\modules\repayment\models\GepgBillSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GepgReceiptController implements the CRUD actions for GepgReceipt model.
 */
class GepgReceiptController extends Controller
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
     * Lists all GepgReceipt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GepgReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GepgReceipt model.
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
     * Creates a new GepgReceipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GepgReceipt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GepgReceipt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing GepgReceipt model.
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
     * Finds the GepgReceipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GepgReceipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GepgReceipt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionUploadPayments() {
        $this->layout = "main_private";		
        $searchModelGepgBill = new GepgReceiptSearch();
		$modelGepgBill = new GepgReceipt();
        $loggedin = Yii::$app->user->identity->user_id;		
        $dataProvider = $searchModelGepgBill->search(Yii::$app->request->queryParams);
                $modelGepgBill->scenario = 'payments_upload2';
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

                if (strcmp($highestColumn, "E") == 0 && $highestRow >= 2) {
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
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'PAYMENTS UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:G1', 'PAYMENTS UPLOAD REPORT');

                        $rowCount = 2;
                        $s_no = 0;
                        $customTitle = ['SNo', 'CONTROL NUMBER','PAID AMOUNT', 'RECEIPT NUMBER', 'DATE', 'UPLOAD STATUS', 'FAILED REASON'];
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);

                    for ($row = 2; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelGepgBill = new GepgReceipt();
                            $modelGepgBill->scenario = 'payments_upload';
                            $modelGepgBill->control_number = GepgReceipt::formatRowData($rowData[0][1]);
                            $modelGepgBill->paid_amount = GepgReceipt::formatRowData($rowData[0][2]);
							$modelGepgBill->receipt_number = GepgReceipt::formatRowData($rowData[0][3]);
							$modelGepgBill->trans_date = GepgReceipt::formatRowData($rowData[0][4]);
							$modelGepgBill->transact_date_gepg = GepgReceipt::formatRowData($rowData[0][4]);
							//$modelGepgBill->date_created='';
							$control_number=$modelGepgBill->control_number;
							$paid_amount=$modelGepgBill->paid_amount;
							$receipt_number=$modelGepgBill->receipt_number;
							$trans_date=$modelGepgBill->trans_date;
                            $modelGepgBill->validate();
                             $reason = '';
                             if($modelGepgBill->hasErrors()){
                                $errors = $modelGepgBill->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason.$value[0].'  ';									
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelGepgBill->control_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelGepgBill->paid_amount);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelGepgBill->receipt_number);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelGepgBill->trans_date);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $reason);
                            unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelGepgBill->control_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelGepgBill->paid_amount);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelGepgBill->receipt_number);
								$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelGepgBill->trans_date);
                                $modelGepgBill->save();
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, 'UPLOADED SUCCESSFUL');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'N/A');
							
                            $query3Application = "UPDATE application SET receipt_number ='".$receipt_number."',date_receipt_received='".$trans_date."' WHERE control_number='".$control_number."'";
                            Yii::$app->db->createCommand($query3Application)->execute();						

							$queryGetAppID = " SELECT application_id,amount_paid FROM application WHERE  control_number='".$control_number."'";
							$ResultApplicationID = Yii::$app->db->createCommand($queryGetAppID)->queryOne();
							$finalAppID=$ResultApplicationID['application_id'];
                            $billAmount=$ResultApplicationID['amount_paid'];

                             if(strcmp($paid_amount,$billAmount)==0){			 
							 $applicationFeePaid = "UPDATE application SET payment_status='1' WHERE control_number='".$control_number."'";
							 Yii::$app->db->createCommand($applicationFeePaid)->execute();
							}							

                            $query3Bill = "UPDATE gepg_bill SET status='3' WHERE control_number='".$control_number."'";
							Yii::$app->db->createCommand($query3Bill)->execute(); 
							
                            $query3ReceiptAppID = "UPDATE gepg_receipt SET application_id='".$finalAppID."' WHERE control_number='".$control_number."'";
							Yii::$app->db->createCommand($query3ReceiptAppID)->execute();							
                            }
                        }
						unlink('uploadscontrolnumber/' . $date_time . $inputFiles1);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
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
        return $this->render('uploadpayments', [
                    'model'=>$modelGepgBill,
        ]);
    }
	
	public function actionUploadError()
    {
        $this->layout="main_private"; 
        $model = new GepgReceipt();
        return $this->render('upload_error', [
            'model' =>$model,
        ]);
    }
	
	
}
