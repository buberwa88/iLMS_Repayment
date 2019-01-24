<?php

namespace common\components;

use yii\base\Component;

/**
 * Description of GePGSoapClient
 * @author ucc
 */
class GePGSoapClient extends Component {

    public $server_uri; ///base url/ip forthe Gepg System
    public $post_url;
    //public $gfs_code; ///
    public $sp_code; ///service provider code
    public $sp_subcode; //service provider subcode
    public $sp_id; //service provider id 
    public $bill_expiry_date;  ///date of exipirerof the bill
///authentication parameters
    public $auth_type; //authentication type
    public $auth_certificate; //authentication certificate path
    public $auth_certificate_pswd; // authentication certificate password;
    public $auth_certificate_sign_algorithm;
    public $auth_password; //authentication password 
    public $auth_username;  //authentication username

    public function __construct($config = []) {
        parent::__construct($config);
    }

    public function init() {

        parent::init();
    }

    /*
     * generates the certificate authentication signature with content supplied to the GEPG Server 
     * $auth_type can via certificate='cert' or credential ='cred'
     * 
     */

    protected function generateSignature($content) {
        switch ($this->authentication_type) {
            case 'cert': //authenticating using certificate
                if (!$cert_store = file_get_contents($this->auth_certificate)) {
                    echo "Error: Unable to read the cert file\n"; // . \Yii::getAlias('@webroot');
                    return FALSE;
                } else {
                    if (openssl_pkcs12_read($cert_store, $cert_info, $this->auth_certificate_pswd)) {
                        openssl_sign($content, $signature, $cert_info['pkey'], $this->auth_certificate_sign_algorithm);
                        return base64_encode($signature);
                    }
                }
                break;
            case 'cred': //authenticating using username and password
/////code here
                return FALSE;
                break;

            default: //authenticating via certificate as default
                if (!$cert_store = file_get_contents($this->auth_certificate)) {
                    echo "Error: Unable to read the cert file\n"; // . \Yii::getAlias('@webroot');
                    return FALSE;
                } else {
                    if (openssl_pkcs12_read($cert_store, $cert_info, $this->auth_certificate_pswd)) {
                        openssl_sign($content, $signature, $cert_info['pkey'], $this->auth_certificate_sign_algorithm);
                        return base64_encode($signature);
                    }
                }
                break;
        }
    }

    /*
     * sends a requst to the GepG server
     */

