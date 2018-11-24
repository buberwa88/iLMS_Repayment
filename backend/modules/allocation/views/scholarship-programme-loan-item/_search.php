<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgrammeLoanItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scholarship-programme-loan-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'scholarships_id') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?= $form->field($model, 'loan_item_id') ?>

    <?php // echo $form->field($model, 'rate_type') ?>

    <?php // echo $form->field($model, 'unit_amount') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
