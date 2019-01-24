<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\filters\VerbFilter;
use PhpAmqpLib\Connection\AMQPStreamConnection;
date_default_timezone_set('Africa/Nairobi');
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class ControllNumbermasterConsumerController extends Controller {


    
    public function actionIndex()
    {

        $connection = new AMQPStreamConnection('41.59.225.155', 5672, 'admin', '0lams@2018?ucc');
        
        $channel = $connection->channel();
        
        $channel->queue_declare('GePGControllNumberQueue', false, true, false, false);
        
        //echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        
        $callback = function($msg){
        
            echo $msg->body;
$orgncontent=$msg->body;
            
            $array = json_decode($msg->body, true);
         
            try{
                $this->actionPostBillResponse($array,$orgncontent);
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }  catch (\Exception $ex){
                echo $ex->getMessage();
            }
        };
        
        //$channel->basic_qos(null, 1, null);
        
        $channel->basic_consume('GePGControllNumberQueue', '', false, false, false, false, $callback);
        
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        
        $channel->close();
        
        $connection->close();
    }

    
  
    public function actionPostBillResponse($xml,$orgncontent) {

              $control_number = (array)$xml['gepgBillSubResp']['BillTrxInf']['PayCntrNum'];
              $control_number = $control_number[0];
              $bill_number = (array)$xml['gepgBillSubResp']['BillTrxInf']['BillId'];
              $bill_number = $bill_number[0];

              /*
               print_r($xml);
              $payment_setup = \backend\modules\application\models\Application::findOne(['bill_number' => $bill_number]);
              $payment_setup->control_number =  $control_number;
              $payment_setup->date_control_received = date('Y-m-d'.'\T'.'H:i:s');
              echo "\n".$control_number." --- ".$payment_setup->save()."\n\n";
              */

        ###########GePG Important part############
        $billNumber=$bill_number;
        $control_number=$control_number;
        $billPrefix = substr($billNumber, 0, 5);
        $date_control_received=date("Y-m-d H:i:s");
        $operationType=\backend\modules\repayment\models\GepgBillProcessingSetting::RECEIVE_CONTROL_NO;
        $results_url=\backend\modules\repayment\models\GepgBillProcessingSetting::getBillPrefix($billPrefix,$operationType);

		//part redirection to specific console
		\Yii::$app->runAction($results_url->bill_processing_uri."/index",
		[
		$control_number, $billNumber,$date_control_received
        ]);
		//end part redirection to specific console
        ###########end GePG important part#############

//$date_control_received = date('Y-m-d'.'\T'.'h:i:s');
//$sqlq="UPDATE application set control_number='".$control_number."',date_control_received='".$date_control_received."' WHERE bill_number='".$bill_number."'";
			  //Yii::$app->db->createCommand($sqlq)->execute();


              $trans_status = (array)$xml['gepgBillSubResp']['BillTrxInf']['TrxSts'];
              $trans_status = $trans_status[0];
			  $trans_code = (array)$xml['gepgBillSubResp']['BillTrxInf']['TrxStsCode'];
              $trans_code = $trans_code[0];
              //$response_content = $this->getDataString($orgncontent,'gepgBillSubResp');
              $response_content =$orgncontent;
              
              $query = "insert into gepg_cnumber(bill_number, response_message,retrieved,control_number,trsxsts,trans_code,date_received) values "
                    . "('{$bill_number}','{$response_content}',0,'{$control_number}','{$trans_status}','{$trans_code}','".date('Y-m-d H:i:s')."')";
                
              Yii::$app->db->createCommand($query)->execute();
			  
			  $query3Bill = "UPDATE gepg_bill SET control_number ='".$control_number."' WHERE bill_number='".$bill_number."'";
             Yii::$app->db->createCommand($query3Bill)->execute();

    }
    
    public function getDataString($inputstr,$datatag){
	$datastartpos = strpos($inputstr, $datatag);
	$dataendpos = strrpos($inputstr, $datatag);
	$data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
	return $data;
    }
}
