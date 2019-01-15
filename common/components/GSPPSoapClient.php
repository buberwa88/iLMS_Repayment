<?php

/*
 * This cclass comntains the most important trd thtat nededs documentation.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use yii\base\Component;

/**
 * Description of GSSPClent
 *
 * @author charles
 */
class GSPPSoapClient extends Component {

    //put your code here
    public $uri; //the end point of the GSSP System: soap server request url//location 
    public $wsdl_url; ///the soap wsdl to be used
    public $soap_version; //  sorapversion to use SOAP_1_2 SOAP_1_1
    public $password; //soap server username
    public $username;  //soap server password
    public $proxy_host;
    public $proxy_port;
    public $proxy_login;
    public $proxy_password;
    public $encoding;
    public $compression; //SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | 9
    public $cache_wsdl;
    public $trace;

    public function __construct($config = []) {
        parent::__construct($config);
	}

    public function init() {

        parent::init();
		
    }

    /*
     * checks and create authentication
     */

    public function getGSSPSoapClient() {
        /////setting soap pareamters
        $params = [];
        if ($this->url) {
            $params['url'] = $this->url;
        }
        if ($this->wsdl_url) {
            $params['wsdl_url'] = $this->wsdl_url;
        }
        if ($this->soap_version) {
            $params['soap_version'] = $this->soap_version;
        }
        if ($this->password) {
            $params['password'] = $this->password;
        }
        if ($this->username) {
            $params['username'] = $this->username;
        }
        if ($this->proxy_host) {
            $params['proxy_host'] = $this->proxy_host;
        }
        if ($this->proxy_port) {
            $params['proxy_port'] = $this->proxy_port;
        }
        if ($this->proxy_login) {
            $params['proxy_login'] = $this->proxy_login;
        }

        if ($this->proxy_password) {
            $params['proxy_password'] = $this->proxy_password;
        }
        if ($this->encoding) {
            $params['encoding'] = $this->encoding;
        }
        if ($this->compression) {
            $params['compression'] = $this->compression;
        }
        if ($this->cache_wsdl) {
            $params['cache_wsdl'] = $this->cache_wsdl;
        }
        if ($this->trace) {
            $params['trace'] = $this->trace;
        }
        //////initializing a client
        return new GSPPSoapClient($this->wsdl_url, $params);
    }

    /*
     * This function takes in an xml formated strubg and cinvert it into xml request object/DOM
     */

    protected function generateSoapRequestXMLDOM($xml_string) {
        //$request = simplexml_load_string($request);
        return new \SoapVar($xml_string, XSD_ANYXML);
    }

    /*
     * Function to sends controll number details to GSSPG
     * it takes in controller number detail as array and send it to the GSSP
     * see Sample: 
     * ['deductionCode'=>'465',
     *  'controlNo'=>'99110787425242',
     *  'amount'=>20999,
     *  'controlNoDate'=>'2018-05-28 14:23:12',
     *  'deductionMonth'=>'05'
     *  'deductionYear'=>'2018'     *         
     * ]
     */

    public function sendControlNumber($data) {
        $controlNumber=$data['controlNo'];
        $request_string = "<monthDeducContrnumber>
                   <DeducContrnumberInfo>
                   <DeductionCode>" . $data['deductionCode'] . "</DeductionCode>
                   <ContrNumber>" . $data['controlNo'] . "</ContrNumber>
                   <amount>" . $data['amount'] . "</amount>
                   <totalEmployees>" . $data['totalEmployees'] . "</totalEmployees>
                   <ctrlnDate>" . date('Y-m-d H:i:s', strtotime($data['controlNoDate'])) . "</ctrlnDate>
                   <deducMonth>" . $data['deductionMonth'] . "</deducMonth>
                   <deductYear>" . $data['deductionYear'] . "</deductYear>
                   </DeducContrnumberInfo>
                   </monthDeducContrnumber>";
        //generating/getting the xml request object/DOM
        //$request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        // return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
        //return $response = $client->__soapCall($request, array(1));
        //print_r($data);exit;
        //to update if confirmed received to GSPP
        \frontend\modules\repayment\models\GepgLawson::confirmControlNumberSentToGSPP($controlNumber);
    }

    /*
     * returns the monthly payment done by GSSPG to HESLB
     */

    public function getPaidEmployees($paymentMonth, $paymentYear) {
        /*
        $request_string = "<monthDeducContrnumber>
                   <DeducContrnumberInfo>
                   <deducMonth>" . $paymentMonth . "</deducMonth>
                   <deductYear>" . $paymentYear . "</deductYear>
                   </DeducContrnumberInfo>
                   </monthDeducContrnumber>";
        */
        //$request_string=;
        //generating/getting the xml request object/DOM
        //$request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        $request=$request_string;
        //return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
        return $request_string;
    }

	/*
	  Authentcation
	  */
	  function setAuthentication(){
	    $ch = curl_init();        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username.":".$this->password);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        return $ch;  
	  }
	
    /*
     * returns the monthly payment done by GSSPG to HESLB
     */

    public function getMonthlyGSSPHelbPayment($paymentMonth, $paymentYear) {
		//setting api auth deateail
        $obj=$this->setAuthentication();   
		//sending api 
		$url=$this->uri."deductions/getdeductions?month=".$paymentMonth."&year=".$paymentYear;
        curl_setopt($obj, CURLOPT_URL, $url);
		//curl_setopt($obj, CURLOPT_TIMEOUT, 50);
        //curl_setopt($obj, CURLOPT_CONNECTTIMEOUT, 50);
        ///request data from the api		
          $output = curl_exec($obj);
		 $info = curl_getinfo($obj);
        curl_close($obj);
		if($info['http_code']==200){
			return $output;
            //return $info;	
		}else if($info['http_code']==0){
			//No connection
			return '';
		}else{
			//Unknown request
			return '';
		}
    }
	/*
    public function getMonthlyGSSPHelbPayment11($paymentMonth, $paymentYear) {
        $url="http://192.168.5.194/gsppApipilot/api/deductions/getdeductions?month=".$paymentMonth."&year=".$paymentYear;
        $username="HESLB";
        $password="User@Heslb123";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $url);		
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);


        return $output;
    }*/

    public function getMonthlyDeductionSummary($paymentMonth, $paymentYear) {		
		//setting api auth deateail
        $obj=$this->setAuthentication();   
		//sending api 
		$url=$this->uri."deductions/getdeductionsummary?month=".$paymentMonth."&year=".$paymentYear;
        curl_setopt($obj, CURLOPT_URL, $url);
		//curl_setopt($obj, CURLOPT_TIMEOUT, 50);
        //curl_setopt($obj, CURLOPT_CONNECTTIMEOUT, 50);
        ///request data from the api		
          $output = curl_exec($obj);
		 $info = curl_getinfo($obj);
        curl_close($obj);
        if($info['http_code']==200){
			return $output;
            //return $info;	
		}else if($info['http_code']==0){
			//No connection
			return '';
		}else{
			//Unknown request
			return '';
		}
    }
	/*
	public function getMonthlyDeductionSummary($paymentMonth, $paymentYear) {
        $url="http://192.168.5.194/gsppApipilot/api/deductions/getdeductionsummary?month=".$paymentMonth."&year=".$paymentYear;
        $username="HESLB";
        $password="User@Heslb123";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
		
		return $output;
    }
	*/

}