    protected function postRequest($data) {
        $ch = curl_init($this->post_url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/xml',
            'Gepg-Com:default.sp.in',
            'Gepg-Code:' . $this->sp_code,
            'Content-Length:' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $resultCurlPost = curl_exec($ch);
        curl_close($ch);
        return $resultCurlPost;
    }

    /*
     * function to send the bill to GePG system
     * $params: Bil parameters in array
     *  $parma['bill_number'=>'','amount'=>'','bill_type'=>'LHESLB001',
     *         'bill_description'=>'Application Fees Payment','bill_gernerated_by'=>'2222',
     *       'payer_name'=>'Juma Ally','payer_phone_number'=>'255000000000',]
     * 
     */

    public function sendBill($params) {
        $sp_code = $this->sp_code; // \Yii::$app->params['GePG']['sp_code'];
        $sp_subcode = $this->sp_subcode; // \Yii::$app->params['GePG']['sp_subcode'];
        $service_provider_id = $this->sp_id; // \Yii::$app->params['GePG']['sp_id'];
        /////bill details
        $bill_no = $params["bill_number"];
        $bill_amount = $params["amount"];
        $bill_type = $params['bill_type']; // e.g 140313
        $bill_desc = $params['bill_description']; // Bill details "Application Fees Payment";
        $bill_gen_date = $params['bill_gen_date']; //date('Y-m-d' . '\T' . 'H:i:s');
        $bill_gernerated_by = $params['bill_gernerated_by'];
        $bill_payer_id = $params['bill_payer_id'];
        $bill_payer_name = trim($params['payer_name']);
        $payer_phone_number = trim($params["payer_phone_number"]);
        $bill_reference_table_id=$params['bill_reference_table_id'];
        $bill_reference_table=$params['bill_reference_table'];
        $bill_expiry_date=$params['bill_expiry_date'];
        $payer_email = "";
        $content = "<gepgBillSubReq>" .
                "<BillHdr>" .
                "<SpCode>" . $sp_code . "</SpCode>" .
                "<RtrRespFlg>true</RtrRespFlg>" .
                "</BillHdr>" .
                "<BillTrxInf>" .
                "<BillId>" . $bill_no . "</BillId>" .
                "<SubSpCode>" . $sp_subcode . "</SubSpCode>" .
                "<SpSysId>" . $service_provider_id . "</SpSysId>" .
                "<BillAmt>" . $bill_amount . "</BillAmt>" .
                "<MiscAmt>0</MiscAmt>" .
                "<BillExprDt>" . Date('Y-m-d' . '\T' . 'h:i:s', strtotime("+$bill_expiry_date days")) . "</BillExprDt>" .
                "<PyrId>" . $bill_payer_id . "</PyrId>" .
                "<PyrName>" . $bill_payer_name . "</PyrName>" .
                "<BillDesc>" . $bill_desc . "</BillDesc>" .
                "<BillGenDt>" . $bill_gen_date . "</BillGenDt>" .
                "<BillGenBy>" . $bill_gernerated_by . "</BillGenBy>" .
                "<BillApprBy>" . $bill_payer_name . "</BillApprBy>" .
                "<PyrCellNum>" . $payer_phone_number . "</PyrCellNum>" .
                "<PyrEmail>" . $payer_email . "</PyrEmail>" .
                "<Ccy>TZS</Ccy>" .
                "<BillEqvAmt>" . $bill_amount . "</BillEqvAmt>" .
                "<RemFlag>false</RemFlag>" .
                "<BillPayOpt>3</BillPayOpt>" .
                "<BillItems>" .
                "<BillItem>" .
                "<BillItemRef>" . $bill_no . "</BillItemRef>" .
                "<UseItemRefOnPay>N</UseItemRefOnPay>" .
                "<BillItemAmt>" . $bill_amount . "</BillItemAmt>" .
                "<BillItemEqvAmt>" . $bill_amount . "</BillItemEqvAmt>" .
                "<BillItemMiscAmt>0</BillItemMiscAmt>" .
                "<GfsCode>" . $bill_type . "</GfsCode>" .
                "</BillItem>" .
                "</BillItems>" .
                "</BillTrxInf>" .
                "</gepgBillSubReq>";
        $signature = $this->generateSignature($content);
        $data_string = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
        return $this->postRequest($data_string);
    }

    /*
     * function to acknowedge GePG request
     * $request_type : acknowlege types(1,2,3)
     * 
     */

    public function sendAcknowledgment($request_type) {
        if (isset($request_type)) {
            $content = NULL;
            switch ($request_type) {
                case 1: ///accept/acknowledge bill payments/data from gepg
                    $content = "<gepgPmtSpInfoAck><TrxStsCode>7201</TrxStsCode> </gepgPmtSpInfoAck>";

                    break;
                case 2://accept/acknowledge  bill controll number details/data from gepg
                    $content = "<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode> </gepgBillSubRespAck>";

                    break;

                case 3://accept/acknowledge reconciliation request/data from gepg
                    $content = "<gepgSpReconcRespAck><ReconcStsCode>7101</ReconcStsCode></gepgSpReconcRespAck>";

                    break;
            }
            if ($content) {
                $signature = $this->generateSignature($content);

                $response = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
                echo $response;
            }
        }
    }

    /*
     * used to cancel any bill sent to GePG system
     * $params: Bill parameters required to cancel the bill
     */
 ###commented by me telesphory####
    /*
    public function cancelBill($params) {
        $content = "<gepgBillCanclReq>" .
                "<SpCode>" . $SpCode . "</SpCode>" .
                "<SpSysId>" . $SpSysId . "</SpSysId>" .
                "<BillId>" . $BillId1 . "</BillId>" .
                "</gepgBillCanclReq>";
        $signature = $this->generateSignature($signature);  //output crypted data base64 encoded
        $data_string = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
        return $this->postRequest($data_string);
    }
*/
    ############end commented by me telesphory##############
    public function postReconciliation($params) {
        $content = "<gepgSpReconcReq>" .
                "<SpReconcReqId>" . $params['SpReconcReqId'] . "</SpReconcReqId>" .
                "<SpCode>" . $this->sp_code . "</SpCode>" .
                "<SpSysId>" . $this->sp_id . "</SpSysId>" .
                "<TnxDt>" . $params['TnxDt'] . "</TnxDt>" .
                "<ReconcOpt>" . $params['ReconcOpt'] . "</ReconcOpt>" .
                "</gepgSpReconcReq>";

        $signature = $this->generateSignature($content);
        $data_string = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";
        /*
          $post_recon_url = $this->post_url;
          $ch = curl_init($post_recon_url);
          curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type:application/xml',
          'Gepg-Com:default.sp.in',
          'Gepg-Code:' . $this->gfs_code,
          'Content-Length:' . strlen($data_string))
          );
          curl_setopt($ch, CURLOPT_TIMEOUT, 5);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
          //Capture returned content from GePG
          $resultCurlPost = curl_exec($ch);
          curl_close($ch);
          return $resultCurlPost; */
        return $this->postRequest($data_string);
    }

}
