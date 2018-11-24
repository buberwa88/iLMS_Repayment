<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
        require(__DIR__ . '/allocation-baseline.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
           
        ],
     'gridview' => [
      'class' => '\kartik\grid\Module',
      ],
     'application' => [
            'class' => 'frontend\modules\application\Module', 'class' => 'backend\modules\application\Module',
        ],
      'allocation' => [
            'class' => 'frontend\modules\allocation\Module',  'class' => 'backend\modules\allocation\Module',
        ],
        'disbursement' => [
            'class' => 'frontend\modules\disbursement\Module','class' => 'backend\modules\disbursement\Module',
        ],
       'repayment' => [
            'class' => 'frontend\modules\repayment\Module', 'class' => 'backend\modules\repayment\Module',
        ],
       'complaint' => [
            'class' => 'backend\modules\complaint\Module',
        ],
         'appleal' => [
            'class' => 'backend\modules\appeal\Module',
        ],
		'report' => [
            'class' => 'backend\modules\report\Module',
        ],
        'helpDesk' => [
            'class' => 'backend\modules\helpDesk\Module',
        ],
    ],
    'components' => [
          'user' => [
        'identityClass' => 'common\models\User',
        'enableAutoLogin' => FALSE,
        'identityCookie' => [
            'name' => '_backendUser', // unique for frontend
            //'path'=>'/advanced/frontend'  // correct path for the frontend app.
        ]
        ],
        'session' => [
            'name' => 'BACKENDSESSID',
            'savePath' => sys_get_temp_dir(),  //__DIR__ . '/../tmp',
        ],
       'controller' => [
            'class' => 'common\components\controller',
           
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
