<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkSpecialGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-framework-special-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_framework_id')->textInput() ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'applicant_source_table')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'applicant_souce_column')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'applicant_source_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operator')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
