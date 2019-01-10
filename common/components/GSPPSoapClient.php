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
        $request_string='<ArrayOfDeductions xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/GPP.Models">
    <Deductions>
        <ActualBalanceAmount>4044600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791785</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Dodoma           </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>YUSUPH                        </FirstName>
        <LastName>FADHILI                        </LastName>
        <MiddleName>MAX                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8504400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791794</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Arusha           </DeptName>
        <Deptcode>2004 </Deptcode>
        <FirstName>TARSILA                       </FirstName>
        <LastName>ASENGA                        </LastName>
        <MiddleName>GERVAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1177050.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10989847</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Internal Audit                </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Selina                        </FirstName>
        <LastName>Wangilisasi                   </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ethics Secretariat            </VoteName>
        <Votecode>33   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13791587.78</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10087743</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sylvester</FirstName>
        <LastName>Mwashilindi                   </LastName>
        <MiddleName>Raphael                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6632680.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11994356</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>Joseph                        </FirstName>
        <LastName>Ndumuka                       </LastName>
        <MiddleName>Philemon                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8034750.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111066695</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Mwambani Hospital             </DeptName>
        <Deptcode>1015 </Deptcode>
        <FirstName>EDDAH                         </FirstName>
        <LastName>BWAKILA                       </LastName>
        <MiddleName>GERALD                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Designated District Hospitals </VoteName>
        <Votecode>N1   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5029460.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11494867</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>GS2 and Above                 </DeptName>
        <Deptcode>5004 </Deptcode>
        <FirstName>Abdallah                      </FirstName>
        <LastName>Mvungi                        </LastName>
        <MiddleName>Mohamed                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5607293.91</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426029</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>MAGRETH                       </FirstName>
        <LastName>KHALIFA                       </LastName>
        <MiddleName>AZIZI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2847460.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110609868</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>HERMAN                        </FirstName>
        <LastName>KESSY                         </LastName>
        <MiddleName>GEORGE                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8220200.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111119859</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SULEKHA                       </FirstName>
        <LastName>AHMED                         </LastName>
        <MiddleName>ABDI                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5517780.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11733047</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>138150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Weight &amp; Measure              </DeptName>
        <Deptcode>3003 </Deptcode>
        <FirstName>Maneno                        </FirstName>
        <LastName>Mwakibete                     </LastName>
        <MiddleName>Popati                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Weights &amp; Measures Agency     </VoteName>
        <Votecode>S3   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2149675.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110804039</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>60150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>JACKSON                       </FirstName>
        <LastName>VENANCE                       </LastName>
        <MiddleName>ESTER                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Coast Region                  </VoteName>
        <Votecode>71   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9049893.65</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111301706</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DAVID                         </FirstName>
        <LastName>MWANI                         </LastName>
        <MiddleName>EZEKIEL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5732600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111256025</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Irene                         </FirstName>
        <LastName>Kihwelo                       </LastName>
        <MiddleName>Gerald                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2672872.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12236524</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Atukuzwe                      </FirstName>
        <LastName>Mwanjala                      </LastName>
        <MiddleName>ISSACK                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4677927.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110841206</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Steven                        </FirstName>
        <LastName>Kibona                        </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>884954.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9254585</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Grace                         </FirstName>
        <LastName>Bwaye                         </LastName>
        <MiddleName>PASCHAL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10627065.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10738698</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Dionista                      </FirstName>
        <LastName>Thomas                        </LastName>
        <MiddleName>Donasian                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7393225.50</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11286417</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ramadhani                     </FirstName>
        <LastName>Msuya                         </LastName>
        <MiddleName>Shabani                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2685237.66</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001697</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Ruvuma           </DeptName>
        <Deptcode>2013 </Deptcode>
        <FirstName>HELLEN                        </FirstName>
        <LastName>CHUMA                         </LastName>
        <MiddleName>MARTIN                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>19396059.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10583500</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Halima                        </FirstName>
        <LastName>Kassim                        </LastName>
        <MiddleName>MOHAMED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6652400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494583</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Optatus                       </FirstName>
        <LastName>Mtitu                         </LastName>
        <MiddleName>MARCUS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7382555.20</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110572087</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MODESTA                       </FirstName>
        <LastName>NJOBO                         </LastName>
        <MiddleName>LUCAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>17186806.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111505876</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Preventive Services           </DeptName>
        <Deptcode>5011 </Deptcode>
        <FirstName>JULIUS                        </FirstName>
        <LastName>JOSEPHAT                      </LastName>
        <MiddleName>KEHONGO                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8585400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426013</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LONGINO                       </FirstName>
        <LastName>KUMUGISHA                     </LastName>
        <MiddleName>RWEGOSHORA                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9237874.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10925854</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aneth                         </FirstName>
        <LastName>Shoo                          </LastName>
        <MiddleName>Elimuu                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10542095.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111712431</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MASOUD                        </FirstName>
        <LastName>MASOUD                        </LastName>
        <MiddleName>HAMAD                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9089700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10512023</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Hussein                       </FirstName>
        <LastName>Lufulondama                   </LastName>
        <MiddleName>Nteminyanda                                       </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11662745.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111294853</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>LEOCARDIA                     </FirstName>
        <LastName>HENRY                         </LastName>
        <MiddleName>PELANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11722445.55</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12308306</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SALOME                        </FirstName>
        <LastName>GULENGA                       </LastName>
        <MiddleName>SOLOMON                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12571034.22</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10227673</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Daniela                       </FirstName>
        <LastName>Nyoni                         </LastName>
        <MiddleName>Simon                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12109170.16</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110770405</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture                   </DeptName>
        <Deptcode>5033 </Deptcode>
        <FirstName>Underson                      </FirstName>
        <LastName>Said                          </LastName>
        <MiddleName>Ahadi                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>564190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11972707</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Crop Development              </DeptName>
        <Deptcode>2001 </Deptcode>
        <FirstName>Juma                          </FirstName>
        <LastName>Mwinyimkuu                    </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7494470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111227790</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aldo                          </FirstName>
        <LastName>Mbilinyi                      </LastName>
        <MiddleName>Aldo                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14205098.33</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12267878</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>WILSON                        </FirstName>
        <LastName>SENKORO                       </LastName>
        <MiddleName>EXAUDY                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12698124.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10705764</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Yustina                       </FirstName>
        <LastName>Lyandala                      </LastName>
        <MiddleName>Henry                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13570337.67</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10703623</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Gerald                        </FirstName>
        <LastName>Mwakyuse                      </LastName>
        <MiddleName>ALFRED                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6500010.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8874599</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Patrisia                      </FirstName>
        <LastName>Kahwili                       </LastName>
        <MiddleName>MANFRED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13173142.19</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111912034</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Zerafina                      </FirstName>
        <LastName>Gotora                        </LastName>
        <MiddleName>Boaz                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Cooperative Dev. Commision    </VoteName>
        <Votecode>24   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12392942.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494480</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sihaba                        </FirstName>
        <LastName>ngole                         </LastName>
        <MiddleName>TWAHA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1490969.18</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9823767</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>184650.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Leonida                       </FirstName>
        <LastName>Tawa                          </LastName>
        <MiddleName>CHIPANHA                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2829900.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791866</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Mbeya            </DeptName>
        <Deptcode>2010 </Deptcode>
        <FirstName>PRIVA                         </FirstName>
        <LastName>MAZULA                        </LastName>
        <MiddleName>PRIMI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7364340.41</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111911271</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Lushoto  </DeptName>
        <Deptcode>1008 </Deptcode>
        <FirstName>NICODEMAS                     </FirstName>
        <LastName>MWIKOZI                       </LastName>
        <MiddleName>TAMBO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8038760.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111000817</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Pendaeli                      </FirstName>
        <LastName>Massay                        </LastName>
        <MiddleName>Elibariki                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Singida Region                </VoteName>
        <Votecode>84   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16842409.81</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9285183</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Vumilia                       </FirstName>
        <LastName>Paulo                         </LastName>
        <MiddleName>NKABO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6210825.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111470973</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Odilia                        </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Ditrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>994700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110575656</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>BENADETHA                     </FirstName>
        <LastName>TIIBUZA                       </LastName>
        <MiddleName> PETER                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5497342.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8704898</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>421500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Wilfred                       </FirstName>
        <LastName>Magige                        </LastName>
        <MiddleName>WAISARILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9246875.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111531318</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Shabani                       </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Sharifu                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8660100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111424869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>115500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>HUSSEIN                       </FirstName>
        <LastName>MKWILI                        </LastName>
        <MiddleName>IBRAHIM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3593855.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111086003</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>TSC-Districts                 </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>SOPHIA                        </FirstName>
        <LastName>MSANGI                        </LastName>
        <MiddleName>ABDALLAH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanzania Teachers Commission  </VoteName>
        <Votecode>02   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11302347.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111026936</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Hospitali Teule ya Rufaa -Mkoa</DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>JOSEPH                        </FirstName>
        <LastName>EDWARD                        </LastName>
        <MiddleName>MALIMA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Region                  </VoteName>
        <Votecode>63   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10548850.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110499655</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>103350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Igogwe Hospital               </DeptName>
        <Deptcode>1012 </Deptcode>
        <FirstName>Jane                          </FirstName>
        <LastName>Mahenge                       </LastName>
        <MiddleName>Yusuph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Voluntary Agency Hospitals    </VoteName>
        <Votecode>N0   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3004280.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10967276</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Neema                         </FirstName>
        <LastName>Duwe                          </LastName>
        <MiddleName>Gulmay                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>47144332.54</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111714422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LUFUNYO                       </FirstName>
        <LastName>LIHWEULI                      </LastName>
        <MiddleName>EDSON                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3158433.36</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791896</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Morogoro         </DeptName>
        <Deptcode>2025 </Deptcode>
        <FirstName>EVELYNE                       </FirstName>
        <LastName>NDUNGURU                      </LastName>
        <MiddleName>NARCIS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8131470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001730</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Shinyanga        </DeptName>
        <Deptcode>2017 </Deptcode>
        <FirstName>UPENDO                        </FirstName>
        <LastName>SHEMKOLE                      </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3206030.46</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805364</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AGNES                         </FirstName>
        <LastName>BIMBOMA                       </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7436092.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111691877</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JENESTA                       </FirstName>
        <LastName>GREVASE                       </LastName>
        <MiddleName>BASIMAKI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8378412.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111536757</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Resta                         </FirstName>
        <LastName>Nyava                         </LastName>
        <MiddleName>Joshua                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9163812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111575750</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Fredy                         </FirstName>
        <LastName>Edwin                         </LastName>
        <MiddleName>Mwasalanga                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10104151.64</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715505</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ahiadu                        </FirstName>
        <LastName>Sangoda                       </LastName>
        <MiddleName>Amiri                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>629100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8997078</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Probation and Community Servic</DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Hamisi                        </FirstName>
        <LastName>Jengela                       </LastName>
        <MiddleName>ANDREA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ministry of Home Affairs      </VoteName>
        <Votecode>51   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2826627.53</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110923004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JEMA                          </FirstName>
        <LastName>MPESA                         </LastName>
        <MiddleName>WILLIAM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6726190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715996</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Theresia                      </FirstName>
        <LastName>Shokole                       </LastName>
        <MiddleName>Yusti                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2402434.05</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11978525</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>179700.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Tanz. Fisheries Research Inst </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Asilatu                       </FirstName>
        <LastName>Shechonge                     </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanz. Fisheries Research Inst </VoteName>
        <Votecode>TR07 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16189344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111507937</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>GOODLUCK                      </FirstName>
        <LastName>MBWILLO                       </LastName>
        <MiddleName>YOHANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8635475.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111717386</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Bestina                       </FirstName>
        <LastName>Murobi                        </LastName>
        <MiddleName>Ladislaus                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14872120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11529400</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Livestock                     </DeptName>
        <Deptcode>5034 </Deptcode>
        <FirstName>Isdory                        </FirstName>
        <LastName>Karia                         </LastName>
        <MiddleName>Jacob                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13406327.70</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110748594</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Paskalia                      </FirstName>
        <LastName>Sitembela                     </LastName>
        <MiddleName>Chrispin                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1108339.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111595848</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JACOB                         </FirstName>
        <LastName>JONH                          </LastName>
        <MiddleName>NHAMANILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7806462.47</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110987869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Njombe   </DeptName>
        <Deptcode>1005 </Deptcode>
        <FirstName>Emmanuel                      </FirstName>
        <LastName>George                        </LastName>
        <MiddleName>Deogratius                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Njombe Region                 </VoteName>
        <Votecode>54   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11576145.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111594173</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AMOS                          </FirstName>
        <LastName>MATHIAS                       </LastName>
        <MiddleName>LENGOKO                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3828720.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11997748</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>188250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Planning Division             </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Vonyvaco                      </FirstName>
        <LastName>Luvanda                       </LastName>
        <MiddleName>HEBELI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3239470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8794004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Ales                          </FirstName>
        <LastName>Mahelela                      </LastName>
        <MiddleName>LUGANO                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9485245.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111710447</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MARIAM                        </FirstName>
        <LastName>JILASA                        </LastName>
        <MiddleName>ELIAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7775930.93</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110687528</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CHRISTINA                     </FirstName>
        <LastName>KIANGIO                       </LastName>
        <MiddleName>JOHN                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Municipal Council      </VoteName>
        <Votecode>7205 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8534436.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10228728</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Eliya                         </FirstName>
        <LastName>Malila                        </LastName>
        <MiddleName>MARIO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12576215.37</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10333196</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>182250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Hilda                         </FirstName>
        <LastName>Mushi                         </LastName>
        <MiddleName>HONORATH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha Region                 </VoteName>
        <Votecode>70   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3781667.07</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11281102</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Angela                        </FirstName>
        <LastName>Tarimo                        </LastName>
        <MiddleName>Joseph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9492590.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9500422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Majaliwa                      </FirstName>
        <LastName>Mawazo                        </LastName>
        <MiddleName>COSMAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13381364.01</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9478824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Rukia                         </FirstName>
        <LastName>Kombo                         </LastName>
        <MiddleName>SAIDI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1709316.40</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9730270</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>479250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dentistry                     </DeptName>
        <Deptcode>0018 </Deptcode>
        <FirstName>OMAR                          </FirstName>
        <LastName>MAALIM                        </LastName>
        <MiddleName>HAMZA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Muhimbili Medical Centre      </VoteName>
        <Votecode>TR129</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7378812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111562715</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Benitha                       </FirstName>
        <LastName>Ngimbudzi                     </LastName>
        <MiddleName>Ben                                               </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9711127.56</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9783874</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Gaudencia                     </FirstName>
        <LastName>Wapalila                      </LastName>
        <MiddleName>EPHRAHIM                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9709190.97</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10894286</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Tumaini                       </FirstName>
        <LastName>Mgina                         </LastName>
        <MiddleName>YESSE                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6301320.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8572312</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Justine                       </FirstName>
        <LastName>Lisulile                      </LastName>
        <MiddleName>YIHOSWA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4806120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805332</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CATHERINE                     </FirstName>
        <LastName>PAHALI                        </LastName>
        <MiddleName>FELICIAN                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2925256.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12240421</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DOMINICK                      </FirstName>
        <LastName>MWEMUTSI                      </LastName>
        <MiddleName>BONIFASI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2393282.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12270993</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ALOYCE                        </FirstName>
        <LastName>MURUNGU                       </LastName>
        <MiddleName>ELLY                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6601990.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10661297</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ghati                         </FirstName>
        <LastName>Ryoba                         </LastName>
        <MiddleName>Magoiga                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9305294.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12056454</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Witness                       </FirstName>
        <LastName>Bashaka                       </LastName>
        <MiddleName>JASSON                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2712344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12296177</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MAGDALENA                     </FirstName>
        <LastName>MBOYA                         </LastName>
        <MiddleName>LINDA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13671860.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111741598</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Tabora           </DeptName>
        <Deptcode>2015 </Deptcode>
        <FirstName>TITO                          </FirstName>
        <LastName>MWAKALINGA                    </LastName>
        <MiddleName>AMBANGILE                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9509300.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110972155</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>ABRAHAM                       </FirstName>
        <LastName>MWAKASUNGULA                  </LastName>
        <MiddleName>NEHEMIA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10348898.75</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111589824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ORESTO                        </FirstName>
        <LastName>MLIGO                         </LastName>
        <MiddleName>JOSEPH                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8572822.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10481156</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Patrick                       </FirstName>
        <LastName>Kastomu                       </LastName>
        <MiddleName>nzowa                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9720600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10347494</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>114000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>District Court                </DeptName>
        <Deptcode>2306 </Deptcode>
        <FirstName>Sabato                        </FirstName>
        <LastName>Mwangwa                       </LastName>
        <MiddleName>Mukaka                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
