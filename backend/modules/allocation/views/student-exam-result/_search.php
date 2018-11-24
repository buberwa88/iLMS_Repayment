<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentExamResultSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-exam-result-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'student_exam_result_id') ?>

    <?= $form->field($model, 'registration_number') ?>

    <?= $form->field($model, 'f4indexno') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?php // echo $form->field($model, 'study_year') ?>

    <?php // echo $form->field($model, 'exam_status_id') ?>

    <?php // echo $form->field($model, 'semester') ?>

    <?php // echo $form->field($model, 'confirmed') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
