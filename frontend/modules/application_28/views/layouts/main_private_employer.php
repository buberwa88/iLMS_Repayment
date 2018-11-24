<?php

/**
 * @var $content string
 */
use yii\helpers\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployerSearch;

yiister\adminlte\assets\Asset::register($this);

$loggedin=Yii::$app->user->identity->user_id;
        $employerModel = new EmployerSearch();
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
$totalNotifications1=0;
//check new New bill for employer
$newBillSent= \frontend\modules\repayment\models\LoanRepaymentBill::find()
        ->where(['bill_status' =>'0','employer_id'=>$employerID])
        ->count();
//check for pending payment
$paymentPending= \frontend\modules\repayment\models\LoanRepaymentBatch::find()
        ->where(['payment_status' =>'0','employer_id'=>$employerID])
        ->count();
$totalNotifications=$newBillSent + $paymentPending + $totalNotifications1;
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
                <a href="/" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
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
                                    <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="http://placehold.it/160x160" class="img-circle" alt="">
                                        <p>
                                            <?= Yii::$app->user->identity->username ?>
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
                                    ["label" => "Dashboard", "url" => Url::to(['/repayment/loan-repayment-bill']), 'active' => (Yii::$app->controller->id =='loan-repayment-bill3'), "icon" => "dashboard"],
                                    ["label" => "Loan Beneficiaries", "url" => Url::to(['/repayment/employed-beneficiary']), 'active' => (Yii::$app->controller->id =='employed-beneficiary'), "icon" => "users"],
                                    ["label" => "Loan Bills", "url" => Url::to(['/repayment/loan-repayment-bill']), 'active' => (Yii::$app->controller->id =='loan-repayment-bill'), "icon" => "money"],
                                    ["label" => "Pay Bill", "url" => Url::to(['/repayment/loan-repayment-batch']), 'active' => (Yii::$app->controller->id =='loan-repayment-batch'), "icon" => "th"],
                                    ["label" => "Payments", "url" => Url::to(['/repayment/loan-repayment-batch-detail/bills-payments']), 'active' => (Yii::$app->controller->id =='loan-repayment-batch-detail'), "icon" => "th"],
				    ["label" => "Receipts", "url" => Url::to(['/repayment/loan-repayment-bill']), 'active' => (Yii::$app->controller->id =='loan-repayment-bill1'), "icon" => "money"],
                                    ["label" => "Notifications <i class='fa fa-bell-o'></i><span class='label label-warning'>$totalNotifications</span>", "url" => Url::to(['/repayment/default/notification']), 'active' => (Yii::$app->controller->id =='default'), "icon" => "fa fa-bell-o"],
                                ],
                                'encodeLabels' => false,
                            ]
                    )
                    ?>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?= Html::encode(isset($this->params['h1']) ? $this->params['h1'] : "") ?></h1>
                    <?php if (isset($this->params['breadcrumbs'])): ?>
                        <?=
                        \yii\widgets\Breadcrumbs::widget(
                                [
                                    'encodeLabels' => false,
                                    'homeLink' => [
                                        'label' => new \rmrevin\yii\fontawesome\component\Icon('home') . ' Home',
                                        'url' => ["site/index"],
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
