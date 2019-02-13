<?php

use yii\helpers\Html;
//use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="List of Notification";
$this->title ="Loan summary request categories";
//$this->params['breadcrumbs'][] = ['label' => 'List of Notifications', 'url' => ['/repayment/default/notification']];
$this->params['breadcrumbs'][] = $this->title;
$notificationNewEmployerBill1=0;
$notificationEmployedBeneficiaryBill=0;
$notificationLoaneeBill1=0;

//check new employed beneficiary, Employer Bill
$NewEmployerBill= \backend\modules\repayment\models\EmployedBeneficiary::find()        
        ->where(['verification_status' =>'1','loan_summary_id' =>NULL])
        ->count('DISTINCT(employer_id)');

 //check new employed beneficiary
$BeneficiaryAdditionalTerminated1= \backend\modules\repayment\models\LoanSummary::find()->where(['bill_status' =>'5'])->count();

//check new bill request loanee
$billRequestLoanee= \backend\modules\repayment\models\LoanSummary::find()->where(['bill_status' =>'7'])->count();


$notificationNewEmployerBill=$NewEmployerBill + $notificationNewEmployerBill1;
$BeneficiaryAdditionalTerminated=$notificationEmployedBeneficiaryBill + $BeneficiaryAdditionalTerminated1;
$notificationLoaneeBill=$billRequestLoanee + $notificationLoaneeBill1;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
                        <div class="panel-heading">
                  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
           
    <p>
        <?=''; //Html::a('Add Employee Loan Beneficiary', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a("Employer(New Employees)&nbsp;&nbsp;<span class='label label-warning'>$notificationNewEmployerBill</span>", ['/repayment/employed-beneficiary/employer-waiting-loan-summary'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a("Employer New Bill(Terminated Employees)&nbsp;&nbsp;<span class='label label-warning'>$BeneficiaryAdditionalTerminated</span>", ['/repayment/loan-summary/employer-waiting-bill-terminated-additional-employee'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a("Beneficiaries&nbsp;&nbsp;<span class='label label-warning'>$notificationLoaneeBill</span>", ['/repayment/loan-summary/loanee-waiting-bill'], ['class' => 'btn btn-success']) ?>
    </p>
                             </div>
                   
                </div>   
</div>