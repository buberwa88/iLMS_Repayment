<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'loan_allocation_history_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'study_level') ?>

    <?= $form->field($model, 'place_of_study') ?>

    <?= $form->field($model, 'allocation_framework_id') ?>

    <?php // echo $form->field($model, 'student_type') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'reviewed_at') ?>

    <?php // echo $form->field($model, 'reviewed_by') ?>

    <?php // echo $form->field($model, 'approved_at') ?>

    <?php // echo $form->field($model, 'approved_by') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
