<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
	
		'user' => [
            'class' => '\common\components\Controller',
            'identityClass' => 'common\models\User',
			//'enableSession' => false,
			//'enableAutoLogin' => false,
            //'enableAutoLogin' => true,
        ],
		
		'session' => [ // for use session in console application
            'class' => 'yii\web\Session'
        ],
		'urlManager' => [
        'class' => 'yii\web\UrlManager',
        'scriptUrl' => 'http://localhost/ilms_repayment/index.php',
]
    ],
	
    'params' => $params,
];
