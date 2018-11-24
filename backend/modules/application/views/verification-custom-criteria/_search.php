<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCustomCriteriaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-custom-criteria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'verification_custom_criteria_id') ?>

    <?= $form->field($model, 'verification_framework_id') ?>

    <?= $form->field($model, 'criteria_name') ?>

    <?= $form->field($model, 'applicant_source_table') ?>

    <?= $form->field($model, 'applicant_souce_column') ?>

    <?php // echo $form->field($model, 'applicant_source_value') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
