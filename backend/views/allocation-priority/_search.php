<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPrioritySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-priority-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_priority_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'source_table') ?>

    <?= $form->field($model, 'source_table_field') ?>

    <?= $form->field($model, 'field_value') ?>

    <?php // echo $form->field($model, 'priority_order') ?>

    <?php // echo $form->field($model, 'base_line') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
