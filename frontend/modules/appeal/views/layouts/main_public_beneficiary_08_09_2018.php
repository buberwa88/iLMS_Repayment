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
?>
<?php $this->beginPage() ?>
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
            <div class="navbar-custom-menu">
      
                <ul class="nav navbar-nav">
                  
                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="http://placehold.it/160x160" class="user-image" alt="">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?= Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;?></span>
                        </a>
                    
                    </li>
                    
                </ul>
            </div>
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
           <!--                     <h4 class='hdheading page-header'>Deadline</h4>
                                        <p>Applications will be closed 04 August 2017 23:59hours</p>  -->
                                    </center>
            </div>
              
            <?=
            \yiister\adminlte\widgets\Menu::widget(
                [
                    "items" => [
                         ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/application/default/index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index')],
                              
                                ['label' => 'My Application', 'icon' => 'list-alt', 'url' => Url::to(['/application/default/my-application-index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'my-application-index')|| Yii::$app->controller->id == 'education'|| Yii::$app->controller->id=="applicant-associate"|| Yii::$app->controller->id=="application"||Yii::$app->controller->id=='applicant'],
                                ['label' => 'Appeal', 'icon' => 'balance-scale', 'url' => ['/appeal/appeal/index'],'active' => (Yii::$app->controller->id == 'appeal')],
                                ['label' => 'Complaints', 'icon' => 'comments', 'url' => ['/appeal/complaints/index'],'active' => (Yii::$app->controller->id == 'complaints')],
                                ['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/site/change-password'],'active' => (Yii::$app->controller->id == 'site')],
                                   
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
</div>
<!-- ./wrapper -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
