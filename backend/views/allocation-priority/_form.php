<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPriority */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-priority-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'source_table')->textInput() ?>

    <?= $form->field($model, 'source_table_field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field_value')->textInput() ?>

    <?= $form->field($model, 'priority_order')->textInput() ?>

    <?= $form->field($model, 'base_line')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
