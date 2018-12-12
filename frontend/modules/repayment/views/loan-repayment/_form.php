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

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['value'=>$model->bill_number,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amountx')->textInput(['value'=>number_format($model->amount,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalEmployees')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?>
	<div class="block" id="hidden">
	<div class="text-right">
            <?php if($employerSalarySource==1 OR $employerSalarySource==0){ ?>
		<?= Html::submitButton($model->isNewRecord ? 'Click here to confirm Bill' : 'Click here to confirm Bill', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','onclick'=>'return  checkBillStatus()']) ?>           

       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['cancel-bill-employer','id'=>$model->loan_repayment_id], ['class' => 'btn btn-warning']);
	   ?>
	   <?php } ?>
	   </div> 
    </div>

    <?php ActiveForm::end(); ?>
<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</p>
</div>
