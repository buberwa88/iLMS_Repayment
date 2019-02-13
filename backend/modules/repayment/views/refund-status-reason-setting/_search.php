<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundStatusReasonSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-refund-status-reason-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_status_reason_setting_id')->textInput(['placeholder' => 'Refund Status Reason Setting']) ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true, 'placeholder' => 'Reason']) ?>

    <?= $form->field($model, 'category')->textInput(['placeholder' => 'Category']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
