<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => [
            //'user_id',
			[
					 'label'=>'Employer',
                        'value' =>$model->employer->employer_name,                        
            ],
			[
                     'attribute' => 'bill_number',
					 'label'=>'Bill Number',
                        'value' =>$model->bill_number,                        
                    ],
			[
                     'attribute' => 'control_number',
					 'label'=>'Control Number',
                        'value' =>$model->control_number,                        
            ],
			[
            'label'  => 'Total Amount',
            'value'  => call_user_func(function ($data) {
			return number_format(\frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalAmountUnderBillPrepaid($data->employer_id,$data->bill_number),2);
            }, $model),            
        ],
		[
            'label'  => 'Beneficiaries',
            'value'  => call_user_func(function ($data) {
			return \frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalBeneficiariesUnderPrePaidheslb($data->employer_id,$data->bill_number);
            }, $model),            
        ],
		[
            'label'  => 'From Month',
            'value'  => call_user_func(function ($data) {
			return date("Y-m",strtotime(frontend\modules\repayment\models\LoanRepaymentPrepaid::getstartPrePaidheslb($data->employer_id,$data->bill_number)));
            }, $model),            
        ],
		[
            'label'  => 'To Month',
            'value'  => call_user_func(function ($data) {
			return date("Y-m",strtotime(frontend\modules\repayment\models\LoanRepaymentPrepaid::getEndPrePaidheslb($data->employer_id,$data->bill_number)));
            }, $model),            
        ],
		[
                     'label' => 'Date Created',
                        'value' =>$model->created_at,                        
                    ],
			
            
        ],
    ]) ?>
</div>
    </div>
</div>
