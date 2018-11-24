<?php

use yii\helpers\Html;
use frontend\modules\repayment\models\EmployerSearch;
//use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="List of Notification";
$this->title ="List of Notifications";
$this->params['breadcrumbs'][] = $this->title;
$loggedin=Yii::$app->user->identity->user_id;
        $employerModel = new EmployerSearch();
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
$notificationNewBill1=0;
$notificationPaymentPending1=0;

//check new New bill for employer
$newBill= \frontend\modules\repayment\models\LoanSummary::find()
        ->where(['status' =>'0','employer_id'=>$employerID])
        ->count();
//check for pending payment
$paymentPending= \frontend\modules\repayment\models\LoanRepayment::find()
        ->where(['payment_status' =>'0','employer_id'=>$employerID])
        ->count();

$notificationNewBill=$newBill + $notificationNewBill1;
$notificationPaymentPending=$paymentPending + $notificationPaymentPending1;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
                        <div class="panel-heading">
                  
                        </div>
                        <div class="panel-body">
           
    <p>
        <?= Html::a("New Loan Summary&nbsp;&nbsp;<span class='label label-warning'>$notificationNewBill</span>", ['/repayment/loan-summary'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a("Pending Payments&nbsp;&nbsp;<span class='label label-warning'>$notificationPaymentPending</span>", ['/repayment/loan-repayment'], ['class' => 'btn btn-success']) ?>
    </p>
                             </div>
                   
                </div>   
</div>