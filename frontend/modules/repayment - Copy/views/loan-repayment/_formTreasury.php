<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

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

    <?= $form->field($model, 'bill_number')->textInput(['value'=>$model->bill_number,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amountx')->textInput(['value'=>number_format($model->amount,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalBeneficiaries')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?>
	<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php //echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['treasury-payment/index'], ['class' => 'btn btn-warning']); 
       ?>
       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index-treasury-bill'], ['class' => 'btn btn-warning']); ?>         
    </div>

    <?php ActiveForm::end(); ?>

</div>
