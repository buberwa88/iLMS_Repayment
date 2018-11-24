<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgrammeLoanItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scholarship-programme-loan-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'scholarships_id')->textInput() ?>

    <?= $form->field($model, 'programme_id')->textInput() ?>

    <?= $form->field($model, 'loan_item_id')->textInput() ?>

    <?= $form->field($model, 'rate_type')->textInput() ?>

    <?= $form->field($model, 'unit_amount')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
