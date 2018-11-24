<?php

/**
 * @var $content string
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);
//find the status of account number
$total=0;
 $modeldata= \backend\modules\application\models\Application::find()->where(['bank_account_number' =>NULL])->count();

 //check registration number
  $modelregion= \backend\modules\application\models\Application::find()->where(['registration_number' =>NULL])->count();
 //end
//end 
  $total=$modeldata+$modelregion;
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
                                            <?= Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname; ?>
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
                        ["label" => "Dashboard", "url" => Url::to(['/disbursement/default/index']), 'active' => (Yii::$app->controller->id =='default'&&Yii::$app->controller->action->id =='index'), "icon" => "dashboard",'visible' =>yii::$app->user->can('/disbursement/default/index')],
                       
                        [
                            "label" => "Operations",
                            "icon" => "th",
                            "url" => "#",
                            "items" => [
                                //["label" => "Loanee", "url" => Url::to(['/disbursement/default/applicant-profile']), 'active' => (Yii::$app->controller->id == 'default'&&Yii::$app->controller->action->id == 'applicant-profile'||Yii::$app->controller->id == 'default'&&Yii::$app->controller->action->id == 'viewprofile'),'visible' =>yii::$app->user->can('/allocation/student-exam-result/index')],
                                ["label" => "Allocation Batch", "url" => Url::to(['/disbursement/default/allocation-batch']), 'active' => (Yii::$app->controller->id == 'default'&&Yii::$app->controller->action->id == 'viewbatch'||Yii::$app->controller->id == 'default'&&Yii::$app->controller->action->id == 'allocation-batch'),'visible' =>yii::$app->user->can('/allocation/student-exam-result/index')],
                                //["label" => "Institution Payment Request ", "url" => ["#"]],
                                ["label" => "Disbursement", "url" => Url::to(['/disbursement/disbursement-batch']), 'active' => (Yii::$app->controller->id == 'disbursement-batch'&&Yii::$app->controller->action->id == 'index'||Yii::$app->controller->id == 'disbursement-batch'&&Yii::$app->controller->action->id == 'view'||Yii::$app->controller->id == 'disbursement-batch'&&Yii::$app->controller->action->id == 'create'||Yii::$app->controller->id == 'disbursement-batch'&&Yii::$app->controller->action->id == 'update')],
                                //["label" => "Review Disbursement [SDO]", "url" => Url::to(['/disbursement/disbursement-batch/review-disbursement']), 'active' => (Yii::$app->controller->action->id == 'review-disbursement'||Yii::$app->controller->action->id == 'viewreviewb'),'visible' =>yii::$app->user->can('/disbursement/disbursement-batch/review-disbursement')],
                                ["label" => "Review Disbursement ", "url" => Url::to(['/disbursement/disbursement-batch/reviewall-disbursement']), 'active' =>Yii::$app->controller->action->id == 'reviewall-disbursement'||(Yii::$app->controller->action->id == 'viewreviewall'||Yii::$app->controller->action->id == 'review-decision'),'visible' =>yii::$app->user->can('/disbursement/disbursement-batch/reviewall-disbursement')],
                                ["label" => "Make Payment [Accountant]", "url" => Url::to(['/disbursement/disbursement-batch/disbursement-payment']), 'active' => (Yii::$app->controller->action->id == 'disbursement-payment'),'visible' =>yii::$app->user->can('/disbursement/disbursement-batch/disbursement-payment')],
                                ],
                        ],
                        [
                            "label" => "Configurations",
                            "icon" => "gears",
                            "url" => "#",
                            "items" => [
                                ["label" => "Instalment", "url" => Url::to(['/disbursement/instalment-definition/index']), 'active' => (Yii::$app->controller->id == 'instalment-definition'),'visible' =>yii::$app->user->can('/disbursement/instalment-definition/index')],
                                ["label" => "Disbursement ", "url" => Url::to(['/disbursement/disbursement-setting/index']), 'active' => (Yii::$app->controller->id == 'disbursement-setting'),'visible' =>yii::$app->user->can('/disbursement/disbursement-setting/index')],
                                ["label" => "Loan Items Associate", "url" => Url::to(['/disbursement/disbursement-dependent/index']), 'active' => (Yii::$app->controller->id == 'disbursement-dependent'),'visible' =>yii::$app->user->can('/disbursement/disbursement-dependent/index')],
                                ["label" => "Disbursement Task", "url" => Url::to(['/disbursement/disbursement-task/index']), 'active' => (Yii::$app->controller->id == 'disbursement-task'),'visible' =>yii::$app->user->can('/disbursement/disbursement-task/index')],    
                                ["label" => "Disbursement Structure", "url" => Url::to(['/disbursement/disbursement-structure/index']), 'active' => (Yii::$app->controller->id == 'disbursement-structure'),'visible' =>yii::$app->user->can('/disbursement/disbursement-structure/index')],
                                ["label" => "Disbursement User Task", "url" => Url::to(['/disbursement/disbursement-user-task/index']), 'active' => (Yii::$app->controller->id == 'disbursement-user-task'),'visible' =>yii::$app->user->can('/disbursement/disbursement-user-task/index')],
                                ["label" => "Disbursement Approval Limit", "url" => Url::to(['/disbursement/disbursement-schedule/index']), 'active' => (Yii::$app->controller->id == 'disbursement-schedule'),'visible' =>yii::$app->user->can('/disbursement/disbursement-schedule/index')],
                                ],
                       ],
                       ["label" => "Notifications <i class='fa fa-bell-o'></i>
                            <span class='label label-warning'>$total</span> ", "url" => Url::to(['/disbursement/default/notification']), 'active' => (Yii::$app->controller->id =='default'&&Yii::$app->controller->action->id =='notification'), "icon" => "fa fa-bell-o",'visible' =>yii::$app->user->can('/disbursement/default/notification')],
                        
                       
                        ["label" => "Report", "url" => ["#"], "icon" => "fa fa-bar-chart"],
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
