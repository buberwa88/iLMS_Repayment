 
<?php

/**
 * @var $content string
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);
//find the status of account number
$total = 0;
$modeldata = \backend\modules\application\models\Application::find()->where(['bank_account_number' => NULL])->count();

//check registration number
$modelregion = \backend\modules\application\models\Application::find()->where(['registration_number' => NULL])->count();
//end
//end 
$total = $modeldata + $modelregion;

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
                    <span class="logo-lg"><b><front size='20px'>iLMS</front></b></span>
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
                                    <span class="hidden-xs"><?= @Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->middlename . " " . Yii::$app->user->identity->surname; ?></span>
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
                                    ["label" => "Home", "url" => Url::to(['/site/index']), "icon" => "fa fa-home"],
                                    ["label" => "Dashboard", "url" => Url::to(['/allocation/default/index']), 'active' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index'), "icon" => "dashboard", 'visible' => yii::$app->user->can('/allocation/default/index')],
                                    [
                                        "label" => "Import Data",
                                        "icon" => "folder",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Admitted Students", "url" => Url::to(['/allocation/admission-student/index']), 'active' => (Yii::$app->controller->id == 'admission-student')], //'visible' => yii::$app->user->can('/allocation/admission-student/index')],
                                            ["label" => "Transfer Students", "url" => Url::to(['/allocation/student-transfers/index']), 'active' => (Yii::$app->controller->id == 'student-transfers'),], // 'visible' => yii::$app->user->can('/allocation/student-transfers/index')],
                                            ["label" => "Student Exam Result", "url" => Url::to(['/allocation/student-exam-result/index']), 'active' => (Yii::$app->controller->id == 'student-exam-result'), 'visible' => yii::$app->user->can('/allocation/student-exam-result/index')],
                                        //["label" => "Programmes", "url" => Url::to(['/allocation/programme/bulk-upload']), 'active' => (Yii::$app->controller->id == 'admitted-student')], //, 'visible' => yii::$app->user->can('/allocation/programmes/index')],
                                        ],
                                    ],
                                    [
                                        "label" => "Operations",
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Check Eligibility [1]", "url" => Url::to(['/allocation/default/index-compliance']), 'active' => (Yii::$app->controller->action->id == 'index-compliance'), 'visible' => yii::$app->user->can('/allocation/default/index-compliance')],
                                            ["label" => "Perform Means Test[2]", "url" => Url::to(['/allocation/default/index-mean-test']), 'active' => (Yii::$app->controller->action->id == 'index-mean-test'), 'visible' => yii::$app->user->can('/allocation/default/index-mean-test')],
                                            ["label" => "Compute Needness Conti [3]", "url" => Url::to(['/allocation/allocation-process/index-compute-needness']), 'active' => (Yii::$app->controller->action->id == 'index-compute-needness'), 'visible' => yii::$app->user->can('/allocation/allocation-process/index-compute-needness')],
                                            //["label" => "Award Loan [4]", "url" => Url::to(['/allocation/allocation-batch/award-loan']), 'active' => (Yii::$app->controller->action->id == 'award-loan'), 'visible' => yii::$app->user->can('/allocation/allocation-batch/award-loan')],
//                                            ["label" => "Allocate Loan [4]", "url" => Url::to(['/allocation/allocate-loan/index']), 'active' => (Yii::$app->controller->action->id == 'allocate-loan')], // 'visible' => yii::$app->user->can('/allocation/allocate-loan/index')],
                                            ["label" => "Loan Allocations [4]", "url" => Url::to(['/allocation/allocation-history/index']), 'active' => (Yii::$app->controller->id == 'allocation-history')], // 'visible' => yii::$app->user->can('/allocation/allocate-loan/index')],
                                            ["label" => "Allocation Batch [5] ", "url" => Url::to(['/allocation/allocation-batch/index']), 'active' => (Yii::$app->controller->id == 'allocation-batch')],
//                                          ["label" => "Programmes Costs", "url" => Url::to(['/allocation/programme/costs']), 'active' => (Yii::$app->controller->id == 'programme'&&Yii::$app->controller->action->id == 'costs'), 'visible' => yii::$app->user->can('/allocation/programme/costs')],
                                            ["label" => "Loanee", "url" => Url::to(['/allocation/allocation-student/index']), 'active' => (Yii::$app->controller->id == 'allocation-student')],// 'visible' => yii::$app->user->can('/allocation/allocate-loan/index')],
                                            
                                            ],
                                    ],
                                    [
                                        "label" => "Configurations",
                                        "icon" => "gears",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Learning Institution", "url" => Url::to(['/allocation/learning-institution/index']), 'active' => (Yii::$app->controller->id == 'learning-institution'), 'visible' => yii::$app->user->can('/allocation/learning-institution/index')],
                                            ["label" => "Programme Category", "url" => Url::to(['/allocation/programme-category/index']), 'active' => (Yii::$app->controller->id == 'programme-category'), 'visible' => yii::$app->user->can('/allocation/programme-category/index')],
                                            ["label" => "Programme Group", "url" => Url::to(['/allocation/programme-group/index']), 'active' => (Yii::$app->controller->id == 'programme-group'), 'visible' => yii::$app->user->can('/allocation/programme-group/index')],
                                              ["label" => "Loan Item", "url" => Url::to(['/allocation/loan-item/index']), 'active' => (Yii::$app->controller->id == 'loan-item'), 'visible' => yii::$app->user->can('/allocation/loan-item/index')],
                                            ["label" => "Loan Item Priority", "url" => Url::to(['/allocation/loan-item-priority/index']), 'active' => (Yii::$app->controller->id == 'loan-item-priority'), 'visible' => yii::$app->user->can('/allocation/loan-item-priority/index')],
                                            ["label" => "Programmes & Cost", "url" => Url::to(['/allocation/programme/index']), 'active' => (Yii::$app->controller->id == 'programme'), 'visible' => yii::$app->user->can('/allocation/programme/index')],
                                            ["label" => "Programme Cluster", "url" => Url::to(['/allocation/cluster-definition/index']), 'active' => (Yii::$app->controller->id == 'cluster-definition'), 'visible' => yii::$app->user->can('/allocation/cluster-definition/index')],
                                            ["label" => "School Fee", "url" => Url::to(['/allocation/learning-institution-fee/index']), 'active' => (Yii::$app->controller->id == 'learning-institution-fee'), 'visible' => yii::$app->user->can('/allocation/learning-institution-fee/index')],
                                            ["label" => "Fee Factor", "url" => Url::to(['/allocation/allocation-fee-factor/index']), 'active' => (Yii::$app->controller->id == 'allocation-fee-factor'), 'visible' => yii::$app->user->can('/allocation/allocation-fee-factor/index')],
                                            ["label" => "Exam Status", "url" => Url::to(['/allocation/exam-status/index']), 'active' => (Yii::$app->controller->id == 'exam-status'), 'visible' => yii::$app->user->can('/allocation/exam-status/index')],
                                          
                                            //["label" => "Allocation Gender Plan", "url" => Url::to(['/allocation/allocation-plan-gender-setting/index']), 'active' => (Yii::$app->controller->id == 'allocation-plan-gender-setting'), 'visible' => yii::$app->user->can('/allocation/allocation-plan-gender-setting/index')],
//                                            ["label" => "Allocation Priority", "url" => Url::to(['/allocation/allocation-priority/index']), 'active' => (Yii::$app->controller->id == 'allocation-priority'), 'visible' => yii::$app->user->can('/allocation/allocation-priority/index')],
                                           // ["label" => "Currency", "url" => Url::to(['/allocation/currency/index']), 'active' => (Yii::$app->controller->id == 'currency'), 'visible' => yii::$app->user->can('/allocation/currency/index')],
                                            ["label" => "Criteria", "url" => Url::to(['/allocation/criteria/index']), 'active' => (Yii::$app->controller->id == 'criteria'), 'visible' => yii::$app->user->can('/allocation/criteria/index')],
                                         // ["label" => "Sector", "url" => Url::to(['/allocation/sector-definition/index']), 'active' => (Yii::$app->controller->id == 'sector-definition')],
                                            ["label" => "Manage Grants/Scholarship", "url" => Url::to(['/allocation/scholarship-definition/index']), 'active' => (Yii::$app->controller->id == 'scholarship-definition')],
                                            ["label" => "Manage Allocation Framework", "url" => Url::to(['/allocation/allocation-plan/index']), 'active' => (Yii::$app->controller->id == 'allocation-plan')],
                                            ["label" => "Manage Allocation Budget", "url" => Url::to(['/allocation/allocation-budget/index']), 'active' => (Yii::$app->controller->id == 'allocation-budget')],
                                            
                                            ["label" => "Allocation Task", "url" => Url::to(['/allocation/allocation-task/index']), 'active' => (Yii::$app->controller->id == 'allocation-task'), 'visible' => yii::$app->user->can('/allocation/allocation-task/index')],
                                            ["label" => "Allocation Structure", "url" => Url::to(['/allocation/allocation-structure']), 'active' => (Yii::$app->controller->id == 'allocation-structure'), 'visible' => yii::$app->user->can('/allocation/allocation-structure/index')],
                                            ["label" => "Allocation User Task", "url" => Url::to(['/allocation/allocation-user-structure/index']), 'active' => (Yii::$app->controller->id == 'allocation-user-structure'), 'visible' => yii::$app->user->can('/allocation/allocation-user-structure/index')],
                                        
                                            
                                        ],
                                    ],
                                    //["label" => "Report", "url" => ["#"], "icon" => "fa fa-bar-chart"],
                                    ["label" => "Report", "url" => ["/report/default"], "icon" => "fa fa-bar-chart"],
                                ],
                            ]
                    )
                    ?>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        <?php //= Html::encode(isset($this->params['h1']) ? $this->params['h1'] : $this->title)      ?>
                    </h1>
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
