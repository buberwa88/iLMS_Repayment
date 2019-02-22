<?php

/**
 * @var $content string
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;

yiister\adminlte\assets\Asset::register($this);
$totalNotifications1 = 0;
$notificationSubtotal = 0;
// check new employer
$employer = \backend\modules\repayment\models\Employer::find()->where(['verification_status' => '0'])->count();

//check new employed beneficiary 
$beneficiary = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['confirmed' => 1, 'upload_status' => 1, 'verification_status' => 0, 'employment_status' => 'ONPOST', 'employee_status' => 0])
        ->andWhere(['>', 'applicant_id', '0'])
        ->count();
$beneficiaryOnstudy = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['confirmed' => 1, 'upload_status' => 1, 'verification_status' => [0, 4], 'employment_status' => 'ONPOST', 'employee_status' => 1])
        ->andWhere(['>', 'applicant_id', '0'])
        ->count();
$nonbeneficiary = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['confirmed' => 1, 'upload_status' => 1, 'verification_status' => 4, 'employment_status' => 'ONPOST', 'employee_status' => 0])
        ->count();
$nonApplicant = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['confirmed' => 1, 'upload_status' => 1, 'verification_status' => 0, 'employment_status' => 'ONPOST', 'employee_status' => 0])
        ->andWhere(['or',
            ['=', 'applicant_id', ''],
            ['applicant_id' => NULL],
        ])
        ->count();
/*
  $beneficiary= \backend\modules\repayment\models\EmployedBeneficiary::find()
  //->where(['verification_status' =>'0'])
  //->andWhere(['employed_beneficiary.employer_id'=>$employerID])
  ->andWhere(['or',
  ['employed_beneficiary.verification_status'=>0],
  ['employed_beneficiary.verification_status'=>4],
  ])
  ->count();
 * 
 */

//check new employed beneficiary, Employer Bill
$NewEmployerBill = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['verification_status' => '1', 'loan_summary_id' => NULL])
        ->count('DISTINCT(employer_id)');

//check new employed beneficiary, Employer Bill
$newBillRequest = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['verification_status' => '1', 'loan_summary_id' => NULL])
        ->count('DISTINCT(employer_id)');

//check new employed beneficiary waiting to be submited
$beneficiariesWaiting = \backend\modules\repayment\models\EmployedBeneficiary::find()
        ->where(['verification_status' => '3'])
        ->count();

//check new bill ceased waiting to be submited
$billRequestCeased = \backend\modules\repayment\models\LoanSummary::find()
        ->where(['status' => '5'])
        ->count();

//check new bill request loanee
$billRequestLoanee = \backend\modules\repayment\models\LoanSummary::find()->where(['status' => '7'])->count();

//checking registered beneficiaries pending verification
$pendingRegisteredBeneficiary = \common\models\LoanBeneficiary::find()->where(['applicant_id' => NULL])->count();

$totalNotifications = $employer + $beneficiary + $newBillRequest + $beneficiariesWaiting + $billRequestCeased + $totalNotifications1 + $billRequestLoanee + $pendingRegisteredBeneficiary + $nonbeneficiary + $nonApplicant;
$newEmployer = $notificationSubtotal + $employer;
$nonbeneficiary1 = $notificationSubtotal + $nonbeneficiary;
$nonApplicant1 = $notificationSubtotal + $nonApplicant;
//$newBeneficiary=$notificationSubtotal + $beneficiary + $beneficiariesWaiting;
$newBeneficiary = $notificationSubtotal + $beneficiary;
$beneficiaryOnstudy = $notificationSubtotal + $beneficiaryOnstudy;
$billRequst = $notificationSubtotal + $newBillRequest + $billRequestCeased + $billRequestLoanee;
$newRegisteredBeneficiary = $notificationSubtotal + $pendingRegisteredBeneficiary;
$notificationNewEmployerBill = $NewEmployerBill + $notificationSubtotal;
$notificationLoaneeBill = $billRequestLoanee + $notificationSubtotal;

