<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'allocation_plan_id') ?>

    <?= $form->field($model, 'allocation_plan_title') ?>

    <?= $form->field($model, 'allocation_plan_desc') ?>

    <?= $form->field($model, 'allocation_plan_number') ?>

    <?php // echo $form->field($model, 'allocation_plan_stage') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'allocation_framework_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
