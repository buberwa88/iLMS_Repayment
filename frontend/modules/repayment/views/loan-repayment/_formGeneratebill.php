<script type="text/javascript">
    function ShowHideDiv() {
        var dateofbill = document.getElementById("dateofbill_id");
		var dateofbill_value= dateofbill.value;
                if(dateofbill_value !==''){
                          document.getElementById('billDate-details').style.display = 'block';
                                   }
                                else{
                          document.getElementById('billDate-details').style.display = 'none';
                          						  
                                }
    }
	function ShowHideDiv2() {
        var dateofbill2 = document.getElementById("dateofbill_id2");
		var dateofbill2_value= dateofbill2.value;
                if(dateofbill2_value !==''){
                          document.getElementById('billDate2-details').style.display = 'block';
                                   }
                                else{
                          document.getElementById('billDate2-details').style.display = 'none';
                          						  
                                }
    }
	function checkBillStatus() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
	function checkBillStatus2() {
      //form-group field-user-verifycode
   document.getElementById("hiddenData2").style.display = "none";
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

<?php 
$loggedin = Yii::$app->user->identity->user_id;
$employer2 = \frontend\modules\repayment\models\EmployerSearch::getEmployer($loggedin);
$employerID = $employer2->employer_id;
$employerDetails=\frontend\modules\repayment\models\Employer::findOne(['employer_id'=>$employerID]);
//check if atleast has one beneficiary under own salary source
$totalBeneficiary=\frontend\modules\repayment\models\EmployedBeneficiary::find()->where(['employment_status'=>'ONPOST','verification_status'=>'1','employer_id'=>$employerID,'salary_source'=>[2,3]])->count();
?>
<?php
if ($employerDetails->salary_source==3) {
	if ($totalBeneficiary > 0) {
 ?>
<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'payment_date')->label('Date of Bill')->widget(DatePicker::classname(), [
           'name' => 'payment_date', 
           'value' => date('Y-m-d'),
    'options' => [
	              'placeholder'=>'yyyy-mm-dd',
	              'todayHighlight' => true,
				  'id' => 'dateofbill_id',
                  'onchange' => 'ShowHideDiv()',
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
    ?>

 <?= $form->field($model, 'salarySource')->label('Note: Salary Source of this bill is from Own Source')->hiddenInput(['value'=>2,'readOnly'=>'readOnly']) ?> 
        
		<div class="block" id="hiddenData2">
		<div id="billDate-details" style='display:none'>
		<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Generate Bill' : 'Generate Bill', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','onclick'=>'return  checkBillStatus2()']) ?>
    </div>
	</div>
	</div>

    <?php ActiveForm::end(); ?>
	<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</p>
</div>
<?php }}else{ ?>
<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'payment_date')->label('Date of Bill')->widget(DatePicker::classname(), [
           'name' => 'payment_date', 
           'value' => date('Y-m-d'),
    'options' => [
	              'placeholder'=>'Select Date of Bill',
	              'todayHighlight' => true,
				  'id' => 'dateofbill_id2',
                  'onchange' => 'ShowHideDiv2()',
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
    ?>
 <?= $form->field($model, 'salarySource')->label(false)->hiddenInput(['value'=>10,'readOnly'=>'readOnly']) ?>
      <div class="block" id="hidden">
		<div id="billDate2-details" style='display:none'>
		<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Generate Bill' : 'Generate Bill', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','onclick'=>'return  checkBillStatus()']) ?>
     </div>
	</div>
	</div>

    <?php ActiveForm::end(); ?>
<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</p>
</div>
<?php } ?>
	
