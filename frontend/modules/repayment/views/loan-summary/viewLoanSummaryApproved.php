<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
//use backend\modules\repayment\models\LoanSummaryDetailSearch;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */

$this->title = "Loan Summary";
//$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//$dataProvider=new LoanSummaryDetailSearch();
?>
<div class="loan-summary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		/*
            [
                'attribute'=>'employer_id',
                'label'=>'Employer',
                'value'=>call_user_func(function ($data) {
                    if($data->employer_id==''){
                return $data->applicant->user->firstname;
                    }else{  
                return $data->employer->employer_name;        
                    }
            }, $model),
            ],
			*/
            [
                'attribute'=>'amount',
                'label'=>'Total Amount',
                'value'=>$model->amount,
                'format'=>['decimal',2],
            ],
            [
                'attribute'=>'paid',
                'label'=>'Paid',
                'value'=>call_user_func(function ($data) {
					$date=date("Y-m-d");
                    //return $data->getTotalPaidunderBill($data->loan_summary_id,$date);
					return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBill($data->loan_summary_id,$date);
            }, $model),
                'format'=>['decimal',2],
            ],
            [
                'attribute'=>'VRF',
                'label'=>'VRF Accrued Daily',
                'value'=>call_user_func(function ($data) {
                    if($data->vrf_accumulated==''){
                return '';    
                }else{
                 return $data->vrf_accumulated;
                }
            }, $model),
                'format'=>['decimal',2],
            ],
            [
                'attribute'=>'outstanding',
                'label'=>'Outstanding(TZS)',
                'value'=>call_user_func(function ($data) {
					$date=date("Y-m-d");
                    return   \frontend\modules\repayment\models\LoanSummaryDetail::getOustandingAmountUnderLoanSummary($data->loan_summary_id,$date);
            }, $model),
                'format'=>['decimal',2],
            ], 
            [
                'attribute'=>'status',
                'label'=>'Loan Status',
                'value'=>call_user_func(function ($data) {
                    if($data->status==0){
                return 'Posted';
                    }else if($data->status==1){
                return "On Payment";        
                    }else if($data->status==2){
                return "Paid";        
                    }else if($data->status==3){
                return "Cancelled";        
                    }else if($data->status==4){
                return "Ceased";        
                    }
            }, $model),
            ],
			[
                        'attribute' => 'created_at',
                        //'label'=>'VRF Accrued Daily',
                        'value' => call_user_func(function ($data) {
                                    if ($data->created_at == '') {
                                        return '';
                                    } else {
                                        return date("d-m-Y H:i:s", strtotime($data->created_at));
                                    }
                                }, $model),
            ],
            [
                'attribute'=>'vrf_last_date_calculated',
                //'label'=>'VRF Accrued Daily',
                'value'=>call_user_func(function ($data) {
                    if($data->vrf_last_date_calculated==''){
                return '';    
                }else{
				 return date("d-m-Y", strtotime($data->vrf_last_date_calculated));
                }
            }, $model),                
            ],
            [
                'attribute'=>'description',
                'label'=>'Note',
                'value'=>$model->description,
            ],        
        ],
    ]) ?>            
</div>
    </div>
</div>