</ArrayOfDeductions>';
        //generating/getting the xml request object/DOM
        //$request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        //return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
        return $request_string;
    }

    /*
     * returns the monthly payment done by GSSPG to HESLB
     */

    public function getMonthlyGSSPHelbPayment($paymentMonth, $paymentYear) {
        $request_string = '<ArrayOfDeductions xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/GPP.Models">
    <Deductions>
        <ActualBalanceAmount>4044600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791785</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Dodoma           </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>YUSUPH                        </FirstName>
        <LastName>FADHILI                        </LastName>
        <MiddleName>MAX                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8504400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791794</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Arusha           </DeptName>
        <Deptcode>2004 </Deptcode>
        <FirstName>TARSILA                       </FirstName>
        <LastName>ASENGA                        </LastName>
        <MiddleName>GERVAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1177050.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10989847</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Internal Audit                </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Selina                        </FirstName>
        <LastName>Wangilisasi                   </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ethics Secretariat            </VoteName>
        <Votecode>33   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13791587.78</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10087743</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sylvester</FirstName>
        <LastName>Mwashilindi                   </LastName>
        <MiddleName>Raphael                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6632680.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11994356</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>Joseph                        </FirstName>
        <LastName>Ndumuka                       </LastName>
        <MiddleName>Philemon                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8034750.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111066695</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Mwambani Hospital             </DeptName>
        <Deptcode>1015 </Deptcode>
        <FirstName>EDDAH                         </FirstName>
        <LastName>BWAKILA                       </LastName>
        <MiddleName>GERALD                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Designated District Hospitals </VoteName>
        <Votecode>N1   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5029460.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11494867</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>GS2 and Above                 </DeptName>
        <Deptcode>5004 </Deptcode>
        <FirstName>Abdallah                      </FirstName>
        <LastName>Mvungi                        </LastName>
        <MiddleName>Mohamed                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5607293.91</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426029</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>MAGRETH                       </FirstName>
        <LastName>KHALIFA                       </LastName>
        <MiddleName>AZIZI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2847460.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110609868</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>HERMAN                        </FirstName>
        <LastName>KESSY                         </LastName>
        <MiddleName>GEORGE                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8220200.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111119859</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SULEKHA                       </FirstName>
        <LastName>AHMED                         </LastName>
        <MiddleName>ABDI                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5517780.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11733047</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>138150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Weight &amp; Measure              </DeptName>
        <Deptcode>3003 </Deptcode>
        <FirstName>Maneno                        </FirstName>
        <LastName>Mwakibete                     </LastName>
        <MiddleName>Popati                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Weights &amp; Measures Agency     </VoteName>
        <Votecode>S3   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2149675.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110804039</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>60150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>JACKSON                       </FirstName>
        <LastName>VENANCE                       </LastName>
        <MiddleName>ESTER                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Coast Region                  </VoteName>
        <Votecode>71   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9049893.65</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111301706</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DAVID                         </FirstName>
        <LastName>MWANI                         </LastName>
        <MiddleName>EZEKIEL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5732600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111256025</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Irene                         </FirstName>
        <LastName>Kihwelo                       </LastName>
        <MiddleName>Gerald                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2672872.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12236524</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Atukuzwe                      </FirstName>
        <LastName>Mwanjala                      </LastName>
        <MiddleName>ISSACK                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4677927.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110841206</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Steven                        </FirstName>
        <LastName>Kibona                        </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>884954.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9254585</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Grace                         </FirstName>
        <LastName>Bwaye                         </LastName>
        <MiddleName>PASCHAL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10627065.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10738698</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Dionista                      </FirstName>
        <LastName>Thomas                        </LastName>
        <MiddleName>Donasian                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7393225.50</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11286417</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ramadhani                     </FirstName>
        <LastName>Msuya                         </LastName>
        <MiddleName>Shabani                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2685237.66</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001697</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Ruvuma           </DeptName>
        <Deptcode>2013 </Deptcode>
        <FirstName>HELLEN                        </FirstName>
        <LastName>CHUMA                         </LastName>
        <MiddleName>MARTIN                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>19396059.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10583500</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Halima                        </FirstName>
        <LastName>Kassim                        </LastName>
        <MiddleName>MOHAMED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6652400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494583</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Optatus                       </FirstName>
        <LastName>Mtitu                         </LastName>
        <MiddleName>MARCUS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7382555.20</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110572087</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MODESTA                       </FirstName>
        <LastName>NJOBO                         </LastName>
        <MiddleName>LUCAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>17186806.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111505876</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Preventive Services           </DeptName>
        <Deptcode>5011 </Deptcode>
        <FirstName>JULIUS                        </FirstName>
        <LastName>JOSEPHAT                      </LastName>
        <MiddleName>KEHONGO                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8585400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426013</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LONGINO                       </FirstName>
        <LastName>KUMUGISHA                     </LastName>
        <MiddleName>RWEGOSHORA                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9237874.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10925854</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aneth                         </FirstName>
        <LastName>Shoo                          </LastName>
        <MiddleName>Elimuu                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10542095.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111712431</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MASOUD                        </FirstName>
        <LastName>MASOUD                        </LastName>
        <MiddleName>HAMAD                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9089700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10512023</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Hussein                       </FirstName>
        <LastName>Lufulondama                   </LastName>
        <MiddleName>Nteminyanda                                       </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11662745.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111294853</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>LEOCARDIA                     </FirstName>
        <LastName>HENRY                         </LastName>
        <MiddleName>PELANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11722445.55</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12308306</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SALOME                        </FirstName>
        <LastName>GULENGA                       </LastName>
        <MiddleName>SOLOMON                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12571034.22</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10227673</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Daniela                       </FirstName>
        <LastName>Nyoni                         </LastName>
        <MiddleName>Simon                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12109170.16</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110770405</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture                   </DeptName>
        <Deptcode>5033 </Deptcode>
        <FirstName>Underson                      </FirstName>
        <LastName>Said                          </LastName>
        <MiddleName>Ahadi                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>564190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11972707</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Crop Development              </DeptName>
        <Deptcode>2001 </Deptcode>
        <FirstName>Juma                          </FirstName>
        <LastName>Mwinyimkuu                    </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7494470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111227790</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aldo                          </FirstName>
        <LastName>Mbilinyi                      </LastName>
        <MiddleName>Aldo                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14205098.33</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12267878</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>WILSON                        </FirstName>
        <LastName>SENKORO                       </LastName>
        <MiddleName>EXAUDY                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12698124.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10705764</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Yustina                       </FirstName>
        <LastName>Lyandala                      </LastName>
        <MiddleName>Henry                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13570337.67</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10703623</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Gerald                        </FirstName>
        <LastName>Mwakyuse                      </LastName>
        <MiddleName>ALFRED                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6500010.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8874599</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Patrisia                      </FirstName>
        <LastName>Kahwili                       </LastName>
        <MiddleName>MANFRED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13173142.19</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111912034</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Zerafina                      </FirstName>
        <LastName>Gotora                        </LastName>
        <MiddleName>Boaz                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Cooperative Dev. Commision    </VoteName>
        <Votecode>24   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12392942.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494480</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sihaba                        </FirstName>
        <LastName>ngole                         </LastName>
        <MiddleName>TWAHA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1490969.18</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9823767</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>184650.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Leonida                       </FirstName>
        <LastName>Tawa                          </LastName>
        <MiddleName>CHIPANHA                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2829900.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791866</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Mbeya            </DeptName>
        <Deptcode>2010 </Deptcode>
        <FirstName>PRIVA                         </FirstName>
        <LastName>MAZULA                        </LastName>
        <MiddleName>PRIMI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7364340.41</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111911271</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Lushoto  </DeptName>
        <Deptcode>1008 </Deptcode>
        <FirstName>NICODEMAS                     </FirstName>
        <LastName>MWIKOZI                       </LastName>
        <MiddleName>TAMBO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8038760.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111000817</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Pendaeli                      </FirstName>
        <LastName>Massay                        </LastName>
        <MiddleName>Elibariki                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Singida Region                </VoteName>
        <Votecode>84   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16842409.81</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9285183</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Vumilia                       </FirstName>
        <LastName>Paulo                         </LastName>
        <MiddleName>NKABO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6210825.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111470973</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Odilia                        </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Ditrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>994700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110575656</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>BENADETHA                     </FirstName>
        <LastName>TIIBUZA                       </LastName>
        <MiddleName> PETER                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5497342.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8704898</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>421500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Wilfred                       </FirstName>
        <LastName>Magige                        </LastName>
        <MiddleName>WAISARILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9246875.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111531318</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Shabani                       </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Sharifu                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8660100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111424869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>115500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>HUSSEIN                       </FirstName>
        <LastName>MKWILI                        </LastName>
        <MiddleName>IBRAHIM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3593855.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111086003</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>TSC-Districts                 </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>SOPHIA                        </FirstName>
        <LastName>MSANGI                        </LastName>
        <MiddleName>ABDALLAH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanzania Teachers Commission  </VoteName>
        <Votecode>02   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11302347.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111026936</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Hospitali Teule ya Rufaa -Mkoa</DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>JOSEPH                        </FirstName>
        <LastName>EDWARD                        </LastName>
        <MiddleName>MALIMA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Region                  </VoteName>
        <Votecode>63   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10548850.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110499655</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>103350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Igogwe Hospital               </DeptName>
        <Deptcode>1012 </Deptcode>
        <FirstName>Jane                          </FirstName>
        <LastName>Mahenge                       </LastName>
        <MiddleName>Yusuph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Voluntary Agency Hospitals    </VoteName>
        <Votecode>N0   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3004280.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10967276</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Neema                         </FirstName>
        <LastName>Duwe                          </LastName>
        <MiddleName>Gulmay                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>47144332.54</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111714422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LUFUNYO                       </FirstName>
        <LastName>LIHWEULI                      </LastName>
        <MiddleName>EDSON                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3158433.36</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791896</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Morogoro         </DeptName>
        <Deptcode>2025 </Deptcode>
        <FirstName>EVELYNE                       </FirstName>
        <LastName>NDUNGURU                      </LastName>
        <MiddleName>NARCIS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8131470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001730</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Shinyanga        </DeptName>
        <Deptcode>2017 </Deptcode>
        <FirstName>UPENDO                        </FirstName>
        <LastName>SHEMKOLE                      </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3206030.46</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805364</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AGNES                         </FirstName>
        <LastName>BIMBOMA                       </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7436092.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111691877</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JENESTA                       </FirstName>
        <LastName>GREVASE                       </LastName>
        <MiddleName>BASIMAKI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8378412.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111536757</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Resta                         </FirstName>
        <LastName>Nyava                         </LastName>
        <MiddleName>Joshua                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9163812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111575750</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Fredy                         </FirstName>
        <LastName>Edwin                         </LastName>
        <MiddleName>Mwasalanga                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10104151.64</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715505</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ahiadu                        </FirstName>
        <LastName>Sangoda                       </LastName>
        <MiddleName>Amiri                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>629100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8997078</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Probation and Community Servic</DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Hamisi                        </FirstName>
        <LastName>Jengela                       </LastName>
        <MiddleName>ANDREA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ministry of Home Affairs      </VoteName>
        <Votecode>51   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2826627.53</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110923004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JEMA                          </FirstName>
        <LastName>MPESA                         </LastName>
        <MiddleName>WILLIAM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6726190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715996</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Theresia                      </FirstName>
        <LastName>Shokole                       </LastName>
        <MiddleName>Yusti                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2402434.05</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11978525</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>179700.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Tanz. Fisheries Research Inst </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Asilatu                       </FirstName>
        <LastName>Shechonge                     </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanz. Fisheries Research Inst </VoteName>
        <Votecode>TR07 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16189344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111507937</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>GOODLUCK                      </FirstName>
        <LastName>MBWILLO                       </LastName>
        <MiddleName>YOHANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8635475.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111717386</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Bestina                       </FirstName>
        <LastName>Murobi                        </LastName>
        <MiddleName>Ladislaus                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14872120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11529400</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Livestock                     </DeptName>
        <Deptcode>5034 </Deptcode>
        <FirstName>Isdory                        </FirstName>
        <LastName>Karia                         </LastName>
        <MiddleName>Jacob                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13406327.70</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110748594</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Paskalia                      </FirstName>
        <LastName>Sitembela                     </LastName>
        <MiddleName>Chrispin                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1108339.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111595848</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JACOB                         </FirstName>
        <LastName>JONH                          </LastName>
        <MiddleName>NHAMANILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7806462.47</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110987869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Njombe   </DeptName>
        <Deptcode>1005 </Deptcode>
        <FirstName>Emmanuel                      </FirstName>
        <LastName>George                        </LastName>
        <MiddleName>Deogratius                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Njombe Region                 </VoteName>
        <Votecode>54   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11576145.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111594173</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AMOS                          </FirstName>
        <LastName>MATHIAS                       </LastName>
        <MiddleName>LENGOKO                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3828720.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11997748</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>188250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Planning Division             </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Vonyvaco                      </FirstName>
        <LastName>Luvanda                       </LastName>
        <MiddleName>HEBELI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3239470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8794004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Ales                          </FirstName>
        <LastName>Mahelela                      </LastName>
        <MiddleName>LUGANO                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9485245.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111710447</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MARIAM                        </FirstName>
        <LastName>JILASA                        </LastName>
        <MiddleName>ELIAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7775930.93</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110687528</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CHRISTINA                     </FirstName>
        <LastName>KIANGIO                       </LastName>
        <MiddleName>JOHN                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Municipal Council      </VoteName>
        <Votecode>7205 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8534436.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10228728</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Eliya                         </FirstName>
        <LastName>Malila                        </LastName>
        <MiddleName>MARIO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12576215.37</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10333196</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>182250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Hilda                         </FirstName>
        <LastName>Mushi                         </LastName>
        <MiddleName>HONORATH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha Region                 </VoteName>
        <Votecode>70   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3781667.07</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11281102</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Angela                        </FirstName>
        <LastName>Tarimo                        </LastName>
        <MiddleName>Joseph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9492590.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9500422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Majaliwa                      </FirstName>
        <LastName>Mawazo                        </LastName>
        <MiddleName>COSMAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13381364.01</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9478824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Rukia                         </FirstName>
        <LastName>Kombo                         </LastName>
        <MiddleName>SAIDI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1709316.40</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9730270</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>479250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dentistry                     </DeptName>
        <Deptcode>0018 </Deptcode>
        <FirstName>OMAR                          </FirstName>
        <LastName>MAALIM                        </LastName>
        <MiddleName>HAMZA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Muhimbili Medical Centre      </VoteName>
        <Votecode>TR129</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7378812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111562715</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Benitha                       </FirstName>
        <LastName>Ngimbudzi                     </LastName>
        <MiddleName>Ben                                               </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9711127.56</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9783874</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Gaudencia                     </FirstName>
        <LastName>Wapalila                      </LastName>
        <MiddleName>EPHRAHIM                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9709190.97</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10894286</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Tumaini                       </FirstName>
        <LastName>Mgina                         </LastName>
        <MiddleName>YESSE                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6301320.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8572312</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Justine                       </FirstName>
        <LastName>Lisulile                      </LastName>
        <MiddleName>YIHOSWA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4806120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805332</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CATHERINE                     </FirstName>
        <LastName>PAHALI                        </LastName>
        <MiddleName>FELICIAN                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2925256.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12240421</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DOMINICK                      </FirstName>
        <LastName>MWEMUTSI                      </LastName>
        <MiddleName>BONIFASI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2393282.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12270993</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ALOYCE                        </FirstName>
        <LastName>MURUNGU                       </LastName>
        <MiddleName>ELLY                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6601990.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10661297</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ghati                         </FirstName>
        <LastName>Ryoba                         </LastName>
        <MiddleName>Magoiga                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9305294.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12056454</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Witness                       </FirstName>
        <LastName>Bashaka                       </LastName>
        <MiddleName>JASSON                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2712344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12296177</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MAGDALENA                     </FirstName>
        <LastName>MBOYA                         </LastName>
        <MiddleName>LINDA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13671860.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111741598</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Tabora           </DeptName>
        <Deptcode>2015 </Deptcode>
        <FirstName>TITO                          </FirstName>
        <LastName>MWAKALINGA                    </LastName>
        <MiddleName>AMBANGILE                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9509300.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110972155</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>ABRAHAM                       </FirstName>
        <LastName>MWAKASUNGULA                  </LastName>
        <MiddleName>NEHEMIA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10348898.75</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111589824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ORESTO                        </FirstName>
        <LastName>MLIGO                         </LastName>
        <MiddleName>JOSEPH                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8572822.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10481156</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Patrick                       </FirstName>
        <LastName>Kastomu                       </LastName>
        <MiddleName>nzowa                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9720600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10347494</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>114000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>District Court                </DeptName>
        <Deptcode>2306 </Deptcode>
        <FirstName>Sabato                        </FirstName>
        <LastName>Mwangwa                       </LastName>
        <MiddleName>Mukaka                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
</ArrayOfDeductions>';

	  //$request_string=$this->url.'deductions/getdeductions?month='.$paymentMonth.'&year='.$paymentYear;
        //generating/getting the xml request object/DOM
        //$request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        //return self::getGSSPSoapClient()->__doRequest($request_string, $this->wsdl_url, $this->url, 1);
        return $request_string;
    }

    public function getMonthlyDeductionSummary($paymentMonth, $paymentYear) {

        $request_string = '<ArrayOfDeductionSummary xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/GPP.Models">
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>3593855.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>108750.00</TotalDeductionAmount>
        <VoteName>Tanzania Teachers Commission  </VoteName>
        <Votecode>02   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>22852793.91</TotalActualBalanceAmount>
        <TotalDeductionAmount>354600.00</TotalDeductionAmount>
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>13173142.19</TotalActualBalanceAmount>
        <TotalDeductionAmount>142500.00</TotalDeductionAmount>
        <VoteName>Cooperative Dev. Commision    </VoteName>
        <Votecode>24   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>19970700.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>476100.00</TotalDeductionAmount>
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>1177050.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>145350.00</TotalDeductionAmount>
        <VoteName>Ethics Secretariat            </VoteName>
        <Votecode>33   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>7</NumEmployee>
        <TotalActualBalanceAmount>43025901.02</TotalActualBalanceAmount>
        <TotalDeductionAmount>1300650.00</TotalDeductionAmount>
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>2</NumEmployee>
        <TotalActualBalanceAmount>17662522.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>287700.00</TotalDeductionAmount>
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>24566900.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>331500.00</TotalDeductionAmount>
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>23275811.70</TotalActualBalanceAmount>
        <TotalDeductionAmount>402300.00</TotalDeductionAmount>
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>12</NumEmployee>
        <TotalActualBalanceAmount>104031074.09</TotalActualBalanceAmount>
        <TotalDeductionAmount>2389050.00</TotalDeductionAmount>
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>25801800.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>365250.00</TotalDeductionAmount>
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>4</NumEmployee>
        <TotalActualBalanceAmount>32798424.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>439800.00</TotalDeductionAmount>
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>629100.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>145350.00</TotalDeductionAmount>
        <VoteName>Ministry of Home Affairs      </VoteName>
        <Votecode>51   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>7806462.47</TotalActualBalanceAmount>
        <TotalDeductionAmount>529500.00</TotalDeductionAmount>
        <VoteName>Njombe Region                 </VoteName>
        <Votecode>54   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>29734457.16</TotalActualBalanceAmount>
        <TotalDeductionAmount>362400.00</TotalDeductionAmount>
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>5</NumEmployee>
        <TotalActualBalanceAmount>49487148.53</TotalActualBalanceAmount>
        <TotalDeductionAmount>584250.00</TotalDeductionAmount>
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>11302347.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>225000.00</TotalDeductionAmount>
        <VoteName>Geita Region                  </VoteName>
        <Votecode>63   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>20006937.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>329850.00</TotalDeductionAmount>
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>12576215.37</TotalActualBalanceAmount>
        <TotalDeductionAmount>182250.00</TotalDeductionAmount>
        <VoteName>Arusha Region                 </VoteName>
        <Votecode>70   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>4</NumEmployee>
        <TotalActualBalanceAmount>23309814.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>504750.00</TotalDeductionAmount>
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>4</NumEmployee>
        <TotalActualBalanceAmount>32881062.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>572550.00</TotalDeductionAmount>
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>2149675.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>60150.00</TotalDeductionAmount>
        <VoteName>Coast Region                  </VoteName>
        <Votecode>71   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>68031360.72</TotalActualBalanceAmount>
        <TotalDeductionAmount>634650.00</TotalDeductionAmount>
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>7775930.93</TotalActualBalanceAmount>
        <TotalDeductionAmount>109950.00</TotalDeductionAmount>
        <VoteName>Dodoma Municipal Council      </VoteName>
        <Votecode>7205 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>10</NumEmployee>
        <TotalActualBalanceAmount>82532566.41</TotalActualBalanceAmount>
        <TotalDeductionAmount>1357200.00</TotalDeductionAmount>
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>9</NumEmployee>
        <TotalActualBalanceAmount>58058710.79</TotalActualBalanceAmount>
        <TotalDeductionAmount>1143900.00</TotalDeductionAmount>
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>8038760.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>148950.00</TotalDeductionAmount>
        <VoteName>Singida Region                </VoteName>
        <Votecode>84   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>2</NumEmployee>
        <TotalActualBalanceAmount>23553684.41</TotalActualBalanceAmount>
        <TotalDeductionAmount>754500.00</TotalDeductionAmount>
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>10548850.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>103350.00</TotalDeductionAmount>
        <VoteName>Voluntary Agency Hospitals    </VoteName>
        <Votecode>N0   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>8034750.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>108750.00</TotalDeductionAmount>
        <VoteName>Designated District Hospitals </VoteName>
        <Votecode>N1   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>5517780.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>138150.00</TotalDeductionAmount>
        <VoteName>Weights &amp; Measures Agency     </VoteName>
        <Votecode>S3   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>2402434.05</TotalActualBalanceAmount>
        <TotalDeductionAmount>179700.00</TotalDeductionAmount>
        <VoteName>Tanz. Fisheries Research Inst </VoteName>
        <Votecode>TR07 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>1709316.40</TotalActualBalanceAmount>
        <TotalDeductionAmount>479250.00</TotalDeductionAmount>
        <VoteName>Muhimbili Medical Centre      </VoteName>
        <Votecode>TR129</Votecode>
    </DeductionSummary>
</ArrayOfDeductionSummary>';

        //$request_string=$this->url.'deductions/getdeductionsummary?month='.$paymentMonth.'&year='.$paymentYear;
        //generating/getting the xml request object/DOM
        //$request = $this->generateSoapRequestXMLDOM($request_string);
        //sending the request to the GSSP webs service
        //return $this->getGSSPSoapClient()->__doRequest($request, $this->wsdl_url, $this->url, 1);
        return $request_string;
    }

}
