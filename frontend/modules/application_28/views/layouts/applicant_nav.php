<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use app\models\Users;

   echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'encodeLabels' => false,
                            'items' => [
                                
                                ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/notifications/index']), 'active' => (Yii::$app->controller->id == 'notifications' && Yii::$app->controller->action->id == 'index')],
                                ['label' => 'Selection Results', 'icon' => 'star-empty', 'url' => Url::to(['/applicants/selection-results']), 'active' => (Yii::$app->controller->id == 'applicants' && Yii::$app->controller->action->id == 'selection-results'),'visible'=> \app\models\Applicants::ResultsPublished()],
                                ['label' => 'My Application', 'icon' => 'list-alt', 'url' => Url::to(['/site/my-application']), 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'my-application')],
                                //['label' => 'Application Status', 'icon' => 'dashboard', 'url' => ['/applicants/application-status'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'application-status')],
                                //['label' => 'My Contact Details', 'icon' => 'envelope', 'url' => ['/applicants/contact-details'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'contact-details')],
                                //['label' => 'Notifications <span class="badge">0</span>', 'icon' => 'star-empty', 'url' => ['/applicants/notifications'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'notifications')],
                                ['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/applicants/change-password'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'change-password')],
                                ['label' => 'Logout', 'icon' => 'off', 'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']],       
                            ],
                        ]);