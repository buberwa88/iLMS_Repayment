<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundApplicationOperationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-application-operation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_application_operation_id') ?>

    <?= $form->field($model, 'refund_application_id') ?>

    <?= $form->field($model, 'refund_internal_operational_id') ?>

    <?= $form->field($model, 'access_role') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'refund_status_reason_setting_id') ?>

    <?php // echo $form->field($model, 'narration') ?>

    <?php // echo $form->field($model, 'assignee') ?>

    <?php // echo $form->field($model, 'assigned_at') ?>

    <?php // echo $form->field($model, 'assigned_by') ?>

    <?php // echo $form->field($model, 'last_verified_by') ?>

    <?php // echo $form->field($model, 'is_current_stage') ?>

    <?php // echo $form->field($model, 'date_verified') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
