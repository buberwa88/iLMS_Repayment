<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanLoanItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-loan-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_plan_id') ?>

    <?= $form->field($model, 'loan_item_id') ?>

    <?= $form->field($model, 'priority_order') ?>

    <?= $form->field($model, 'rate_type') ?>

    <?= $form->field($model, 'unit_amount') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'loan_award_percentage') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
