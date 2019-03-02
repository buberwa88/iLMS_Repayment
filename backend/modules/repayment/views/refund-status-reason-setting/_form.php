<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$verificationStatus = \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatusGeneral();

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundStatusReasonSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-status-reason-setting-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=
    $form->field($model, 'status')->widget(\kartik\widgets\Select2::classname(), [
        'data' =>$verificationStatus,//$model->getStatusTypes(),// [1 => "Valid", 2 => "Invalid", 3 => "Waiting", 4 => "Incomplete"],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true, 'placeholder' => 'Reason']) ?>

<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
    ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
