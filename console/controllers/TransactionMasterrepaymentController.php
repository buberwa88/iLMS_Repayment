<?php
namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\filters\VerbFilter;
use \backend\modules\application\models\GepgTransactions;
date_default_timezone_set('Africa/Nairobi');

class TransactionMasterrepaymentController extends Controller {

      public function actionIndex() {
        $control_number='991110072277';	  
		$billNumber="EPPNT0000062019-1";	
		$paid_amount=100000;		
        $billPrefix = substr($billNumber, 0, 5);
        $date_receipt_received=date("Y-m-d H:i:s");
		$transaction_date=$date_receipt_received;
		$receipt_number="99783530002789";
		
$operationType=\backend\modules\repayment\models\GepgBillProcessingSetting::RECEIVE_PAYMENT;
$results_url=\backend\modules\repayment\models\GepgBillProcessingSetting::getBillPrefix($billPrefix,$operationType);
                //return $this->redirect([$results_url->bill_processing_uri,'receiptNumber'=>$receipt_number,'bill_number'=>$billNumber,'receiptDate'=>$transaction_date,'date_receipt_received'=>$date_receipt_received,'controlNumber'=>$control_number]);

                \Yii::$app->runAction($results_url->bill_processing_uri."/index",
                    [
                        $control_number,$paid_amount,$date_receipt_received,$transaction_date,$receipt_number
                    ]);
		
		$query3Bill = "UPDATE gepg_bill SET control_number ='".$control_number."' WHERE bill_number='".$billNumber."'";
             Yii::$app->db->createCommand($query3Bill)->execute();
    }
}

