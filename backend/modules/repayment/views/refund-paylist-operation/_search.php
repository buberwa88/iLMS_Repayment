<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistOperationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-paylist-operation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_application_operation_id') ?>

    <?= $form->field($model, 'refund_paylist_id') ?>

    <?= $form->field($model, 'refund_internal_operational_id') ?>

    <?= $form->field($model, 'previous_internal_operational_id') ?>

    <?= $form->field($model, 'access_role_master') ?>

    <?php // echo $form->field($model, 'access_role_child') ?>

    <?php // echo $form->field($model, 'status') ?>

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

    <?php // echo $form->field($model, 'general_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
