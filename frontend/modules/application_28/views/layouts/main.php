<style>
    .hdheading{
        color: #1a6da3;

    }
    
    
</style>

<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use app\models\Users;
use kartik\tabs\TabsX;


  echo '<!--';
   echo TabsX::widget([
    'items' => [
        [
           'label'=>'M',
           'content'=>'',
           'id'=>'temp_tabs_id_for_just_triggering_menu_appear',
        ],
         
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);  
   echo '-->';
   


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title ><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <?php $this->beginBody() ?>
        <!DOCTYPE html>
    <link href="themes/freelancer/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/dashboard.css" rel="stylesheet">
    <script src="js/ie-emulation-modes-warning.js"></script>

    <style>
        .my-navbar {
            background-color: transparent;
            height: 95px;
            background-image: url("http://localhost:8080/heslb/frontend/web/images/banner.png")
        }
        .sidebar{
            top: 100px;
        }
        
        .breadcrumb{
            margin-top: 29.8px;
            margin-left: -50px;
        }
        
        #nav-sidebar-id{
            padding-top: 16px;
        }
        
    </style>
    <nav class="navbar my-navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>

                </button>
                <!--<?php //echo Html::img("img/header.png") ?>--> 
<!--                <a class="navbar-brand" href="<?php echo Yii::$app->homeUrl; ?>">Admission</a>-->
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">

                    <!--                    <li><a href="#">My Profile</a></li>-->
<!--                    <li><a href=" <?= Url::to(['/site/help']) ?> ">Help</a></li>-->
                    <?php
                    /*
                    if (Yii::$app->user->isGuest) {
                        echo '<li><a href="' . Url::to(['/site/login', 'activeTab' => 'login_tab_id']) . '">Login</a></li>';
                    } else {
                      

                   
                    echo '<li><a href="' . Url::to(['/notifications/index']) . '">Home</a></li>';
                      

                      echo '<li><a href="' . Url::to(['/site/logout']) . '">Logout</a></li>';
                    }
                     * 
                     */
                    ?>
                </ul>

            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar" id="side-nav-div-id">
                <ul class="nav nav-sidebar" id="nav-sidebar-id">
                    
                    <?php
//                    echo '<center>' . Html::img('', ['align' => 'center', 'width' => '200px', 'height' => '200px']) . '</center>';
                    if (Yii::$app->user->isGuest) {

//                        
//                        echo SideNav::widget([
//                            'type' => SideNav::TYPE_DEFAULT,
//                            'encodeLabels' => false,
//                            'items' => [
//                                
//                                ['label' => 'Home', 'icon' => 'home', 'url' => ['/site/index']],
//                                ['label' => 'Loan Application', 'icon' => 'star-empty', 'url' => ['/site/applicant-index']],
//                                ['label' => 'Repayment', 'icon' => 'list-alt', 'url' => '#' ],
//                                ['label' => 'Learning Institutions', 'icon' => 'envelope', 'url' =>'#'],
//                                ['label' => 'TCU', 'icon' => 'dashboard', 'url' =>'#'],
//                                
//                         
//                            ],
//                        ]);
                        
                    }  else {
                         echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'encodeLabels' => false,
                            'items' => [
                                
                                ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/notifications/index']), 'active' => (Yii::$app->controller->id == 'notifications' && Yii::$app->controller->action->id == 'index')],
                                ['label' => 'Selection Results', 'icon' => 'star-empty', 'url' => Url::to(['/applicants/selection-results']), 'active' => (Yii::$app->controller->id == 'applicants' && Yii::$app->controller->action->id == 'selection-results')],
                                ['label' => 'My Application', 'icon' => 'list-alt', 'url' => Url::to(['/site/my-application']), 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'my-application')],
                                //['label' => 'Application Status', 'icon' => 'dashboard', 'url' => ['/applicants/application-status'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'application-status')],
                                //['label' => 'My Contact Details', 'icon' => 'envelope', 'url' => ['/applicants/contact-details'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'contact-details')],
                                //['label' => 'Notifications <span class="badge">0</span>', 'icon' => 'star-empty', 'url' => ['/applicants/notifications'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'notifications')],
                                ['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/applicants/change-password'],'active' => (Yii::$app->controller->id == 'applicants')&& (Yii::$app->controller->action->id == 'change-password')],
                                ['label' => 'Logout', 'icon' => 'off', 'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']],       
                            ],
                        ]);
                        
                    }
                    ?>

                </ul>

       
                </center>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);
                    ?>

                <h1 class="page-header" style="font-size: 1.7em" id="page-header-id"><?= $this->title ?></h1>
                <?= $content ?>
            </div>
        </div>
    </div>

                <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>

    jQuery(document).ready(function () {
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ')
                    c = c.substring(1);
                if (c.indexOf(name) == 0)
                    return c.substring(name.length, c.length);
            }
            return "";
        }

        jQuery("a").on('click', function (e) {
            e.preventDefault();
            var nav_bar_position = $("#side-nav-div-id").scrollTop();
            setCookie("nav_bar_position", nav_bar_position, 1);
            document.cookie = "nav_bar_position=" + nav_bar_position;
            var url = jQuery(this).attr('href');
            document.location.href = url;

        });
        var stored_nav_position = getCookie("nav_bar_position");
        $("#side-nav-div-id").scrollTop(stored_nav_position);
    });


</script>
