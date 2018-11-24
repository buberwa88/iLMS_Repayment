<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'receipt_number') ?>

    <?php // echo $form->field($model, 'amount_paid') ?>

    <?php // echo $form->field($model, 'pay_phone_number') ?>

    <?php // echo $form->field($model, 'date_bill_generated') ?>

    <?php // echo $form->field($model, 'date_control_received') ?>

    <?php // echo $form->field($model, 'date_receipt_received') ?>

    <?php // echo $form->field($model, 'programme_id') ?>

    <?php // echo $form->field($model, 'application_study_year') ?>

    <?php // echo $form->field($model, 'current_study_year') ?>

    <?php // echo $form->field($model, 'applicant_category_id') ?>

    <?php // echo $form->field($model, 'bank_account_number') ?>

    <?php // echo $form->field($model, 'bank_account_name') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'bank_branch_name') ?>

    <?php // echo $form->field($model, 'submitted') ?>

    <?php // echo $form->field($model, 'verification_status') ?>

    <?php // echo $form->field($model, 'needness') ?>

    <?php // echo $form->field($model, 'allocation_status') ?>

    <?php // echo $form->field($model, 'allocation_comment') ?>

    <?php // echo $form->field($model, 'student_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
