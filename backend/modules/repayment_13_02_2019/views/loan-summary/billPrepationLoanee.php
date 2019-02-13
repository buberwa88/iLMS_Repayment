<?php
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Approve Loan Summary';
$this->params['breadcrumbs'][] = ['label' => 'Loan Summary', 'url' => ['/repayment/loan-summary/loanee-waiting-bill']];
$this->params['breadcrumbs'][] = $this->title;

$resultsLoanee=$model->getBillRequestedLoaneePending($loan_summary_id);
$billNumber=$resultsLoanee->reference_number;
$applicantID=$resultsLoanee->applicant_id;
$applicantName=$resultsLoanee->applicant->user->firstname." ".$resultsLoanee->applicant->user->middlename." ".$resultsLoanee->applicant->user->surname;
$tracedBy=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;

$totalAcculatedLoan=number_format($searchModel->getTotalLoanInBillLoanee($applicantID),2);
//$this->title = 'Verify and Approve Bill';
$billNote="Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
?>

<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                         <?= Html::encode($this->title) ?>   
                        </div>
    
                        <div class="panel-body">
                            <?= $this->render('_formLoaneeBill', [
                                'model' => $model,'applicant_id'=>$applicantID,'applicantName'=>$applicantName,'Bill_Ref_No'=>$loan_summary_id,'billNumber'=>$billNumber,'totalLoanInBill'=>$totalAcculatedLoan,'billNote'=>$billNote,
                                ]) ?>                                                   
</div>
       </div>
</div>

