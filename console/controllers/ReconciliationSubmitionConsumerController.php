<?php

namespace console\controllers;

use Yii;
//use common\components\Controller;
use yii\console\Controller;
use yii\filters\VerbFilter;
use PhpAmqpLib\Connection\AMQPStreamConnection;

date_default_timezone_set('Africa/Nairobi');
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class ReconciliationSubmitionConsumerController extends Controller {


    
    public function actionIndex()
    {

        $connection = new AMQPStreamConnection('41.59.225.155', 5672, 'admin', '0lams@2018?ucc');
        
        $channel = $connection->channel();
        
        $channel->queue_declare('GePGReconciliationRequestQueue', false, true, false, false);
        
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        
        $callback = function($msg){
        
            echo $msg->body;
            
            $array = json_decode($msg->body, true);
			
			$SpReconcReqId = $array['SpReconcReqId'];
            $SpCode= $array['SpCode'];
            $SpSysId=$array['SpSysId']; 
            $TnxDt=$array['TnxDt']; 
            $ReconcOpt=$array['ReconcOpt'];
          
            try{
                //$this->submitReconcRequest($SpReconcReqId,$SpCode,$SpSysId,$TnxDt,$ReconcOpt);
				$this->submitReconcRequest($array);
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }  catch (\Exception $ex){
                echo $ex->getMessage();
            }
            
        };
        
        //$channel->basic_qos(null, 1, null);
        
        $channel->basic_consume('GePGReconciliationRequestQueue', '', false, false, false, false, $callback);
        
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        
        $channel->close();
        
        $connection->close();
    }

    
    public function submitReconcRequest($array) 
    {        
        
        if (!$cert_store = file_get_contents("/var/www/html/olams/frontend/web/sign/heslbolams.pfx")) {
          echo "Error: Unable to read the cert file\n".\Yii::getAlias('@webroot');
          exit;
        }
        else
        {
            
            if (openssl_pkcs12_read($cert_store, $cert_info, "heslbolams"))
            {
                               
                $config=[
                    'post_url'=>Yii::$app->params['GePG']['send_reconciliations_url'],
                    'sp_code'=>Yii::$app->params['GePG']['sp_code'],
                    'sp_subcode'=>Yii::$app->params['GePG']['sp_subcode'],
                    'sp_id'=>Yii::$app->params['GePG']['sp_id'],
                    'auth_certificate'=>Yii::$app->params['GePG']['auth_certificate'],
                    'auth_certificate_pswd'=>Yii::$app->params['GePG']['auth_certificate_pswd'],
                    'authentication_type'=>Yii::$app->params['GePG']['auth_type'],
                    'auth_certificate_sign_algorithm'=>Yii::$app->params['GePG']['cert_signature_algorithm'],
                ];
                $GePGSoapClient=new GePGSoapClient($config);			
				$resultCurlPost=$GePGSoapClient->postReconciliation($array);
            //$resultCurlPost=$data;
            
			$queryF = "insert into gepg_reconciliation_request(response_message,orgn_content,date_created) value "
                . "('{$resultCurlPost}','{$data}','".date('Y-m-d H:i:s')."')";
            Yii::$app->db->createCommand($queryF)->execute();
			
            if(!empty($resultCurlPost)){

                ##to get content to insert in the gepg_bill table
		$datatag = "gepgSpReconcReqAck";
		$sigtag = "gepgSignature";
		$vdata = self::getDataString($resultCurlPost,$datatag);
		$vsignature = self::getSignatureString($resultCurlPost,$sigtag);
		
		$dataContents="Data Received:".$vdata."Signature Received:".$vsignature;
		
		if (!$pcert_store = file_get_contents("/var/www/html/olams/frontend/web/sign/gepgpubliccertificatetoclients.pfx")) {
			//echo "Error: Unable to read the cert file\n";
			//exit;
			$getConFileFailed="Error: Unable to read the cert file";
		}else{

			//Read Certificate
			if (openssl_pkcs12_read($pcert_store,$pcert_info,"gepg@2018")) {
				//Decode Received Signature String
				$rawsignature = base64_decode($vsignature);

				//Verify Signature and state whether signature is okay or not
				$ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0']);
				if ($ok == 1) {
					//echo "\n\nSignature Status:";
				    //echo "GOOD";
					$getConFileFailed1="Signature Status:GOOD";
				} elseif ($ok == 0) {
					//echo "\n\nSignature Status:";
				    //echo "BAD";
					$getConFileFailed1="Signature Status:BAD";
				} else {
					//echo "\n\nSignature Status:";
				    //echo "UGLY, Error checking signature";
					$getConFileFailed1="Signature Status:UGLY, Error checking signature";
				}
				$getConFileFailed=$getConFileFailed1;
			}  
		}
                    //$response_message="Received Response".$resultCurlPost.$dataContents.$getConFileFailed;
                    //$bill_request='hthtyjytjyjyuj';
                    $bill_request="Received Response".$dataContents.$getConFileFailed;
                    //$vValuesa='kjnrger';
		
                    echo $bill_request."\n\n";
                    
        //$query = "insert into gepg_bill(bill_number, bill_request,retry,status,response_message,date_created) value "
               // . "('{$Billno}','{$content}',0,0,'{$bill_request}','".date('Y-m-d H:i:s')."')";
           // Yii::$app->db->createCommand($query)->execute();
  //echo $bill_request;
			
		##to get content to insert in the gepg_bill table

       return true;
        
  }
        else
        {
                //echo "No result Returned"."\n";
            return false;
        }

        }
        else
        {

    echo "Error: Unable to read the cert store.\n";
    exit;
        }

}
    }

    
      public function getDataString($inputstr,$datatag){
	$datastartpos = strpos($inputstr, $datatag);
	$dataendpos = strrpos($inputstr, $datatag);
	$data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
	return $data;
}

public function getSignatureString($inputstr,$sigtag){
	$sigstartpos = strpos($inputstr, $sigtag);
	$sigendpos = strrpos($inputstr, $sigtag);
	$signature=substr($inputstr,$sigstartpos + strlen($sigtag)+1,$sigendpos - $sigstartpos -strlen($sigtag)-3);
	return $signature;
}
  
}
