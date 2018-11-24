<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionStudent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admission-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'admission_batch_id')->textInput() ?>

    <?= $form->field($model, 'f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'programme_id')->textInput() ?>

    <?= $form->field($model, 'has_transfered')->textInput() ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f6indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'points')->textInput() ?>

    <?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'course_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'institution_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'course_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entry')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'study_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'admission_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'admission_status')->textInput() ?>

    <?= $form->field($model, 'transfer_date')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
