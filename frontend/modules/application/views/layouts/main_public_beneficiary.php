<?php

/**
 * @var $content string
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use common\widgets\Alert;
yiister\adminlte\assets\Asset::register($this);
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployerSearch;
?>
<?php $this->beginPage() ?>
<?php 
$countAllocation=0;
$user_id = Yii::$app->user->identity->user_id;
$modelApplicant = \frontend\modules\application\models\Applicant::find()->where("user_id = {$user_id}")->one();
$existAllocation=\frontend\modules\application\models\Application::checkExistAllocation($modelApplicant->applicant_id);
$existDisbursement=\frontend\modules\application\models\Application::checkExistDisbursment($modelApplicant->applicant_id);



        $loggedin=Yii::$app->user->identity->user_id;
        $applicant=EmployerSearch::getApplicant($loggedin);
        $applicantID=$applicant->applicant_id;
        
        //check loged in employer
        $employerStatus= \frontend\modules\repayment\models\Employer::find()
        ->where(['user_id'=>$loggedin,'salary_source'=>1])->orderBy(['employer_id'=>SORT_DESC])->count();
        if($employerStatus ==0){
            $label="Pay Bill";$label="Pay Bill";
        }else{           
           $label="Prepare & Send Bill";
        }
        //end check

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of lal links and provides the needed markup only.
-->
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
    <style>
        .kv-file-remove{
        display: none;
        //text-align: center;
    }
 .navbar-right {
    float: right !important;
    margin-right: 250px!important;
}
        </style>
</head>
<!--
BODY TAG OPTIONS: #365C77 
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>i</b>LMS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>iLMS</b></span>
        </a>
                      <?php
            NavBar::begin([
                
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                     ['label' => 'My Application', 'icon' => 'list-alt', 'url' => Url::to(['/application/default/my-application-index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'my-application-index')|| Yii::$app->controller->id == 'education'|| Yii::$app->controller->id=="applicant-associate"|| Yii::$app->controller->id=="application"||Yii::$app->controller->id=='applicant'],
                     ['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/site/change-password'],'active' => (Yii::$app->controller->id == 'site')],
                                
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => "Logout ",
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
       
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
       
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

               <!-- Sidebar user panel (optional) -->
            <div class="user-pan1el">
                   <center>
                <div class="pull-center image">
                    <img src="image/logo/heslb_logo.gif" class="img-circle" alt="logo">
                </div>
           
   
                        <!--                <h4 class='hdheading page-header'>Deadline</h4>
                                        <p>Applications will be closed 04 August 2017 23:59hours</p>-->
                                    </center>
            </div>
              
            <?=
            \yiister\adminlte\widgets\Menu::widget(
                [
                    "items" => [
                         ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/application/default/index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index')],
                              
                        ['label' => 'Application', 'icon' => 'list-alt', 'url' => Url::to(['/application/default/my-application-index']), 'active' => ((Yii::$app->controller->id == 'default' || Yii::$app->controller->id == 'education' || Yii::$app->controller->id=="applicant-associate" || Yii::$app->controller->id=="application" || Yii::$app->controller->id=='applicant') && (Yii::$app->controller->action->id == 'my-application-index' || Yii::$app->controller->action->id == 'application-list' || Yii::$app->controller->action->id == 'new-application' || Yii::$app->controller->action->id != 'allocated-loan' || Yii::$app->controller->action->id == 'my-profile' || Yii::$app->controller->action->id == 'updateprofile') && Yii::$app->controller->action->id != 'index' && Yii::$app->controller->action->id != 'disbursed-loan' && Yii::$app->controller->action->id != 'notification')],
                        ['label' => 'Allocation', 'icon' => 'dashboard', 'url' => ['/application/application/allocated-loan'],'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'allocated-loan'),'visible' =>$existAllocation =='1'],
                        ['label' => 'Disbursment', 'icon' => 'dashboard', 'url' => ['/application/application/disbursed-loan'],'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'disbursed-loan'),'visible' =>$existDisbursement=='1'],
                        ['label' => 'Repayment', 'icon' => 'dashboard', 'url' => ['/appeal/appeal/index'],'active' => (Yii::$app->controller->id == 'appeal'),'visible' =>$countAllocation=='23'],
						[
									"label" => "Repayment",
									"icon" => "th",
									"url" => "#",
								"items" => [								
								    ["label" => "My Loan", "url" => Url::to(['/repayment/loan-beneficiary/viewloan-statement-beneficiary']), 'active' => (Yii::$app->controller->id =='loan-beneficiary'&&Yii::$app->controller->action->id=='viewloan-statement-beneficiary'), "icon" => "money"],
                                    //["label" => "Loan Summary", "url" => Url::to(['/repayment/loan-summary/index-beneficiary']), 'active' => (Yii::$app->controller->id =='loan-summary'&&Yii::$app->controller->action->id=='index-beneficiary'), "icon" => "money"],
                                    ["label" =>$label, "url" => Url::to(['/repayment/loan-repayment/index-beneficiary']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&Yii::$app->controller->action->id=='index-beneficiary'), "icon" => "th"],
                                    ["label" => "Payments", "url" => Url::to(['/repayment/loan-repayment-detail/bills-payments-benefiaciary']), 'active' => (Yii::$app->controller->id =='loan-repayment-detail'), "icon" => "th"],
				    ["label" => "Receipts", "url" => Url::to(['/repayment/loan-repayment/receipt']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&Yii::$app->controller->action->id=='receipt'), "icon" => "money"],
					],
					],
                                ['label' => 'Appeal', 'icon' => 'balance-scale', 'url' => ['/appeal/appeal/index'],'active' => (Yii::$app->controller->id == 'appeal'),'visible' =>$countAllocation=='23'],
                                ['label' => 'Complaints', 'icon' => 'comments', 'url' => ['/appeal/complaints/index'],'active' => (Yii::$app->controller->id == 'complaints'),'visible' =>$countAllocation=='23'],
                        ['label' => 'Notifications', 'icon' => 'far fa-bell', 'url' => ['/application/application/notification'],'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'notification'),'visible' =>$countAllocation=='23'],
                                ['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/site/change-password'],'active' => (Yii::$app->controller->id == 'site'),'visible' =>$countAllocation=='0'],
                                   
                            ],
                    ]
                
            )
            ?>
           <ul class="sidebar-menu"><li>
            <?= Html::a(
                                                    '<i class="fa  fa-power-off"></i>Logout',
                                                    ['/site/logout'],
                                                    ['data-method' => 'post']
                                                ) ?>
               </li>
           </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
         
            <?php if (isset($this->params['breadcrumbs'])): ?>
                <?=
                \yii\widgets\Breadcrumbs::widget(
                    [
                        'encodeLabels' => false,
                        'homeLink' => [
                            'label' => new \rmrevin\yii\fontawesome\component\Icon('home') . ' Home',
                            'url' => ["/application/default/index"],
                        ],
                        'links' => $this->params['breadcrumbs'],
                    ]
                )
                ?>
            <?php endif; ?>
        </section>

        <!-- Main content -->
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

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
         
        </div>
        <!-- Default to the left -->
         
    </footer>

   
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
