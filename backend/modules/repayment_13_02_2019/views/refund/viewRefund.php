<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Refund */

?>
<div class="refund-view">
    <div class="panel panel-info">
        <div class="panel-body">

    <?= DetailView::widget([
        'model' => $model,
		'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => [
		    [
                'group' => true,
                'label' => "Claimant's Details",
                'rowOptions' => ['class' => 'info']
            ],
			[
            'label'  => 'Claim Category',
            'value'  => call_user_func(function ($data) {
			if($data->claim_category==1){
			return 'Non Beneficiary';
			}else if($data->claim_category==2){
			return 'Over Deduction';
			}else if($data->claim_category==3){
			return 'Deceased';
			}else{
			return '';
			}
            }, $model),            
        ],
		[
            'label'  => 'Index Number',
            'value'  => call_user_func(function ($data) {
			return $data->applicant->f4indexno;
            }, $model),            
        ],
		[
            'label'  => 'Full Name',
            'value'  => call_user_func(function ($data) {
			return $data->applicant->user->firstname." ".$data->applicant->user->middlename." ".$data->applicant->user->surname;
            }, $model),            
        ],            
            'employee_id',
            'description',
			[
            'label'  => 'Refund Amount',
            'value'  => call_user_func(function ($data) {
			return $data->amount;
            }, $model),
            'format'=>['decimal',2],            
        ],
		[
            'label'  => 'Employer',
            'value'  => call_user_func(function ($data) {
			return $data->employer->employer_name;
            }, $model),            
        ],
		[
            'label'  => 'Letter Received Date',
            'value'  => call_user_func(function ($data) {
			return $data->claimant_letter_received_date;
            }, $model),            
        ],
		[
            'label'  => 'Letter ID',
            'value'  => call_user_func(function ($data) {
			return $data->claimant_letter_id;
            }, $model),            
        ],
		[
            'label'  => 'Decision Date',
            'value'  => call_user_func(function ($data) {
			return $data->claim_decision_date;
            }, $model),            
        ],
		[
            'label'  => 'Claim File ID',
            'value'  => call_user_func(function ($data) {
			return $data->claim_file_id;
            }, $model),            
        ],
		[
            'label'  => 'Claim Status',
            'value'  => call_user_func(function ($data) {
			if($data->claim_status==1){
			return 'Stop Deduction';
			}else if($data->claim_category==2){
			return 'Deduction Not Stopped';
			}
            }, $model),            
        ],
			[
                'group' => true,
                'label' => "Beneficiary Details",
                'rowOptions' => ['class' => 'info']
            ],
            'beneficiary_f4indexno',
			'beneficiary_firstname',
			'beneficiary_middlename',
			'beneficiary_surname',
			[
                'group' => true,
                'label' => "Claimant's Contacts and Bank Details",
                'rowOptions' => ['class' => 'info']
            ],
            'phone_number',
			'email_address',
			'bank_name',
			'bank_account_number',
			'branch_name',
        ],
    ]) ?>

</div>
    </div>
</div>
