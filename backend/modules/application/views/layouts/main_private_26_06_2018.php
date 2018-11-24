<?php

/**
 * @var $content string
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);
//find the status of account number

?>
 
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">iLMS</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>iLMS</b></span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="http://placehold.it/160x160" class="user-image" alt="">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs"><?= Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="http://placehold.it/160x160" class="img-circle" alt="">
                                        <p>
                                            <?=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname; ?>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <?=
                                            Html::a(
                                                    'Sign out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                            )
                                            ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                   <?=
            \yiister\adminlte\widgets\Menu::widget(
                [
                    "items" => [
                        ["label" => "Dashboard", "url" => Url::to(['/application/default/index']), 'active' => (Yii::$app->controller->id =='default'&&Yii::$app->controller->action->id =='index'), "icon" => "dashboard",'visible' =>yii::$app->user->can('/application/default/index')],
                        //["label" =>"My Profile" , "url" => Url::to(['/disbursement/default/index']), 'active' => (Yii::$app->controller->id =='default'&&Yii::$app->controller->action->id =='index'), "icon" =>"user",'visible' =>yii::$app->user->can('/disbursement/default/index')],
                        [
                            "label" => "Operations",
                            'visible' =>yii::$app->user->can('/application/*'),
                            "icon" => "th",
                            "url" => "#",
                            "items" => [
                                ["label" =>"Manage Applications", "url" => Url::to(['/application/application/index']), 'active' => (Yii::$app->controller->id == 'application'),'visible' =>yii::$app->user->can('/application/application/index')],
                                ["label" =>"Manage Applicants", "url" => Url::to(['/application/user/index']), 'active' => (Yii::$app->controller->id == 'user'),'visible' =>yii::$app->user->can('/application/user/index')],
                                ["label" =>" Manage Application Cycle", "url" => Url::to(['/application/application-cycle/index']),'visible' =>yii::$app->user->can('/application-cycle/index'), 'active' => (Yii::$app->controller->id == 'application-cycle')],
                                ["label" => "Bills", "url" => Url::to(['/application/gepg-bill/index']),'visible' =>yii::$app->user->can('/application/gepg-bill/index'),  'active' => (Yii::$app->controller->id =='gepg-bill'), "icon" => "money"],
                                ["label" => "Fee Payment Reconciliation", "url" => Url::to(['/application/gepg-recon-master/index']),'visible' =>yii::$app->user->can('/application/gepg-recon-master/index'), 'active' => (Yii::$app->controller->id =='gepg-recon-master'), "icon" => "money"],
                                ["label" => "Application Fee Payments", "url" => Url::to(['/application/gepg-receipt/index']),'visible' =>yii::$app->user->can('/application/gepg-receipt/index'), 'active' => (Yii::$app->controller->id =='gepg-receipt' && Yii::$app->controller->action->id !='upload-payments'), "icon" => "money"],

                               ],
                        ],


//here import GePG
							[
				"label" => "Import",
				"icon" => "gear",
				"url" => "#",
                            "items" => [
                                ["label" => "Control Numbers", "url" => Url::to(['/application/gepg-cnumber/upload-controll-number']), 'active' => (Yii::$app->controller->id == 'gepg-cnumber'&&Yii::$app->controller->action->id=='upload-controll-number')],
                                ["label" => "Payments", "url" => Url::to(['/application/gepg-receipt/upload-payments']), 'active' => (Yii::$app->controller->id == 'gepg-receipt'&&Yii::$app->controller->action->id == 'upload-payments')],
                                ["label" => "Reconciliation", "url" => Url::to(['/application/gepg-payment-reconciliation/upload-payment-recon']), 'active' => (Yii::$app->controller->id == 'gepg-payment-reconciliation')],
                                ],
                        ],
							
                        [
                            "label" => "Verification",
                            'visible' =>yii::$app->user->can('/application/application/index'),
                            "icon" => "gears",
                            "url" => "#",
                            "items" => [
                                         ['label' => 'Unverified','url' =>['/application/application/unverified-applications'], 'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'unverified-applications'),'visible' =>yii::$app->user->can('/application/application/index')], 
                                         ['label' => 'Pending','url' =>['/application/application/pending-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'pending-applications'),'visible' =>yii::$app->user->can('/application/application/index')],                                         
                                        //['label' => 'Incomplete','url' =>['/application/application/incomplete-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'incomplete-applications'),'visible' =>yii::$app->user->can('/application/application/index')], 
                                         ['label' => 'Waiting','url' =>['/application/application/waiting-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'waiting-applications'),'visible' =>yii::$app->user->can('/application/application/index')],
                                        //['label' => 'Invalid','url' =>['/application/application/waiting-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'waiting-applications'),'visible' =>yii::$app->user->can('/application/application/index')],
                                       
                                         ['label' => 'Invalid','url' =>['/application/application/invalid-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'invalid-applications'),'visible' =>yii::$app->user->can('/application/application/invalid-applications')],

                                         ['label' => 'Incomplete','url' =>['/application/application/incompleted-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'incompleted-applications'),'visible' =>yii::$app->user->can('/application/application/incompleted-applications')],

                                         ['label' => 'Complete','url' =>['/application/application/complete-applications'], 'active' => (Yii::$app->controller->id == 'application'  && Yii::$app->controller->action->id == 'complete-applications'),'visible' =>yii::$app->user->can('/application/application/index')],
                                         //['label' => 'Verification Items','url' =>['/application/attachment-definition'], 'active' => (Yii::$app->controller->id == 'attachment-definition' && Yii::$app->controller->action->id == 'index'),'visible' =>yii::$app->user->can('/application/application/index')],
                                         //['label' => 'Verification Assignment','url' =>['/application/application/assign-verification'], 'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'assign-verification'),'visible' =>yii::$app->user->can('/application/application/assign-verification')],

                                          ['label' => 'Assignment','url' =>['/application/verification-assignment'], 'active' => (Yii::$app->controller->id == 'verification-assignment' && Yii::$app->controller->action->id != 'index-verification-assigned'),'visible' =>yii::$app->user->can('/application/verification-assignment/index')],
                                         //['label' => 'Assigned Applications','url' =>['/application/application/index-verification-assigned'], 'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'index-verification-assigned'),'visible' =>yii::$app->user->can('/application/application/index-verification-assigned')],                                        


                                         ['label' => 'Manage Framework','url' =>['/application/verification-framework'], 'active' => (Yii::$app->controller->id == 'verification-framework'),'visible' =>yii::$app->user->can('/application/verification-framework/index')],
                                        ],
                        ],

                        [
                            "label" => "Configurations",
                            'visible' =>yii::$app->user->can('/application/question/index'),
                            "icon" => "gears",
                            "url" => "#",
                            "items" => [
                                     ['label' => 'Define Questions','url' =>['/application/question/index'], 'active' => (Yii::$app->controller->id == 'question'),'visible' =>yii::$app->user->can('/application/question/index')],
                                     ['label' => 'Define Qn. Triggers','url' =>['/application/qtrigger-main/index'], 'active' => (Yii::$app->controller->id == 'qtrigger-main'),'visible' =>yii::$app->user->can('/application/qtrigger-main/index')],
                                     ['label' => 'Response List','url' =>['/application/qresponse-list/index'], 'active' => (Yii::$app->controller->id == 'qresponse-list'),'visible' =>yii::$app->user->can('/application/qresponse-list/index')],
                                     //['label' => 'Response Source','url' =>['/application/qresponse-source/index'], 'active' => (Yii::$app->controller->id == 'default'),'visible' =>yii::$app->user->can('/application/student-exam-result/index')], 
                                ],
                        ],                   
                       
                      //  ["label" => "Report", "url" => ["#"], "icon" => "fa fa-bar-chart"],
                    ],
                    'encodeLabels' => false,
                ]
                    
            )
            ?>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                   
                    <?php if (isset($this->params['breadcrumbs'])): ?>
                        <?=
                        \yii\widgets\Breadcrumbs::widget(
                                [
                                    'encodeLabels' => false,
                                    'homeLink' => [
                                        'label' => new \rmrevin\yii\fontawesome\component\Icon('home') . ' Home',
                                        'url' => ["index"],
                                    ],
                                    'links' => $this->params['breadcrumbs'],
                                ]
                        )
                        ?>
<?php endif; ?>
                </section>
                <section class="content">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                    <?php
                    yii\bootstrap\Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-medium',
                        //keeps from closing modal with esc key or by clicking out of the modal.
                        // user must click cancel or X to close
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
                    ]);
                    echo "<div id='modalContent'></div>";
                    yii\bootstrap\Modal::end();
                    ?>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Higher Education Students' Loans Board(HESLB) &copy; <?= date("Y") == "2005" ? "2005" : "2005 - " . date("Y") ?></strong>
                <a class="pull-right hidden-xs" href="http://ucc.co.tz">Powered by UCC</a>
            </footer>
        </div><!-- ./wrapper -->
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
 

