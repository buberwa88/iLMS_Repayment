<?php

/**
 * @var $content string
 */

use yii\helpers\Html;
use common\widgets\Alert;
yiister\adminlte\assets\Asset::register($this);
$style='style="font-size: 15px; font-family: Helvetica;"';

?>
  <style>
    .main-sidebar, .left-side,.logo{
    
    //width: 165px !important;
     
    }
    .main-header .navbar {
    -webkit-transition: margin-left .3s ease-in-out;
    -o-transition: margin-left .3s ease-in-out;
    transition: margin-left .3s ease-in-out;
    margin-bottom: 0;
    //margin-left: 165px;
    border: none;
    min-height: 50px;
    border-radius: 0;
}
 .blink_text {

    animation:1s blinker linear infinite;
    -webkit-animation:1s blinker linear infinite;
    -moz-animation:1s blinker linear infinite;

     color: red;
    }

    @-moz-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @-webkit-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }
 </style>
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
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>iLMS</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top visible-phone" role="navigation" >
            <!-- Sidebar toggle button
           <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  
                 
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                     
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" >

            <!-- Sidebar user panel (optional) -->
            <div class="user-pan1el">
                   <center>
                <div class="pull-center image">
                    <img src="image/logo/heslb_logo.gif" class="img-circle" alt="logo">
                </div>
           
   <h4 class="hdheading page-header">Helpdesk</h4>
    <p <?php echo $style; ?>><strong>Hotline Numbers</strong><br/>
   +255 22 550 7910<br/>0739665533</p>
<p <?php echo $style; ?>><strong>Application Desk</strong><br/>
<a href="mailto:helpdesk@heslb.go.tz">helpdesk@heslb.go.tz</a></p>
<p <?php echo $style; ?>><strong>General Contacts</strong><br/>
 +255 22 277 2432/33<br/>
<a href="mailto:info@heslb.go.tz">info@heslb.go.tz</a></p>
<p <?php echo $style; ?>><strong>Repayment Desk</strong><br/>
<a href="mailto:repayment@heslb.go.tz">repayment@heslb.go.tz</a></p>
<!--
<p <?php echo $style; ?>><span class="blink_text"><strong>SOMA MASWALI NA MAJIBU
    KABLA HUJAPIGA SIMU</strong></span><br/>
    <a style='color:red !important' target="_blank" href="maswali_ya_mara_kwa_mara.pdf">PAKUA HAPA</a></p>

                                        <h4 class='hdheading page-header'>Deadline</h4>
                                        <p>Applications will be closed 04 August 2017 23:59hours</p>-->
                                    </center>
            </div>
 
       
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
                            'url' => ["/application/default/home-page"],
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

            </div><!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane1" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                            Some information about this general settings option
                        </p>
                    </div><!-- /.form-group -->
                </form>
            </div><!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->
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
<?php $this->endPage()?>

<script>
$(document).ready(function () {

//	informWebsiteUnderConstruction();

});

function informWebsiteUnderConstruction() {

	var $bgShade = $('<div id="divBgShade" style="position:fixed;top:0px;bottom:0px;left:0px;right:0px;margin:auto;background:#000;z-index:100000;">');

	var $pageCover = $('<div id="divPageCover" style="position:absolute;top:30px;bottom:30px;left:30px;right:30px;margin:auto;background:#FFF;z-index:100000;">');

	var html = '<div id="divMsgW" style="text-align:center;margin-top:100px;padding:10px;">';

	html += '<h1 style="font-weight:bold;">OLAS Is Under Construction</h1>';

	html += '<h3 style="font-weight:bold;color:red;">You are not advised to continue.</h3>';

	html += '<h3 style="font-weight:bold;color:#069;">Please visit again after sometime to check the status.</h3>';

	html += '<h3 style="padding:10px 0px;font-weight:bold;text-decoration:underline;"><a href="http://heslb.go.tz">Alternatively, you can go to our website here: www.heslb.go.tz</a></h3>';

	html += '</div>';

	html += '<a href="javascript:void 0;" style="position:absolute;right:10;top:10px;font-weight:bold;font-size:10px;color:#CCC;">XClose</a>';

	$pageCover.html(html);



	$bgShade.css({ opacity: "0.4" });

	$pageCover.css({ borderRadius: "10px" });



	$bgShade.appendTo("body");

	$pageCover.appendTo("body");



	var TABKeyCode = 9, ESCKeyCode = 27;

	var $a = $pageCover.find("a").dblclick(function () {

		$("#divPageCover").remove();

		$("#divBgShade").remove();

	}).keydown(function (e) {

		if (e.keyCode === TABKeyCode) {

			return false;

		} else if (e.keyCode === ESCKeyCode) {

			$("#divPageCover").remove();

			$("#divBgShade").remove();

			return false;

		}

	});

	setTimeout(function () { $a.focus(); }, 10);

}
</script>