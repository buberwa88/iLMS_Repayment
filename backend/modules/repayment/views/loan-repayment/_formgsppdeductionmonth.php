<script type="text/javascript">
	function checkBillStatus() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">
<div class="block" id="hidden">
    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'payment_date')->label('Deduction Month')->widget(DatePicker::classname(), [
           'name' => 'payment_date', 
           'value' => date('Y-m-d'),
    'options' => [
	              'placeholder'=>'Select Date of Bill',
	              'todayHighlight' => true,
				  'id' => 'dateofbill_id',                  
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>	
	<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Request' : 'Request', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','onclick'=>'return  checkBillStatus()']) ?>           

       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['requestgspp-monthdeduction'], ['class' => 'btn btn-warning']);
	   ?>
	   </div> 
    

    <?php ActiveForm::end(); ?>
	</div>
	</div>

<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</p>
