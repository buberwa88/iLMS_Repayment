<?php

/**
 * @var $content string
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);
$totalNotifications1=0;
$notificationSubtotal=0;
// check new employer
$employer= \backend\modules\repayment\models\Employer::find()->where(['verification_status' =>'0'])->count();

 //check new employed beneficiary
$beneficiary= \backend\modules\repayment\models\EmployedBeneficiary::find()->where(['verification_status' =>'0'])->count();

//check new employed beneficiary, Employer Bill
$NewEmployerBill= \backend\modules\repayment\models\EmployedBeneficiary::find()        
        ->where(['verification_status' =>'1','loan_summary_id' =>NULL])
        ->count('DISTINCT(employer_id)');

//check new employed beneficiary, Employer Bill
$newBillRequest= \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['verification_status' =>'1','loan_summary_id' =>NULL])
        ->count('DISTINCT(employer_id)');

//check new employed beneficiary waiting to be submited
$beneficiariesWaiting= \backend\modules\repayment\models\EmployedBeneficiary::find()        
        ->where(['verification_status' =>'3'])
        ->count();

//check new bill ceased waiting to be submited
$billRequestCeased= \backend\modules\repayment\models\LoanSummary::find()        
        ->where(['status' =>'5'])
        ->count();

//check new bill request loanee
$billRequestLoanee= \backend\modules\repayment\models\LoanSummary::find()->where(['status' =>'7'])->count();

//checking registered beneficiaries pending verification
$pendingRegisteredBeneficiary= \common\models\LoanBeneficiary::find()->where(['applicant_id' =>NULL])->count();

$totalNotifications=$employer + $beneficiary + $newBillRequest + $beneficiariesWaiting + $billRequestCeased + $totalNotifications1 + $billRequestLoanee + $pendingRegisteredBeneficiary;
$newEmployer=$notificationSubtotal + $employer;
$newBeneficiary=$notificationSubtotal + $beneficiary + $beneficiariesWaiting;
$billRequst=$notificationSubtotal + $newBillRequest + $billRequestCeased + $billRequestLoanee;
$newRegisteredBeneficiary=$notificationSubtotal + $pendingRegisteredBeneficiary;
$notificationNewEmployerBill=$NewEmployerBill + $notificationSubtotal;
$notificationLoaneeBill=$billRequestLoanee + $notificationSubtotal;
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
			    //["label" => "Dashboard", "url" => ["allocation/default"], "icon" => "dashboard"],ActiveEmployedBeneficiaries
			    ["label" => "Employers", "url" => Url::to(['/repayment/employer']), 'active' => (Yii::$app->controller->id =='employer'&&Yii::$app->controller->action->id=='index'), "icon" => "users"],
                ["label" => "Loan Beneficiaries", "url" => Url::to(['/repayment/employed-beneficiary/active-employed-beneficiaries']), 'active' => (Yii::$app->controller->id =='employed-beneficiary'&&Yii::$app->controller->action->id=='active-employed-beneficiaries'), "icon" => "users"],
				/*
				["label" => "Loan Beneficiaries", "url" => Url::to(['/repayment/employed-beneficiary/beneficiaries-view']), 'active' => (Yii::$app->controller->id =='employed-beneficiary'), "icon" => "users"],
				*/
			    ["label" => "Loan Summary", "url" => Url::to(['/repayment/loan-summary']), 'active' => (Yii::$app->controller->id =='loan-summary'&&Yii::$app->controller->action->id=='index'), "icon" => "money"],
                            ["label" => "Payments", "url" => Url::to(['/repayment/loan-repayment-detail/bills-payments']), 'active' => (Yii::$app->controller->id =='loan-repayment-detail'), "icon" => "th"],
                            ["label" => "Receipts", "url" => Url::to(['/repayment/loan-repayment/receipt']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&Yii::$app->controller->action->id=='receipt'), "icon" => "money"],
                            //["label" => "Notifications <i class='fa fa-bell-o'></i><span class='label label-warning'>$totalNotifications</span>", "url" => Url::to(['/repayment/default/notification']), 'active' => (Yii::$app->controller->id =='default'), "icon" => "fa fa-bell-o"],
							
							//here for operations
							
							[
									"label" => "Operations",
									"icon" => "gear",
									"url" => "#",
								"items" => [
                                ["label" => "Employers", "url" => Url::to(['/repayment/employer']), 'active' => (Yii::$app->controller->id =='employer'&&Yii::$app->controller->action->id=='index'), "icon" => "users"],
                                ["label" => "Loan Beneficiaries", "url" => Url::to(['/repayment/employed-beneficiary/active-employed-beneficiaries']), 'active' => (Yii::$app->controller->id =='employed-beneficiary'&&Yii::$app->controller->action->id=='active-employed-beneficiaries'), "icon" => "users"],
				/*
				["label" => "Loan Beneficiaries", "url" => Url::to(['/repayment/employed-beneficiary/beneficiaries-view']), 'active' => (Yii::$app->controller->id =='employed-beneficiary'), "icon" => "users"],
				*/
			                   ["label" => "Loan Summary", "url" => Url::to(['/repayment/loan-summary']), 'active' => (Yii::$app->controller->id =='loan-summary'&&Yii::$app->controller->action->id=='index'), "icon" => "money"],
                               ["label" => "Payments", "url" => Url::to(['/repayment/loan-repayment-detail/bills-payments']), 'active' => (Yii::$app->controller->id =='loan-repayment-detail'), "icon" => "th"],
                               ["label" => "Receipts", "url" => Url::to(['/repayment/loan-repayment/receipt']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&Yii::$app->controller->action->id=='receipt'), "icon" => "money"],								
                                ],
                        ],
							//end for operations
							
							
							

                            [
									"label" => "Notifications <span class='label label-warning'>$totalNotifications</span>",
									"icon" => "fa fa-bell-o",
									"url" => "#",
								"items" => [
                                ["label" => "New Employer <span class='label label-warning'>$newEmployer</span>", "url" => Url::to(['/repayment/employer/index-notification']), 'active' => (Yii::$app->controller->id == 'employer'&&Yii::$app->controller->action->id=='index-notification')],
								["label" => "Employees <span class='label label-warning'>$newBeneficiary</span>", "url" => Url::to(['/repayment/employed-beneficiary/new-employed-beneficiaries']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary'&&Yii::$app->controller->action->id=='new-employed-beneficiaries')],
								["label" => "Loan Summary Employer <span class='label label-warning'>$notificationNewEmployerBill</span>", "url" => Url::to(['/repayment/employed-beneficiary/employer-waiting-loan-summary']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary'&&Yii::$app->controller->action->id=='employer-waiting-loan-summary')],
								["label" => "Loan Summary Beneficiary <span class='label label-warning'>$notificationLoaneeBill</span>", "url" => Url::to(['/repayment/loan-summary/loanee-waiting-bill']), 'active' => (Yii::$app->controller->id == 'loan-summary'&&Yii::$app->controller->action->id=='loanee-waiting-bill')],
								["label" => "New Registered Beneficiaries <span class='label label-warning'>$newRegisteredBeneficiary</span>", "url" => Url::to(['/repayment/loan-beneficiary/index']), 'active' => (Yii::$app->controller->id == 'loan-beneficiary')],								
                                ],
                        ],
							
			    [
				"label" => "Setting",
				"icon" => "gear",
				"url" => "#",
                            "items" => [
                                ["label" => "Payment Modes", "url" => Url::to(['/repayment/pay-method/index']), 'active' => (Yii::$app->controller->id == 'pay-method')],
                                ["label" => "Bank Accounts", "url" => Url::to(['/repayment/bank-account/index']), 'active' => (Yii::$app->controller->id == 'bank-account')],
                                ["label" => "Loan Repayment Items", "url" => Url::to(['/repayment/loan-repayment-item/index']), 'active' => (Yii::$app->controller->id == 'loan-repayment-item')],
                                ["label" => "Loan Repayment Setting", "url" => Url::to(['/repayment/loan-repayment-setting/index']), 'active' => (Yii::$app->controller->id == 'loan-repayment-setting')],
								["label" => "Employer Type", "url" => Url::to(['/repayment/employer-type']), 'active' => (Yii::$app->controller->id == 'employer-type')],
								["label" => "Nature of Work", "url" => Url::to(['/repayment/nature-of-work']), 'active' => (Yii::$app->controller->id == 'nature-of-work')],
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
                                        'url' => ["employer/index"],
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
