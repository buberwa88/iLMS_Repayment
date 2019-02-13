<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundApplicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-application-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_application_id') ?>

    <?= $form->field($model, 'refund_claimant_id') ?>

    <?= $form->field($model, 'application_number') ?>

    <?= $form->field($model, 'refund_claimant_amount') ?>

    <?= $form->field($model, 'finaccial_year_id') ?>

    <?php // echo $form->field($model, 'academic_year_id') ?>

    <?php // echo $form->field($model, 'trustee_firstname') ?>

    <?php // echo $form->field($model, 'trustee_midlename') ?>

    <?php // echo $form->field($model, 'trustee_surname') ?>

    <?php // echo $form->field($model, 'trustee_sex') ?>

    <?php // echo $form->field($model, 'current_status') ?>

    <?php // echo $form->field($model, 'refund_verification_framework_id') ?>

    <?php // echo $form->field($model, 'check_number') ?>

    <?php // echo $form->field($model, 'bank_account_number') ?>

    <?php // echo $form->field($model, 'bank_account_name') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'refund_type_id') ?>

    <?php // echo $form->field($model, 'liquidation_letter_number') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'submitted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
