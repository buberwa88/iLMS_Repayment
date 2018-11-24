<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkSpecialGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-framework-special-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'special_group_id') ?>

    <?= $form->field($model, 'allocation_framework_id') ?>

    <?= $form->field($model, 'group_name') ?>

    <?= $form->field($model, 'applicant_source_table') ?>

    <?= $form->field($model, 'applicant_souce_column') ?>

    <?php // echo $form->field($model, 'applicant_source_value') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
