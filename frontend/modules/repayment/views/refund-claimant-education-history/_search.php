<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-claimant-education-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_education_history_id') ?>

    <?= $form->field($model, 'refund_application_id') ?>

    <?= $form->field($model, 'program_id') ?>

    <?= $form->field($model, 'institution_id') ?>

    <?= $form->field($model, 'entry_year') ?>

    <?php // echo $form->field($model, 'completion_year') ?>

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
