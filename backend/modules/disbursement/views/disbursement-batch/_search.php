<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementBatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursement-batch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'disbursement_batch_id') ?>

    <?= $form->field($model, 'allocation_batch_id') ?>

    <?= $form->field($model, 'learning_institution_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'instalment_definition_id') ?>

    <?php // echo $form->field($model, 'batch_number') ?>

    <?php // echo $form->field($model, 'batch_desc') ?>

    <?php // echo $form->field($model, 'instalment_type') ?>

    <?php // echo $form->field($model, 'is_approved') ?>

    <?php // echo $form->field($model, 'approval_comment') ?>

    <?php // echo $form->field($model, 'institution_payment_request_id') ?>

    <?php // echo $form->field($model, 'payment_voucher_number') ?>

    <?php // echo $form->field($model, 'cheque_number') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
