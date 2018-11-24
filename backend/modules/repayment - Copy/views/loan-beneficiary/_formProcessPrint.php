<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-beneficiary-form">

    <?php $form = ActiveForm::begin(['action' => ['print-operations'],'options' => ['method' => 'post','target'=>'_blank']]); ?>
	<?php
    $a= ['1' => 'Print Customer Statement', '2' => 'Print Repayment Details'];
    echo $form->field($model, 'operation')->label(false)->dropDownList($a,['prompt'=>'Choose an operation']);
    ?>
	<?= $form->field($model, 'applicant_id')->label(false)->hiddenInput(['value'=>$applicant_id,'readOnly'=>'readOnly']) ?>
    
     <div class="col-sm-12">
    <div class="form-group button-wrapper">
        <?= Html::submitButton($model->isNewRecord ? 'Process' : 'Process', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
     </div>
    <?php ActiveForm::end(); ?>

</div>