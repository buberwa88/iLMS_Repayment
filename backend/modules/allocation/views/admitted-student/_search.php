<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmittedStudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admitted-student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'admitted_student_id') ?>

    <?= $form->field($model, 'admission_batch_id') ?>

    <?= $form->field($model, 'f4indexno') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?= $form->field($model, 'has_transfered') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
