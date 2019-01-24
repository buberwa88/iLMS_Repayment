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
class CancellbillSubmitionConsumerController extends Controller {


    
    public function actionIndex()
    {

        $connection = new AMQPStreamConnection('41.59.225.155', 5672, 'admin', '0lams@2018?ucc');
        
        $channel = $connection->channel();
        
        $channel->queue_declare('GePGBillCancellationRequestQueue', false, true, false, false);
        
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        
        $callback = function($msg){
        
            echo $msg->body;
            
            $array = json_decode($msg->body, true);
			
			$SpCode =$array['SpCode'];
            $SpSysId=$array['SpSysId'];
            $BillId1=$array['BillId1'];
          
            try{
                $this->submitBillCancellationRequest($SpCode,$SpSysId,$BillId1);
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }  catch (\Exception $ex){
                echo $ex->getMessage();
            }
            
        };
        
        //$channel->basic_qos(null, 1, null);
        
        $channel->basic_consume('GePGBillCancellationRequestQueue', '', false, false, false, false, $callback);
        
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        
        $channel->close();
        
        $connection->close();
    }

    
    public function submitBillCancellationRequest($SpCode,$SpSysId,$BillId1) 
    {        
        
        if (!$cert_store = file_get_contents("/var/www/html/olams/frontend/web/sign/heslbolams.pfx")) {
          echo "Error: Unable to read the cert file\n".\Yii::getAlias('@webroot');
          exit;
        }
        else
        {
            
            if (openssl_pkcs12_read($cert_store, $cert_info, "heslbolams"))
            {
						
				$content ="<gepgBillCanclReq>".
								"<SpCode>".$SpCode."</SpCode>".
								"<SpSysId>".$SpSysId."</SpSysId>".
								"<BillId>".$BillId1."</BillId>".
				         "</gepgBillCanclReq>";	

             //create signature
            openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");

          //  $sign_bill = fluidxml(false);



            $signature = base64_encode($signature);  //output crypted data base64 encoded

            //    $sign_bill->add('Gepg', true)
            //              ->add($content)
            //              ->add('gepgSignature', $signature);

            //Compose xml request
             $data = "<Gepg>".$content."<gepgSignature>".$signature."</gepgSignature></Gepg>";
            
            //  $data = $sign_bill->xml(true);

            // echo "<pre>";
            //         var_dump($data);
            //   echo "<pre>";    
            //     die;
             
            $resultCurlPost = "";
            //$serverIp = "http://154.118.230.18";
            $serverIp = "http://154.118.230.202";

            //$uri = "/api/bill/sigqrequest"; //this is for qrequest
            //$uri = "/api/reconciliations/sig_sp_qrequest";
			$uri = "/api/bill/sigcancel_request";

            $data_string = $data;
            //      echo "Message ready to GePG:"."\n".$data_string."\n";

            $ch = curl_init($serverIp.$uri);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                'Content-Type:application/xml',
                                                'Gepg-Com:default.sp.in',
                                                'Gepg-Code:SP111',
                                                'Content-Length:'.strlen($data_string))
            );

            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

            //Capture returned content from GePG
            $resultCurlPost = curl_exec($ch);
            curl_close($ch);
            //$resultCurlPost=$data;         
			$query = "insert into gepg_bill3(response_message,date_created) value "
                . "('{$resultCurlPost}','".date('Y-m-d H:i:s')."')";
            Yii::$app->db->createCommand($query)->execute();
			
			//print_r($resultCurlPost);
             
              //$resultsq = (array)simplexml_load_string($resultCurlPost);
			  
			  $xml = (array)simplexml_load_string($resultCurlPost);
			  
              $billnumber = (array)$xml['gepgBillCanclResp']->BillCanclTrxDt->BillId;
              $billID = $billnumber[0];

              $TrxSts = (array)$xml['gepgBillCanclResp']->BillCanclTrxDt->TrxSts;
              $statusSuccess = $TrxSts[0];

              $TrxStsCode = (array)$xml['gepgBillCanclResp']->BillCanclTrxDt->TrxStsCode;
              $TrxStsCode = $TrxStsCode[0];			  
			  //$billID = $billID[0];
			  
			  //echo "tele  ".$billID;
			  
			  if(!empty($billID)){
			  $billIDf=$billID;
			  }else{
			  $billIDf=NULL;
			  }
			  if(!empty($statusSuccess)){
			  if($statusSuccess=='GS'){
			  $cancelled_response_status=1;
			  $status=4;
			  }else{
			  $cancelled_response_status=2;
			  $status=2;
			  }
			  }else{
			  $cancelled_response_status=2;
			  $status=2;
			  }
			  if(!empty($TrxStsCode)){
			  $TrxStsCodef=$TrxStsCode;
			  }else{
			  $TrxStsCodef=NULL;
			  }
			  
			  $query3 = "UPDATE gepg_bill SET  cancelled_response_status='".$cancelled_response_status."',cancelled_response_code='".$TrxStsCodef."',status='".$status."' WHERE bill_number='".$billIDf."'";
             Yii::$app->db->createCommand($query3)->execute();
			 
			 $queryBill = "SELECT bill_reference_table_id,bill_reference_table,primary_keycolumn FROM gepg_bill WHERE  bill_number='".$billIDf."'";
            $ResultsBillTabl = Yii::$app->db->createCommand($queryBill)->queryOne();
			$bill_reference_table_id=$ResultsBillTabl['bill_reference_table_id'];
			$bill_reference_table=$ResultsBillTabl['bill_reference_table'];
			$primary_keycolumn=$ResultsBillTabl['primary_keycolumn'];
			 
			 
			  if($status==4){
			 $query4 = "UPDATE '".$bill_reference_table."' SET  control_number='CANCELLED' WHERE bill_number='".$billIDf."'";
             Yii::$app->db->createCommand($query4)->execute();
			 }
		echo "Done";	
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
public function xml2Array($xml) {
            $xml = str_replace('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>', '', $xml);
            $xmlparser = xml_parser_create();
            xml_parse_into_struct($xmlparser, $xml, $values);
            xml_parser_free($xmlparser);
            return $values;
       }
  
}
