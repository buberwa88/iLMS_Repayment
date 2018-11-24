<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use app\models\Users;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    //'encodeLabels' => false,
    //'heading' => 'Navigation',vw-students-current-year
    'items' => [

        ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/site/index']), 'active' => (Yii::$app->controller->id == 'site')],
        ['label' => ' My Profile', 'icon' => 'user', 'url' => '#', 'active' => (Yii::$app->controller->id == 'users'),
        ],
        
            ['label' => 'Configurations',
            'icon' => 'wrench',
           // 'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/general-reports/index'),
            'items' => [
                ['label' => 'Requirements', 'url' => Url::to(['/req-general/index']), 'active' => (Yii::$app->controller->id == "req-general" ),
                    //'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/general-reports/index'),
                ],
                ['label' => 'Subject Groups', 'url' => Url::to(['/subjects-categories/index']), 'active' => (yii::$app->controller->id == 'subjects-categories'),
                   // 'visible' => Yii::$app->user->can('/performance-bar-chart/index'),
                ],
           ]
             ],
         ['label' => 'References',
            'icon' => 'oil',
           // 'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/general-reports/index'),
            'items' => [
                ['label' => 'Programmes', 'url' => Url::to(['/programmes/index']), 'active' => (Yii::$app->controller->id == "programmes" ),
                    ],
                ['label' => 'Subjects', 'url' => Url::to(['/subjects/index']), 'active' => (Yii::$app->controller->id == "subjects" ),
                    //'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/general-reports/index'),
                ],
                ['label' => 'Grades', 'url' => '#', 'active' => (yii::$app->controller->id == 'performance-bar-chart'),
                   // 'visible' => Yii::$app->user->can('/performance-bar-chart/index'),
                ],
           ]
             ],
        ['label' => 'Logout', 'icon' => 'off', 'url' => Url::to(['/site/logout'])],
    ],
]);





