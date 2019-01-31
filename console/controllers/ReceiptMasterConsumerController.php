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
class ReceiptMasterConsumerController extends Controller {


    
    public function actionIndex()
    {

        $connection = new AMQPStreamConnection(Yii::$app->params['RabbitMQ']['server_ip'], Yii::$app->params['RabbitMQ']['server_port'],Yii::$app->params['RabbitMQ']['username'], Yii::$app->params['RabbitMQ']['password']);
        
        $channel = $connection->channel();
        
        $channel->queue_declare('GePGReceiptQueue', false, true, false, false);
        
        //echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        
        $callback = function($msg){
        
            //echo $msg->body;
$orgncontent=$msg->body;
            
            $array = json_decode($msg->body, true);
          
            try{
                $this->actionPostReceipt($array,$orgncontent);
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            } catch (\Exception $ex){
                echo $ex->getMessage();
            }
        };
        
        //$channel->basic_qos(null, 1, null);
        
        $channel->basic_consume('GePGReceiptQueue', '', false, false, false, false, $callback);
        
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        
        $channel->close();
        
        $connection->close();
    }

    public function actionPostReceipt($xml,$orgncontent)
    {

        $bill_number = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['BillId'];
        $bill_number = $bill_number[0];
        $amount = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['BillAmt'];
        $amount = $amount[0];

        $receipt_number = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PayRefId'];
        $receipt_number = $receipt_number[0];

        $transaction_date = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['TrxDtTm'];
        $transaction_date = $transaction_date[0];

        /*
        $payment_setup = \backend\modules\application\models\Application::findOne(['bill_number' => $bill_number]);
        $payment_setup->receipt_number =  $receipt_number;
        $payment_setup->date_receipt_received = date('Y-m-d'.'\T'.'H:i:s');
        $payment_setup->save();
        */
        $date_receipt_received = date('Y-m-d' . '\T' . 'H:i:s');


        $content = $orgncontent;
        $transaction_id = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['TrxId'];
        $transaction_id = $transaction_id[0];
        $bill_amount = $amount;
        $paid_amount = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PaidAmt'];
        $paid_amount = $paid_amount[0];
        $control_number = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PayCtrNum'];
        $control_number = $control_number[0];
        //new added
        $paymentChanelUsed = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['UsdPayChnl'];
        if (!empty($paymentChanelUsed)) {
            $paymentChanelUsed = $paymentChanelUsed[0];
        } else {
            $paymentChanelUsed = NULL;
        }
        $payerPhoneNumber = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PyrCellNum'];
        if (!empty($payerPhoneNumber)) {
            $payerPhoneNumber = $payerPhoneNumber[0];
        } else {
            $payerPhoneNumber = NULL;
        }
        $payerName = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PyrName'];
        if (!empty($payerName)) {
            $payerName = $payerName[0];
        } else {
            $payerName = NULL;
        }

        $paymentReceiptPservProv = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PspReceiptNumber'];
        if (!empty($paymentReceiptPservProv)) {
            $paymentReceiptPservProv = $paymentReceiptPservProv[0];
        } else {
            $paymentReceiptPservProv = NULL;
        }
        $paymServProvName = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['PspName'];
        if (!empty($paymServProvName)) {
            $paymServProvName = $paymServProvName[0];
        } else {
            $paymServProvName = NULL;
        }
        $creditedAccount = (array)$xml['gepgPmtSpInfo']['PymtTrxInf']['CtrAccNum'];
        if (!empty($creditedAccount)) {
            $creditedAccount = $creditedAccount[0];
        } else {
            $creditedAccount = NULL;
        }

        //end new added

        $queryGetAppID = " SELECT bill_amount,bill_reference_table_id,bill_type,bill_reference_table,primary_keycolumn FROM gepg_bill WHERE  bill_number='" . $bill_number . "'";
        $ResultApplicationID = Yii::$app->db->createCommand($queryGetAppID)->queryOne();
        $bill_reference_table_id = $ResultApplicationID['bill_reference_table_id'];
        $billAmount = $ResultApplicationID['bill_amount'];
        $bill_type = $ResultApplicationID['bill_type'];
        $bill_reference_table = $ResultApplicationID['bill_reference_table'];
		$primary_keycolumn=$ResultApplicationID['primary_keycolumn'];

        $checkExist = " SELECT id FROM gepg_receipt WHERE  bill_number='" . $bill_number . "' AND receipt_number='" . $receipt_number . "'";
        $existsResults = Yii::$app->db->createCommand($checkExist)->queryOne();
        $idExists = $existsResults['id'];

        //NEW ADDED TELE 20_06_2018
        $date_createdsc = date("Y-m-d H:i:s");
        if ($idExists == '') {
        Yii::$app->db->createCommand()
            ->insert('gepg_receipt', [
                'bill_number' => $bill_number,
                'response_message' => '',
                'retrieved' => 0,
                'trans_id' => $transaction_id,
                'payer_ref_id' => '',
                'control_number' => $control_number,
                'bill_amount' => $bill_amount,
                'paid_amount' => $paid_amount,
                'currency' => '',
                'trans_date' => $date_createdsc,
                'payer_phone' => $payerPhoneNumber,
                'payer_name' => $payerName,
                'receipt_number' => $receipt_number,
                'account_number' => $creditedAccount,
                'application_id' => '',
                'transact_date_gepg' => $transaction_date,
                'paymentChanelUsed' => $paymentChanelUsed,
                'paymentReceiptPservProv' => $paymentReceiptPservProv,
                'bill_reference_table_id' => $bill_reference_table_id,
                'bill_type' => $bill_type,
                'bill_reference_table' => $bill_reference_table,
                'paymServProvName' => $paymServProvName,
				'primary_keycolumn' => $primary_keycolumn,
            ])->execute();
    }
			//END NEW ADDED                   


            $query3Bill = "UPDATE gepg_bill SET status='3' WHERE bill_number='".$bill_number."'";
             Yii::$app->db->createCommand($query3Bill)->execute();


            if(strcmp($paid_amount,$billAmount)==0){
                /*
			 $applicationFeePaid = "UPDATE application SET payment_status='1' WHERE bill_number='".$bill_number."'";
             Yii::$app->db->createCommand($applicationFeePaid)->execute();
                    ###################### mickidadimsoka@gmail.com ####################
                                             $applicant_Id=$ResultApplicationID['applicant_id'];
                                       $modeluser=  \frontend\modules\application\models\Applicant::findOne($applicant_Id);
                Yii::$app->db->createCommand("update auth_assignment  set item_name='applicant_only' WHERE user_id='{$modeluser->user_id}'")->execute();           
                        #################create applicant role #########
                */

                ###########GePG Important part############
                $billNumber=$bill_number;
                $billPrefix = substr($billNumber, 0, 5);
$operationType=\backend\modules\repayment\models\GepgBillProcessingSetting::RECEIVE_PAYMENT;
$results_url=\backend\modules\repayment\models\GepgBillProcessingSetting::getBillPrefix($billPrefix,$operationType);
                //return $this->redirect([$results_url->bill_processing_uri,'receiptNumber'=>$receipt_number,'bill_number'=>$billNumber,'receiptDate'=>$transaction_date,'date_receipt_received'=>$date_receipt_received,'controlNumber'=>$control_number]);

                \Yii::$app->runAction($results_url->bill_processing_uri."/index",
                    [
                        $control_number,$paid_amount,$date_receipt_received,$transaction_date,$receipt_number
                    ]);
                ###########end GePG important part#############

            }

      // echo \backend\modules\application\models\GepgTransactions::getAllApplicationsPaid(); 
        

    }
    
    public function getDataString($inputstr,$datatag){
	$datastartpos = strpos($inputstr, $datatag);
	$dataendpos = strrpos($inputstr, $datatag);
	$data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
	return $data;
    }

}
