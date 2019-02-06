<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-claimant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_claimant_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'claimant_user_id') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'middlename') ?>

    <?php // echo $form->field($model, 'surname') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'f4indexno') ?>

    <?php // echo $form->field($model, 'completion_year') ?>

    <?php // echo $form->field($model, 'old_firstname') ?>

    <?php // echo $form->field($model, 'old_middlename') ?>

    <?php // echo $form->field($model, 'old_surname') ?>

    <?php // echo $form->field($model, 'old_sex') ?>

    <?php // echo $form->field($model, 'old_details_confirmed') ?>

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
