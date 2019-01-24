<?php

namespace console\controllers;

use Yii;
//use common\components\Controller;
use yii\console\Controller;
use yii\filters\VerbFilter;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use frontend\modules\application\rabbit\Producer;
use backend\modules\application\models\Application;

date_default_timezone_set('Africa/Nairobi');
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class ReconciliationRequestController extends Controller {
               

      public function actionIndex() {
	  $created_at=date("Y-m-d H:i:s");
	  /*
	    $created_at=date("Y-m-d H:i:s");
		$recon_date=date("Y-m-d");
	    $query2 = "insert into gepg_recon_master(recon_date,created_at) value ('{$recon_date}','{$created_at}')";
        Yii::$app->db->createCommand($query2)->execute();
	  */
        // check if there is pending
        $query1 = " SELECT * FROM gepg_recon_master WHERE  status=1";
        $Result1 = Yii::$app->db->createCommand($query1)->queryOne();               
			$reconMasterID = $Result1['recon_master_id'];
			if($reconMasterID < 1 OR $reconMasterID==''){
			$queryMaxDateRecon = " SELECT * FROM gepg_receipt WHERE  reconciliation_status<>1 ORDER BY id DESC";
            $ResultMaxRecon = Yii::$app->db->createCommand($queryMaxDateRecon)->queryOne();
			$receiptID=$ResultMaxRecon['id'];
			
			$queryMinDateRecon = " SELECT * FROM gepg_receipt WHERE  reconciliation_status=1 AND id >'".$receiptID."' ORDER BY id ASC";
            $ResultMinRecon = Yii::$app->db->createCommand($queryMinDateRecon)->queryOne();
			$receiptIDzs=$ResultMinRecon['id'];
			
			if($receiptIDzs > 0){
			$minTransDate=date("Y-m-d",strtotime($ResultMinRecon['trans_date']));
			$todayGet=date("Y-m-d");
			if($minTransDate<=$todayGet){
			
			//set recon date
			$reconDate=date('Y-m-d', strtotime($minTransDate . ' +1 day'));
			$reconDateF=$reconDate." 07:00:00";
			
			$queryInsertReconReq = "insert into gepg_recon_master(recon_date,created_at,check_date_recon) value ('{$minTransDate}','{$created_at}','{$reconDateF}')";
            Yii::$app->db->createCommand($queryInsertReconReq)->execute();
			//end
			 }
			 }
       }else{
	   $check_date_recon = $Result1['check_date_recon'];
	   if($created_at >= $check_date_recon){
	   $SpReconcReqId = $reconMasterID;
			$SpCode=Yii::$app->params['GePG']['sp_code'];
			$SpSysId=Yii::$app->params['GePG']['sp_id'];
			$TnxDt=$Result1['recon_date'];
			$ReconcOpt='1';
            			//echo $SpReconcReqId;
			$dataToQueue = ["SpReconcReqId" => $SpReconcReqId, 
                                     "SpCode"=>$SpCode, 
                                     "SpSysId"=>$SpSysId, 
                                     "TnxDt"=>$TnxDt, 
                                      "ReconcOpt"=>$ReconcOpt];
            if($reconMasterID > 0){
            Producer::queue("GePGReconciliationRequestQueue", $dataToQueue);
			 }
}
echo 'Exists';			 
	   } 
    }

}

