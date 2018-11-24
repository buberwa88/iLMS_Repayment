<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
         'modules' => [
      
     'application' => [
            'class' => 'frontend\modules\application\Module',
        ],
      'allocation' => [
            'class' => 'frontend\modules\allocation\Module'
        ],
        'disbursement' => [
            'class' => 'frontend\modules\disbursement\Module'
        ],
       'repayment' => [
            'class' => 'frontend\modules\repayment\Module',
        ],
       'complaint' => [
            'class' => 'frontend\modules\complaint\Module',
        ],
         'appeal' => [
            'class' => 'frontend\modules\appeal\Module',
        ],
    ],
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
                'user' => [
        'identityClass' => 'common\models\User',
        'enableAutoLogin' =>false,
        'identityCookie' => [
            'name' => '_frontendUser', // unique for frontend
            //'path'=>'/advanced/frontend'  // correct path for the frontend app.
        ]
    ],
    'session' => [
        'name' => 'PHPFRONTSESSID',
        'savePath' => sys_get_temp_dir(),  //__DIR__ . '/../tmp',
    ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
