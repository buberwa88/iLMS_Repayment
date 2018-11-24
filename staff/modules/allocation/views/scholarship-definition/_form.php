<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipDefinition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scholarship-definition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'scholarship_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'scholarship_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sponsor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_of_study')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'closed_date')->textInput() ?>

    <?= $form->field($model, 'is_full_scholarship')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