if ($totalNotifications > 0) {
    $overallNotification = " <span class='label label-warning' style='font-size:12px'>" . number_format($totalNotifications) . "</span>";
} else {
    $overallNotification = "";
}
if ($newEmployer > 0) {
    $newEmployerFinalResults = " <span class='label label-warning' style='font-size:12px'>" . number_format($newEmployer) . "</span>";
} else {
    $newEmployerFinalResults = "";
}
if ($newBeneficiary > 0) {
    $newBeneficiaryFinalResults = " <span class='label label-warning' style='font-size:12px'>" . number_format($newBeneficiary) . "</span>";
} else {
    $newBeneficiaryFinalResults = "";
}
if ($nonbeneficiary1 > 0) {
    $nonbeneficiaryFinal = " <span class='label label-warning' style='font-size:12px'>" . number_format($nonbeneficiary1) . "</span>";
} else {
    $nonbeneficiaryFinal = "";
}
if ($nonApplicant1 > 0) {
    $nonApplicantFinal = " <span class='label label-warning' style='font-size:12px'>" . number_format($nonApplicant1) . "</span>";
} else {
    $nonApplicantFinal = "";
}
if ($notificationNewEmployerBill > 0) {
    $notificationNewEmployerBillFinal = " <span class='label label-warning' style='font-size:12px'>" . number_format($notificationNewEmployerBill) . "</span>";
} else {
    $notificationNewEmployerBillFinal = "";
}
if ($notificationLoaneeBill > 0) {
    $notificationLoaneeBillFinalReslt = " <span class='label label-warning' style='font-size:12px'>" . number_format($notificationLoaneeBill) . "</span>";
} else {
    $notificationLoaneeBillFinalReslt = "";
}
if ($newRegisteredBeneficiary > 0) {
    $newRegisteredBeneficiaryFinalResult = " <span class='label label-warning' style='font-size:12px'>" . number_format($newRegisteredBeneficiary) . "</span>";
} else {
    $newRegisteredBeneficiaryFinalResult = "";
}
if ($beneficiaryOnstudy > 0) {
    $beneficiaryOnstudyFinal = " <span class='label label-warning' style='font-size:12px'>" . number_format($beneficiaryOnstudy) . "</span>";
} else {
    $beneficiaryOnstudyFinal = "";
}
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
                                    ["label" => "Dashboard", "url" => ["/repayment/default/index"], "icon" => "dashboard"],
                                    //here for operations
                                    [
                                        "label" => "Operations",
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Beneficiaries", "url" => Url::to(['/repayment/loan-beneficiary/all-loanees']), 'active' => (Yii::$app->controller->id == 'loan-beneficiary' && (Yii::$app->controller->action->id == 'all-loanees' || Yii::$app->controller->action->id == 'view-loanee-details')), "icon" => "users"],
                                            ["label" => "Employed Beneficiaries", "url" => Url::to(['/repayment/employed-beneficiary/active-employed-beneficiaries']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && Yii::$app->controller->action->id == 'active-employed-beneficiaries'), "icon" => "users"],
                                            ["label" => "Full Repaid Beneficiaries", "url" => Url::to(['/repayment/loan-summary/full-paidbeneficiary']), 'active' => (Yii::$app->controller->id == 'loan-summary' && Yii::$app->controller->action->id == 'full-paidbeneficiary'), "icon" => "users"],
                                            ["label" => "Employers", "url" => Url::to(['/repayment/employer']), 'active' => ((Yii::$app->controller->id == 'employer' || Yii::$app->controller->id == 'employed-beneficiary') && (Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'create-employerheslb' || Yii::$app->controller->action->id == 'view' || Yii::$app->controller->action->id == 'create' || Yii::$app->controller->action->id == 'index-upload-employees' || Yii::$app->controller->action->id == 'add-contact-person' || Yii::$app->controller->action->id == 'update-information' || Yii::$app->controller->action->id == 'update-contactperson' || Yii::$app->controller->action->id == 'change-password-contactp')), "icon" => "users"],
                                            //["label" => "Loan Summary", "url" => Url::to(['/repayment/loan-summary']), 'active' => (Yii::$app->controller->id =='loan-summary'&&(Yii::$app->controller->action->id=='index'||Yii::$app->controller->action->id=='view')), "icon" => "money"],
                                            ["label" => "Bills", "url" => Url::to(['/repayment/loan-repayment/bills']), 'active' => (Yii::$app->controller->id == 'loan-repayment' && (Yii::$app->controller->action->id == 'bills')), "icon" => "th"],
                                            //["label" => "Employer Penalty Bill", "url" => Url::to(['/repayment/loan-repayment/all-payments']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&(Yii::$app->controller->action->id=='all-payments' || Yii::$app->controller->action->id=='view')), "icon" => "th"],
                                            //["label" => "Loan Payments", "url" => Url::to(['/repayment/loan-repayment/all-payments']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&(Yii::$app->controller->action->id=='all-payments' || Yii::$app->controller->action->id=='view')), "icon" => "th"],
                                            ["label" => "Re-Payments", "url" => Url::to(['/repayment/loan-repayment/paymentslist']), 'active' => (Yii::$app->controller->id == 'loan-repayment' && (Yii::$app->controller->action->id == 'paymentslist')), "icon" => "th"],
                                            //["label" => "Employer Penalties Payment", "url" => Url::to(['/repayment/loan-repayment/paymentslist']), 'active' => (Yii::$app->controller->id =='loan-repayment'&&(Yii::$app->controller->action->id=='paymentslist')), "icon" => "th"],
                                            ["label" => "Employer Penalty", "url" => Url::to(['/repayment/employer/employer-penalty']), 'active' => (Yii::$app->controller->id == 'employer' && (Yii::$app->controller->action->id == 'employer-penalty' || Yii::$app->controller->action->id == 'cancel-penalty')), "icon" => "users"],
                                            ["label" => "Employer Penalty Payment", "url" => Url::to(['/repayment/employer/employer-penalty-payment']), 'active' => (Yii::$app->controller->id == 'employer' && (Yii::$app->controller->action->id == 'employer-penalty-payment')), "icon" => "th"],
                                            ["label" => "Re-Proccess Loan", "url" => Url::to(['/repayment/loan-beneficiary/reprocess-loan']), 'active' => ((Yii::$app->controller->id == 'loan-beneficiary') && (Yii::$app->controller->action->id == 'reprocess-loan')), "icon" => "th"],
                                            ["label" => "Pre-payment", "url" => Url::to(['/repayment/loan-repayment/prepaid']), 'active' => ((Yii::$app->controller->id == 'loan-repayment') && (Yii::$app->controller->action->id == 'prepaid' || Yii::$app->controller->action->id == 'view-prepaid')), "icon" => "th"],
                                            ["label" => "GSPP Deduction Details", "url" => Url::to(['/repayment/loan-repayment/requestgspp-monthdeduction']), 'active' => ((Yii::$app->controller->action->id == 'requestgspp-monthdeduction' || Yii::$app->controller->action->id == 'requestgspp-monthdeductionform') && Yii::$app->controller->id == 'loan-repayment'), "icon" => "th"],
                                            ["label" => "GSPP All Employees", "url" => Url::to(['/repayment/loan-repayment/requestgspp-allemploydeduct']), 'active' => ((Yii::$app->controller->action->id == 'requestgspp-allemploydeduct' || Yii::$app->controller->action->id == 'requestgspp-allemploydeductform') && Yii::$app->controller->id == 'loan-repayment'), "icon" => "users"],
                                        ],
                                    ],
                                    [
                                        "label" => "Refund",
                                        'visible' => yii::$app->user->can('/repayment/refund-application-operation/index'),
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ['label' => 'All Applications', 'url' => ['/repayment/refund-application-operation/allapplications'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'allapplications' || Yii::$app->controller->action->id == 'view-refund')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/allapplications')],
                                            ['label' => 'Un-previewed', 'url' => ['/repayment/refund-application-operation/unverifiedref'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'unverifiedref' || Yii::$app->controller->action->id == 'view-refund')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/unverifiedref')],
                                            ['label' => 'Pending Previewed', 'url' => ['/repayment/refund-application-operation/pendingref'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'pendingref' || Yii::$app->controller->action->id == 'view-refund')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/pendingref')],
                                            ['label' => 'Incomplete Previewed', 'url' => ['/repayment/refund-application-operation/incompleteref'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'incompleteref' || Yii::$app->controller->action->id == 'view-refund')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/incompleteref')],
                                            ['label' => 'Invalid Previewed', 'url' => ['/repayment/refund-application-operation/invalidref'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'invalidref' || Yii::$app->controller->action->id == 'view-refund')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/invalidref')],
                                            ['label' => 'Complete Previewed', 'url' => ['/repayment/refund-application-operation/completeref'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'completeref' || Yii::$app->controller->action->id == 'view-refund')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/unverifiedref')],
                                            ['label' => 'Assignment', 'url' => ['/repayment/refund-application-operation/verifyapplication'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'verifyapplication' || Yii::$app->controller->action->id == 'view-refundlevel')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/verifyapplication')],
                                            ['label' => 'Verify Application', 'url' => ['/repayment/refund-application-operation/verifyapplication'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'verifyapplication' || Yii::$app->controller->action->id == 'view-refundlevel')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/verifyapplication')],
                                            ['label' => 'Pending Verified', 'url' => ['/repayment/refund-application-operation/verifiedrefappl'], 'active' => (Yii::$app->controller->id == 'refund-application-operation' && (Yii::$app->controller->action->id == 'verifiedrefappl' || Yii::$app->controller->action->id == 'view-verifref')), 'visible' => yii::$app->user->can('/repayment/refund-application-operation/verifiedrefappl')],
                                            ['label' => 'Waiting for Letter', 'url' => ['/repayment/refund-application/waiting-letter'], 'active' => ((Yii::$app->controller->id == 'refund-application' || Yii::$app->controller->id == 'refund-application-operation') && (Yii::$app->controller->action->id == 'waiting-letter' || Yii::$app->controller->action->id == 'view-verifref')), 'visible' => yii::$app->user->can('/repayment/refund-application/waiting-letter')],
                                            ['label' => 'Pay List', 'url' => ['/repayment/refund-paylist/index'], 'active' => (Yii::$app->controller->id == 'refund-paylist' && (Yii::$app->controller->action->id == 'pay-list' || Yii::$app->controller->action->id == 'view-verifref')),],// 'visible' => yii::$app->user->can('/repayment/refund-application/pay-list')],
                                            ['label' => 'Refunded Application', 'url' => ['/repayment/refund-application/paid-application'], 'active' => (Yii::$app->controller->id == 'refund-application' && (Yii::$app->controller->action->id == 'paid-application' || Yii::$app->controller->action->id == 'view-verifref')), 'visible' => yii::$app->user->can('/repayment/refund-application/paid-application')],

                                            ['label' => 'Submitted', 'url' => ['/application/application/submitted-applications'], 'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'submitted-applications'), 'visible' => yii::$app->user->can('/application/application/index')],
                                            ['label' => 'Release Complete' . $overallNotification, 'url' => ['/application/application/release-applications'], 'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'release-applications'), 'visible' => yii::$app->user->can('/application/application/index')],
                                            ['label' => 'Assignment', 'url' => ['/application/verification-assignment'], 'active' => (Yii::$app->controller->id == 'verification-assignment' && Yii::$app->controller->action->id != 'index-verification-assigned' && Yii::$app->controller->action->id != 'reattachment' && Yii::$app->controller->action->id != 'assign-reattached' && Yii::$app->controller->action->id != 'reverse-bulkreattached'), 'visible' => yii::$app->user->can('/application/verification-assignment/index')],
                                            ['label' => 'Reverse Refund', 'url' => ['/application/application/reverse-verification'], 'active' => (Yii::$app->controller->id == 'application' && Yii::$app->controller->action->id == 'reverse-verification'), 'visible' => yii::$app->user->can('/application/application/reverse-verification')],
                                        ],
                                    ],
                                    [
                                        "label" => "Notifications" . $overallNotification,
                                        "icon" => "fa fa-bell-o",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "New Employer" . $newEmployerFinalResults, "url" => Url::to(['/repayment/employer/index-notification']), 'active' => (Yii::$app->controller->id == 'employer' && Yii::$app->controller->action->id == 'index-notification')],
                                            //["label" => "Employees".$newBeneficiaryFinalResults, "url" => Url::to(['/repayment/employed-beneficiary/new-employed-beneficiaries']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary'&&Yii::$app->controller->action->id=='new-employed-beneficiaries')],
                                            ["label" => "New Beneficiaries" . $newBeneficiaryFinalResults, "url" => Url::to(['/repayment/employed-beneficiary/new-employed-beneficiaries-found']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && (Yii::$app->controller->action->id == 'new-employed-beneficiaries-found' || Yii::$app->controller->action->id == 'mult-employed' || Yii::$app->controller->action->id == 'deactivate-double-employed'))],
                                            ["label" => "Beneficiaries ONSTUDY" . $beneficiaryOnstudyFinal, "url" => Url::to(['/repayment/employed-beneficiary/new-employeeonstudy']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && (Yii::$app->controller->action->id == 'new-employeeonstudy' || Yii::$app->controller->action->id == 'update-employeeonstudy'))],
                                            ["label" => "Non Beneficiary" . $nonbeneficiaryFinal, "url" => Url::to(['/repayment/employed-beneficiary/new-employeenoloan']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && (Yii::$app->controller->action->id == 'new-employeenoloan'))],
                                            ["label" => "Non Applicant" . $nonApplicantFinal, "url" => Url::to(['/repayment/employed-beneficiary/non-found-uploaded-employees']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && (Yii::$app->controller->action->id == 'non-found-uploaded-employees' || Yii::$app->controller->action->id == 'update'))],
                                            ["label" => "Employee Matching Status", "url" => Url::to(['/repayment/employed-beneficiary/employee-matching']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && Yii::$app->controller->action->id == 'employee-matching')],
                                            ["label" => "Loan Statement Request" . $beneficiaryOnstudyFinal, "url" => Url::to(['/repayment/employed-beneficiary/new-employeeonstudy']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && (Yii::$app->controller->action->id == 'new-employeeonstudy' || Yii::$app->controller->action->id == 'update-employeeonstudy'))],
                                        ],
                                    ],
                                    [
                                        "label" => "Configurations",
                                        "icon" => "gears",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Payment Modes", "url" => Url::to(['/repayment/pay-method/index']), 'active' => (Yii::$app->controller->id == 'pay-method')],
                                            // ["label" => "Bank Accounts", "url" => Url::to(['/repayment/bank-account/index']), 'active' => (Yii::$app->controller->id == 'bank-account')],
                                            ["label" => "Loan Repayment Items", "url" => Url::to(['/repayment/loan-repayment-item/index']), 'active' => (Yii::$app->controller->id == 'loan-repayment-item')],
                                            ["label" => "Loan Repayment Setting", "url" => Url::to(['/repayment/loan-repayment-setting/index']), 'active' => (Yii::$app->controller->id == 'loan-repayment-setting')],
                                            ["label" => "General Setting", "url" => Url::to(['/repayment/system-setting/index']), 'active' => (Yii::$app->controller->id == 'system-setting')],
                                            ["label" => "Employers Penalty Cycle", "url" => Url::to(['/repayment/employer-penalty-cycle/index']), 'active' => (Yii::$app->controller->id == 'system-setting')],
                                            //["label" => "Employers Penalty Setting", "url" => Url::to(['/repayment/employer-monthly-penalty-setting']), 'active' => (Yii::$app->controller->id == 'employer-monthly-penalty-setting')],
                                            ["label" => "Employer Type", "url" => Url::to(['/repayment/employer-type']), 'active' => (Yii::$app->controller->id == 'employer-type')],
                                            ["label" => "Sector", "url" => Url::to(['/repayment/nature-of-work']), 'active' => (Yii::$app->controller->id == 'nature-of-work')],
                                            ["label" => "GePG Payment", "url" => Url::to(['/repayment/loan-repayment/gepg-payments']), 'active' => (Yii::$app->controller->id == 'loan-repayment' && (Yii::$app->controller->action->id == 'gepg-payments'))],
                                            ["label" => "Loan Summary", "url" => Url::to(['/repayment/employed-beneficiary/loanthrough-employers']), 'active' => (Yii::$app->controller->id == 'employed-beneficiary' && (Yii::$app->controller->action->id == 'loanthrough-employers'))],
                                            ["label" => "GePG Bill Proccessing Setting", "url" => Url::to(['/repayment/gepg-bill-processing-setting/index']), 'active' => (Yii::$app->controller->id == 'gepg-bill-processing-setting')],
                                            ["label" => "Refund Verification Rejections Reasons", "url" => Url::to(['/repayment/refund-comment/index']), 'active' => (Yii::$app->controller->id == 'refund-comment')],
                                            ["label" => "Refund Progress Reasons Setting", "url" => Url::to(['/repayment/refund-status-reason-setting/index']), 'active' => (Yii::$app->controller->id == 'refund-comment')],
                                            ["label" => "Refund Operational Setting", "url" => Url::to(['/repayment/refund-internal-operational-setting/index']), 'active' => (Yii::$app->controller->id == 'refund-internal-operational-setting')],
                                            ["label" => "Refund Letter Format", "url" => Url::to(['/repayment/refund-letter-format/index']), 'active' => (Yii::$app->controller->id == 'refund-letter-format')],
                                            ["label" => "Refund Verification Framework", "url" => Url::to(['/repayment/refund-verification-framework/index']), 'active' => (Yii::$app->controller->id == 'refund-verification-framework')],
                                            ["label" => "Create Staff", "url" => Url::to(['/repayment/default/add-user']), 'active' => (Yii::$app->controller->id == 'default' && (Yii::$app->controller->action->id == 'create-user' || Yii::$app->controller->action->id == 'add-user'))],
                                        ],
                                    ],
                                    [
                                        "label" => "Reports",
                                        'visible' => yii::$app->user->can('/report/report/index'),
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Favourites Reports", "url" => Url::to(['/repayment/loan-beneficiary/index-popularreport']),
                                                'active' => (Yii::$app->controller->id == 'loan-beneficiary' && (Yii::$app->controller->action->id == 'index-popularreport' || Yii::$app->controller->action->id == 'create-popularreport' || Yii::$app->controller->action->id == 'view-popularreport')),
                                                'visible' => yii::$app->user->can('/repayment/loan-beneficiary/index-popularreport')
                                            ],
                                            ["label" => "All Reports", "url" => Url::to(['/repayment/loan-beneficiary/all-reports']),
                                                'active' => Yii::$app->controller->id == 'loan-beneficiary' && (Yii::$app->controller->action->id == 'all-reports' || Yii::$app->controller->action->id == 'view-operation'),
                                                'visible' => yii::$app->user->can('/repayment/loan-beneficiary/all-reports')
                                            ],
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
                                        'url' => ["default/index"],
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
