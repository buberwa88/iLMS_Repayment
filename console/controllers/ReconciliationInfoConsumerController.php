<?php

namespace console\controllers;

use Yii;
//use common\components\Controller;
use yii\console\Controller;
use yii\filters\VerbFilter;
use PhpAmqpLib\Connection\AMQPStreamConnection;
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
date_default_timezone_set('Africa/Nairobi');
class ReconciliationInfoConsumerController extends Controller {


    
    public function actionIndex()
    {

        $connection = new AMQPStreamConnection('41.59.225.155', 5672, 'admin', '0lams@2018?ucc');
        
        $channel = $connection->channel();
        
        $channel->queue_declare('GePGReconciliationResponseQueue', false, true, false, false);
        
        //echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        
        $callback = function($msg){
        
           // echo $msg->body;
//$orgncontent=$msg->body;
            
            $array = json_decode($msg->body, true);
         
            try{
                $this->actionPostReconciliationInfo($array);
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }  catch (\Exception $ex){
                //echo $ex->getMessage();
            }
        };
        
        //$channel->basic_qos(null, 1, null);
        
        $channel->basic_consume('GePGReconciliationResponseQueue', '', false, false, false, false, $callback);
        
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        
        $channel->close();
        
        $connection->close();
    }

    
  
    public function actionPostReconciliationInfo($xml) {


		$transaction_id = $xml['gepgSpReconcResp']['ReconcBatchInfo']['SpReconcReqId'];
		$ReconcTrxInfoArray = $xml['gepgSpReconcResp']['ReconcTrans']['ReconcTrxInf'];
	if(count($ReconcTrxInfoArray) > 1){	
    foreach ($ReconcTrxInfoArray as $ReconcTrxInfo) {

    //$payment_reco = new \app\models\PaymentReconciliation();
    
    $trans_id = $transaction_id;
    $trans_date = date('Y-m-d H:i:s');	
    $bill_number = $ReconcTrxInfo['SpBillId'];
    $control_number = $ReconcTrxInfo['BillCtrNum'];
    $receipt_number = $ReconcTrxInfo['PayRefId'];
    $paid_amount = $ReconcTrxInfo['PaidAmt'];
    $paymentchannel = $ReconcTrxInfo['UsdPayChnl'];
    $account_number = $ReconcTrxInfo['CtrAccNum'];
    $Remarks = $ReconcTrxInfo['Remarks'];
    if(!empty($paymentchannel)){
	$paymentChannelF=$paymentchannel;
	}else{
	$paymentChannelF=NULL;
	}
        
       if(!empty($paid_amount)){
	$paid_amount=$paid_amount;
	}else{
	$paid_amount=0;
	}
    
    echo $Remarks."--".$paymentChannelF;
/*
$query2 = "insert into gepg_payment_reconciliation(trans_id,trans_date,bill_number,control_number,receipt_number,paid_amount,payment_channel,account_number,Remarks,date_created) value "
                . "('".$trans_id."','{$trans_date}','{$bill_number}','{$control_number}','{$receipt_number}','{$paid_amount}','{$paymentChannelF}','{$account_number}','{$Remarks}','{$trans_date}')";
            Yii::$app->db->createCommand($query2)->execute();         
*/
	$queryExist = "SELECT id FROM gepg_payment_reconciliation WHERE  receipt_number='{$receipt_number}' AND bill_number='{$bill_number}' AND control_number='{$control_number}'";
            $ResultsExists = Yii::$app->db->createCommand($queryExist)->queryOne();
			$idExists=$ResultsExists['id'];
			if($idExists==''){
			Yii::$app->db->createCommand()
            ->insert('gepg_payment_reconciliation', [
                'trans_id' => $trans_id,
                'trans_date' => $trans_date,
				'bill_number' =>$bill_number,
                'control_number' =>$control_number,
                'receipt_number' => $receipt_number,
                'paid_amount' => $paid_amount,
                'payment_channel' => $paymentChannelF,
                'account_number' => $account_number,
                'Remarks' => $Remarks,
                'date_created' => $trans_date,                
            ])->execute();
			}
			
			//checking amount paid before
			$query1 = "SELECT paid_amount FROM gepg_receipt WHERE  receipt_number='{$receipt_number}'";
            $Results1 = Yii::$app->db->createCommand($query1)->queryOne(); 
            $amountPaidBefore=$Results1['paid_amount'];			
			//end check amount received before
			if(strcmp($paid_amount,$amountPaidBefore)==0){
			$amountDifference=0;
			$reconciliation_status=0;
			}else{
			$amountDifference=$amountPaidBefore-$paid_amount;
			$reconciliation_status=2;
			}
			
    $query3 = "UPDATE gepg_receipt SET reconciliation_status='{$reconciliation_status}',amount_diff='{$amountDifference}',recon_master_id='{$trans_id}',recon_amount='{$paid_amount}' WHERE receipt_number='{$receipt_number}' AND reconciliation_status<>0";
              Yii::$app->db->createCommand($query3)->execute();
    	
}

$query3Comt = "UPDATE gepg_recon_master SET status='0' WHERE recon_master_id='".$trans_id."'";
             Yii::$app->db->createCommand($query3Comt)->execute();
			 //end new added

echo "DONE";
}else{
echo "FAILED";		
	}
    }
    /*
    public function getDataString($inputstr,$datatag){
	$datastartpos = strpos($inputstr, $datatag);
	$dataendpos = strrpos($inputstr, $datatag);
	$data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
	return $data;
    }
	*/
}
