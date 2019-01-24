<?php
namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\filters\VerbFilter;
use \backend\modules\application\models\GepgTransactions;
date_default_timezone_set('Africa/Nairobi');

class TransactionMasterController extends Controller {

      public function actionIndex() {
        $control_number='991110072243';	  
		$billNumber="EPPNT0000062019-1";
        $control_number=$control_number;
        $billPrefix = substr($billNumber, 0, 5);
        $date_control_received=date("Y-m-d H:i:s");
        $operationType=\backend\modules\repayment\models\GepgBillProcessingSetting::RECEIVE_CONTROL_NO;
        $results_url=\backend\modules\repayment\models\GepgBillProcessingSetting::getBillPrefix($billPrefix,$operationType);
		  
		\Yii::$app->runAction($results_url->bill_processing_uri."/index",
		[
		$control_number, $billNumber,$date_control_received
        ]);
		
		$query3Bill = "UPDATE gepg_bill SET control_number ='".$control_number."' WHERE bill_number='".$billNumber."'";
             Yii::$app->db->createCommand($query3Bill)->execute();
    }
}

