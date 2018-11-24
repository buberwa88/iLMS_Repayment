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

    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'payment_date')->label('Date of Bill')->widget(DatePicker::classname(), [
           'name' => 'payment_date', 
           'value' => date('Y-m-d'),
    'options' => [
	              'placeholder'=>'Select Date of Bill',
	              'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
    ?>
    
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
                'attribute'=>'payment_date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
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
		<?= Html::submitButton($model->isNewRecord ? 'Generate Bill' : 'Generate Bill', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
