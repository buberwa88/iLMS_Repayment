<?php

use yii\helpers\Html;
//use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="List of Notification";
$this->title ="List of Notifications";
$this->params['breadcrumbs'][] = $this->title;
$notificationEmployer1=0;
$notificationEmployedBeneficiary1=0;
$notificationNewEmployedBeneficiaryBill1=0;
$notificationWaitingLoanees1=0;
$notificationNewBeneficiaryRegistered1=0;
// check new employer
$employer= \backend\modules\repayment\models\Employer::find()->where(['verification_status' =>'0'])->count();

 //check new employed beneficiary
$beneficiary= \backend\modules\repayment\models\EmployedBeneficiary::find()->where(['verification_status' =>'0'])->count();
//checking registered beneficiaries pending verification
$pendingRegisteredBeneficiary= \common\models\LoanBeneficiary::find()->where(['applicant_id' =>NULL])->count();
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

$notificationEmployer=$employer + $notificationEmployer1;
$notificationEmployedBeneficiary=$beneficiary + $notificationEmployedBeneficiary1;
$notificationNewEmployedBeneficiaryBill=$newBillRequest + $billRequestCeased + $billRequestLoanee + $notificationNewEmployedBeneficiaryBill1;
$notificationWaitingLoanees=$beneficiariesWaiting + $notificationWaitingLoanees1;
$notificationNewBeneficiaryRegistered=$notificationNewBeneficiaryRegistered1 + $pendingRegisteredBeneficiary;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
                        <div class="panel-heading">
                  
                        </div>
                        <div class="panel-body">
           
    <p>
        <?=''; //Html::a('Add Employee Loan Beneficiary', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a("New Employers&nbsp;&nbsp;<span class='label label-warning'>$notificationEmployer</span>", ['/repayment/employer/new-employer'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;
        <?= Html::a("New Employed Beneficiaries&nbsp;&nbsp;<span class='label label-warning'>$notificationEmployedBeneficiary</span>", ['/repayment/employed-beneficiary/new-employed-beneficiaries'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;
        <?= Html::a("New Bills Requests&nbsp;&nbsp;<span class='label label-warning'>$notificationNewEmployedBeneficiaryBill</span>", ['/repayment/employed-beneficiary/employer-waiting-bill'], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;
        <?= Html::a("Loanees Waiting&nbsp;&nbsp;<span class='label label-warning'>$notificationWaitingLoanees</span>", ['/repayment/employed-beneficiary/verify-beneficiaries-in-bulk'], ['class' => 'btn btn-success']) ?>
		&nbsp;&nbsp;&nbsp;
        <?= Html::a("Pending Registered Beneficiaries&nbsp;&nbsp;<span class='label label-warning'>$notificationNewBeneficiaryRegistered</span>", ['/repayment/employed-beneficiary/all-beneficiaries'], ['class' => 'btn btn-success']) ?>
    </p>
                             </div>
                   
                </div>   
</div>