<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
//use backend\modules\repayment\models\LoanSummaryDetailSearch;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
$this->title = 'Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
<div class="loan-summary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('viewPaymentItemsDetails',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
            [
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
							if($model->applicant_id !=''){
                            return $model->applicant->user->firstname;
							}else{
							return $model->first_name;	
							}
                        },
            ],
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
							if($model->applicant_id !=''){
                            return $model->applicant->user->middlename;
							}else{
							return $model->middle_name;	
							}
                        },
            ],
			
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
							if($model->applicant_id !=''){
                            return $model->applicant->user->surname;
							}else{
							return $model->last_name;		
							}
                        },
            ],
			[
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        'value' => function ($model) {
							if($model->applicant_id !=''){
                            return $model->applicant->f4indexno;
							}else{
							return '';	
							}
                        },
            ],
			/*
            [
            'attribute'=>'amount',
            'format'=>'raw', 
            'hAlign' => 'right',			
            'value' =>$model->amount,
            'format'=>['decimal',2],
            ],
*/			
            [
            'attribute'=>'amount',
			'hAlign' => 'right',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 //return $model->getAmountRequiredForPaymentIndividualLoanee($model->applicant_id,$model->loan_repayment_id,$loan_given_to);
				 if($model->applicant_id !=''){
				 return $model->getAmountPaidByIndividualLoaneeUnderLoanRepayment($model->applicant_id,$model->loan_repayment_id);
				 }else{
				 return $model->amount;	 
				 }
            },
            'format'=>['decimal',2],
        ],			
        ],
    ]); ?>
</div>
    </div>
</div>
