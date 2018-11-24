<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">
<p>
        <?= Html::a('Click Here to Generate Bill(s) In Bulk', ['loan-repayment/generate-billbulk-treasury'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=Html::beginForm(['loan-repayment/update-selected-billtreasury'],'post');?>         
    <?= GridView::widget([
        'dataProvider' => $dataProviderBillsEmp,
        'filterModel' => $searchBillsEmp,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute'=>'employer_name',
                'label'=>'Employer',            
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->employer->employer_name;                    
            },
            ],
			[
                'attribute'=>'date_bill_generated',
                'label'=>'Date Generated',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m-d",strtotime($model->date_bill_generated));                    
            },
            ],
            [
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],             
            ['class' => 'yii\grid\CheckboxColumn'],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
    
	<div class="text-right">
	<?=Html::submitButton('Generate Bill', ['class' => 'btn btn-success',]);?>	
    </div>

   <?= Html::endForm();?>

</div>
