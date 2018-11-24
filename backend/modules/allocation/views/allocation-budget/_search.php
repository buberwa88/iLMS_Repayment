<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationBudgetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-budget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_budget_id') ?>

    <?= $form->field($model, 'budget_amount') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'applicant_category') ?>

    <?= $form->field($model, 'study_level') ?>

    <?php // echo $form->field($model, 'place_of_study') ?>

    <?php // echo $form->field($model, 'budget_scope') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
