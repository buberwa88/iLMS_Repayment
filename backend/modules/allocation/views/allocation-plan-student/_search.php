<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanStudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_plan_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'needness_amount') ?>

    <?= $form->field($model, 'allocated_amount') ?>

    <?= $form->field($model, 'study_year') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
