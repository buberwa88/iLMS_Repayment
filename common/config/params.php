<?php

return [
    'necta_url' => 'http://localhost/necta_api/pub/results.php/necta',
    'GSPP' => [
        'api_base_uri' => 'http://192.168.5.194/gsppApipilot/api/',
        'api_base_uri_contrln' => 'http://192.168.5.194/GsppApiPilot/Api/',
        'auth_username' => 'HESLB',
        'auth_password' => 'User@Heslb123',
    ],
    ///GePG configurations
    'GePG' => [
        'server_ip' => "http://154.118.230.202",
        'sp_code' => 'SP111',
        'sp_subcode' => '7001',
        'sp_id' => 'LHESLB001',
        'sp_code' => '140313',
        'auth_certificate' => "/var/www/html/olams/frontend/web/sign/heslbolams.pfx", // gepg certificate
        'auth_certificate_pswd' => 'heslbolams',
        'auth_type' => 'cert', //GEPG authentication type
        'gepg_private_key' => "/var/www/html/olams/frontend/web/sign/gepgclientprivatekey.pfx",
        'cert_signature_algorithm' => 'sha1WithRSAEncryption',
//        'auth_username'=>'',
//        'auth_password'=>'',
        ///bill post details
        'send_bill_url' => "http://154.118.230.202/api/bill/sigqrequest",
        'send_reconciliations_url' => "http://154.118.230.202/api/reconciliations/sig_sp_qrequest",
        'cancel_bill_url' => "http://154.118.230.202/api/bill/sigcancel_request",
        'bill_expire_date' => "90", ///number of days the bill will exipire
    ////bill recon details
    ],
    ///RABBITMQ CONFIGURATIONS
    'RabbitMQ' => [
        'server_ip' => '41.59.225.155',
        'server_port' => '5672',
        'username' => 'admin',
        'password' => 'admin'
    ],
];
