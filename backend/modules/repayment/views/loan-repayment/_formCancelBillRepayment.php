<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['value'=>$model->bill_number,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amount')->textInput(['value'=>$model->amount,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'cancel_reason')->textarea(['rows' => '3']) ?>

  

    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
	if($identity=='REPAYMENT'){
		if($model->employer_id > 0){
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/loan-repayment/loan-bills-employer'], ['class' => 'btn btn-warning']);
		 }else if($model->applicant_id > 0){
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/loan-repayment/loan-bills-beneficiary'], ['class' => 'btn btn-warning']);	 
		 }
	}else if($identity=='EPNT'){
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employer/employer-penalty-bill'], ['class' => 'btn btn-warning']);		
	}
ActiveForm::end();
?>
</div>
