<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);

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
                    <span class="logo-mini">iLMS Institution Portal</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg" style="font-size: 14px;"><b>OLAMS - Institution Portal</b></span>
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
                                    <span class="hidden-xs"><?= Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="http://placehold.it/160x160" class="img-circle" alt="">
                                        <p>
                                            <?= Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname; ?>
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
                                    ["label" => "Dashboard",
                                        "url" => Url::to(['/institution/index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index'),
                                        "icon" => "dashboard", 'visible' => yii::$app->user->can('/application/default/index')],
                                    [
                                        "label" => "Examination Results",
                                        'visible' => (Yii::$app->session->get('institution_type') == \common\models\Staff::TYPE_HLI) ? TRUE : FALSE, //yii::$app->user->can('/application/gepg-cnumber/*'),
                                        "icon" => "gear",
                                        "url" => "#",
                                        "url" => Url::to(['/institution/exam-results'])
                                    ],
                                    [
                                        "label" => "Students Admissions",
                                        'visible' => (Yii::$app->session->get('institution_type') == \common\models\Staff::TYPE_HLI) ? TRUE : FALSE, //yii::$app->user->can('/application/gepg-cnumber/*'),
                                        "icon" => "graduation-cap",
                                        "url" => "#",
                                        "url" => Url::to(['/institution/student-admissions'])
                                    ],
                                    [
                                        "label" => "Freshers Admissions",
                                        'visible' => (Yii::$app->session->get('institution_type') == \common\models\Staff::TYPE_TCU) ? TRUE : FALSE, //yii::$app->user->can('/application/gepg-cnumber/*'),
                                        "icon" => "graduation-cap",
                                        "url" => "#",
                                        "url" => Url::to(['/institution/freshers-student-admissions'])
                                    ],
                                    //  ["label" => "Report", "url" => ["#"], "icon" => "fa fa-bar-chart"],
                                    ["label" => "Report", "url" => ["#"], "icon" => "fa fa-bar-chart",
                                        "items" => [
                                        //['label' => 'Response Source','url' =>['/application/qresponse-source/index'], 'active' => (Yii::$app->controller->id == 'default'),'visible' =>yii::$app->user->can('/application/student-exam-result/index')], 
                                        ],
                                    ],
                                ],
                                'encodeLabels' => false,
                            ]
                    )
                    ?>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h3 class="box-title" style="margin: 0; max-width: 50%;font-size: 15px;">
                        <?php
                        echo Yii::$app->session->has('institution_name') ? Yii::$app->session->get('institution_name') : '';
                        ?>
                    </h3>
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
