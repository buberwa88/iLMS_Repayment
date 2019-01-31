<?php

/**
 * @var $content string
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);
//find the status of account number
//check complete verification
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
                                    ["label" => "Home", "url" => Url::to(['/site/index']), "icon" => "fa fa-home",'visible' =>yii::$app->user->can("Help_Desk_Only")==FALSE],
                                    ["label" => "Help Desk", "url" => Url::to(['/helpDesk/default/index']), 'active' => (Yii::$app->controller->id == 'default' && (Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'view')), "icon" => "dashboard", 'visible' => yii::$app->user->can('/helpDesk/default/index') && yii::$app->user->can("Help_Desk_Only")==TRUE],
                                    ["label" => "Dashboard", "url" => Url::to(['/report/default/index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index'), "icon" => "dashboard", 'visible' => yii::$app->user->can('/application/default/index')],
                                    //["label" =>"My Profile" , "url" => Url::to(['/disbursement/default/index']), 'active' => (Yii::$app->controller->id =='default'&&Yii::$app->controller->action->id =='index'), "icon" =>"user",'visible' =>yii::$app->user->can('/disbursement/default/index')],
                                    [
                                        "label" => "Reports",
                                        'visible' => yii::$app->user->can('/report/*'),
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Favourites Reports", "url" => Url::to(['/report/popular-report/index']),
                                                'active' => (Yii::$app->controller->id == 'popular-report' && (Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'create' || Yii::$app->controller->action->id == 'view')),
                                                'visible' => yii::$app->user->can('/report/popular-report/index')
                                            ],
                                            ["label" => "All Reports", "url" => Url::to(['/report/report/all-reports']),
                                                'active' => Yii::$app->controller->id == 'report' && (Yii::$app->controller->action->id == 'all-reports' || Yii::$app->controller->action->id == 'view-operation'),
                                    'visible' =>yii::$app->user->can('/report/report/all-reports')
                                            ],
                                        ],
                                    ],
                                    [
                                        "label" => "Configuration",
                                        'visible' => yii::$app->user->can('/application/question/index'),
                                        "icon" => "gears",
                                        "url" => "#",
                                        "items" => [
                                            ['label' => 'Filters', 'url' => ['/report/report-filter-setting/index'],
                                                'active' => Yii::$app->controller->id == 'report-filter-setting', 
                                               'visible' => yii::$app->user->can('/report/report-filter-setting/index')
                                            ],
                                            ['label' => 'Report', 'url' => ['/report/report/index'],
                                                'active' => Yii::$app->controller->id == 'report' && (Yii::$app->controller->action->id != 'all-reports' && Yii::$app->controller->action->id != 'view-operation'),
                                             'visible' =>yii::$app->user->can('/report/report/index')
                                            ],
                                            ['label' => 'Report Access', 'url' => ['/report/report-access/index'],
                                                'active' => Yii::$app->controller->id == 'report-access', 
                                                'visible' => yii::$app->user->can('/report/report-access/index')
                                            ]
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
