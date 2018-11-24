<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionStudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admission-student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'admission_student_id') ?>

    <?= $form->field($model, 'admission_batch_id') ?>

    <?= $form->field($model, 'f4indexno') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?= $form->field($model, 'has_transfered') ?>

    <?php // echo $form->field($model, 'firstname') ?>

    <?php // echo $form->field($model, 'middlename') ?>

    <?php // echo $form->field($model, 'surname') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'f6indexno') ?>

    <?php // echo $form->field($model, 'points') ?>

    <?php // echo $form->field($model, 'course_code') ?>

    <?php // echo $form->field($model, 'course_description') ?>

    <?php // echo $form->field($model, 'institution_code') ?>

    <?php // echo $form->field($model, 'course_status') ?>

    <?php // echo $form->field($model, 'entry') ?>

    <?php // echo $form->field($model, 'study_year') ?>

    <?php // echo $form->field($model, 'admission_no') ?>

    <?php // echo $form->field($model, 'academic_year_id') ?>

    <?php // echo $form->field($model, 'admission_status') ?>

    <?php // echo $form->field($model, 'transfer_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
