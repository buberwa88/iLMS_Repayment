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
class GSSPSoapClient extends Component {

    //put your code here
    public $url; //the end point of the GSSP System: soap server request url//location 
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
        /*  if (is_array($config)) {    
          if (isset($config['url'])) {
          $this->url = $config['url'];
          }
          if (isset($config['wsdl_url'])) {
          $this->wsdl_url = $config['wsdl_url'];
          }
          if (isset($config['soap_version'])) {
          $this->soap_version = $config['soap_version'];
          }
          if (isset($config['password'])) {
          $this->password = $config['password'];
          }
          if (isset($config['password'])) {
          $this->password = $config['username'];
          }
          if (isset($config['proxy_host'])) {
          $this->proxy_host = $config['proxy_host'];
          }
          if (isset($config['proxy_port'])) {
          $this->proxy_port = $config['proxy_port'];
          }
          if (isset($config['proxy_login'])) {
          $this->proxy_login = $config['proxy_login'];
          }

          if (isset($config['proxy_password'])) {
          $this->proxy_password = $config['proxy_password'];
          }
          if (isset($config['encoding'])) {
          $this->encoding = $config['encoding'];
          }
          if (isset($config['compression'])) {
          $this->compression = $config['compression'];
          }
          if (isset($config['cache_wsdl'])) {
          $this->cache_wsdl = $config['cache_wsdl'];
          }
          if (isset($config['trace'])) {
          $this->trace = $config['trace'];
          }
          } */
    }

    public function init() {

        parent::init();
    }

    /*
     * checks and create authentication
     */

    private function getGSSPSoapClient() {
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
        return new SoapClient($this->wsdl_url, $params);
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

    protected function sendControlNumber($data) {
        $request_string = "<monthDeducContrnumber>
                   <DeducContrnumberInfo>
                   <DeductionCode>" . $data['deductionCode'] . "</DeductionCode>
                   <ContrNumber>" . $data['controlNo'] . "</ContrNumber>
                   <amount>" . $data['amount'] . "</amount>
                   <ctrlnDate>" . date('Y-m-d H:i:s', strtotime($data['controlNoDate'])) . "</ctrlnDate>
                   <deducMonth>" . $data['deductionMonth'] . "</deducMonth>
                   <deductYear>" . $data['deductionYear'] . "</deductYear>
                   </DeducContrnumberInfo>
                   </monthDeducContrnumber>";
        //generating/getting the xml request object/DOM
        $request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        // return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
        return $response = $client->__soapCall($request, array(1));
    }

    /*
     * returns the monthly payment done by GSSPG to HESLB
     */

    protected function getPaidEmployees($paymentMonth, $paymentYear) {
        $request_string = "<monthDeducContrnumber>
                   <DeducContrnumberInfo>
                   <deducMonth>" . $paymentMonth . "</deducMonth>
                   <deductYear>" . $paymentYear . "</deductYear>
                   </DeducContrnumberInfo>
                   </monthDeducContrnumber>";
        //generating/getting the xml request object/DOM
        $request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
    }

    /*
     * returns the monthly payment done by GSSPG to HESLB
     */

    protected function getMonthlyGSSPHelbPayment($paymentMonth, $paymentYear) {
        $request_string = "<monthDeducContrnumber>
                   <DeducContrnumberInfo>
                   <deducMonth>" . $paymentMonth . "</deducMonth>
                   <deductYear>" . $paymentYear . "</deductYear>
                   </DeducContrnumberInfo>
                   </monthDeducContrnumber>";
        //generating/getting the xml request object/DOM
        $request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
    }

}
