<?php

/**
 * Description of Componest
 * This component integrated with the API od the SMS gateway to be able to send the SS to a customer/number
 * @author Charles Mhoja
 * @email charlesmhoja@gmail.com
 */

namespace common\components;

use yii\base\Component;

class SMSGateway extends Component {

    public $url; //the end point of the SMSGateway url where the request will be sent to
    public $channel; /// the gateway 
    public $source_sender;
    public $password;
    public $method; ///GET or POST

    /*
     * constructor
     *  $config = [
      'url' => 'https://secure-gw.fasthub.co.tz/fasthub/messaging/json/api',
      'channel' => '1183333334',
      'source_sender' => 'SENDERNAME',
      'password' => '123123123',
      'method' => 'POST', POST or GET
      ];
     */

    public function __construct($config = []) {
        parent::__construct($config);
    }

    public function init() {
        parent::init();
        if (!empty($this->password)) {
            $this->encodeGwPassword(); ///encoding the password
        }
        // ... initialization after configuration is applied
    }

    /*
     * function to send sms based in the sms gateway used
     * $msisdn: eg: 255754088816
     */

    public function sendSMS($msisdn, $sms) {
        if (strlen($msisdn) == 12 && !empty($sms)) {
            $json_request = '{
		"channel":{
		 "channel":' . $this->channel . ',
		 "password":"' . $this->password . '" 
			},
		"messages":[
			{
			"text":"' . $sms . '",
			"msisdn":"' . $msisdn . '",
			"source":"' . $this->source_sender . '"
			}
			]
                }';
            //$json_request = json_encode($json_request);
            return $this->submitRequest($json_request);
        }
    }

    public function getSMSDeliveryStatus($msisdn, $refernce_id) {
        //class SMSGateway extends yii\base\BaseObject {
        $json_request = '{
	     "receipts":[
			{
			"reference_id":"' . $refernce_id . '",
			"msisdn":"' . $msisdn . '",
			"status":"D"
			}
			]
                  }';
//        $json_request = json_encode($json_request);
        return $this->submitRequest($json_request);
    }

    /*
     * this functions sends a request to the SMSGetway based on the json request parameter
     * It is the function that communicates to the SMSGateway to submit the reqyest
     */

    public function submitRequest($json_request) {
        ////////////SENDING A REQUEST VIA CURL
        $curl = curl_init();
        //method pst or get
        switch ($this->method) {
            case 'POST': // setting curl method as POST
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POSTFIELDS, trim($json_request));
                break;

            case 'GET': ///setting th curl method as GET
                curl_setopt($curl, CURLOPT_POST, 0);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            default:
                if (trim($json_request) !== null) {
                    $url = sprintf("%s?%s", $this->url, http_build_query(trim($json_request)));
                }
        }
        ///end method
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //Authentication [Optional]
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "'.$this->channel.':'$this->password"); /// autentication information  "username:password"
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*
     * encodes the channel GW passwrd
     */

    function encodeGwPassword() {
        $this->password = base64_encode(hash('sha256', $this->password)); /// encoding the gateway password to required format
    }

    function TEST() {
      //SENDER: UDSM or HESLB
        $config = [
            'url' => 'https://secure-gw.fasthub.co.tz/fasthub/messaging/json/api',
            'channel' => '118334',
            'source_sender' => 'HESLB',
            'password' => 'Ud@sM#',
            'method' => 'POST',
        ];
        //initilize the component
        $SMSGW = new \common\components\SMSGateway($config);
        //sending SMS
        var_dump($SMSGW->sendSMS(255754711426, 'Test Test Test'));
        var_dump($SMSGW->getSMSDeliveryStatus(255754711426, 'HlPqpvBQyF7641NOmohXs0E342bUwK'));
        exit();
        ///END Send SMS Test
    }

}
