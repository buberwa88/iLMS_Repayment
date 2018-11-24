<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanStudentLoanItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-student-loan-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_plan_id')->textInput() ?>

    <?= $form->field($model, 'application_id')->textInput() ?>

    <?= $form->field($model, 'loan_item_id')->textInput() ?>

    <?= $form->field($model, 'priority_order')->textInput() ?>

    <?= $form->field($model, 'rate_type')->textInput() ?>

    <?= $form->field($model, 'unit_amount')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'loan_award_percentage')->textInput() ?>

    <?= $form->field($model, 'total_amount_awarded')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
