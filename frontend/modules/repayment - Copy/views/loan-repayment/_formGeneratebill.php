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

 <?= $form->field($model, 'salarySource')->label('Note: Salary Source of this bill is from Own Source')->hiddenInput(['value'=>2,'readOnly'=>'readOnly']) ?>

	<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Generate Bill' : 'Generate Bill', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

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
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
    ?>
 <?= $form->field($model, 'salarySource')->label(false)->hiddenInput(['value'=>10,'readOnly'=>'readOnly']) ?>

	<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Generate Bill' : 'Generate Bill', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php } ?>