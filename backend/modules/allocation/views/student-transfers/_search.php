<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentTransfersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-transfers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'student_transfer_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'programme_from') ?>

    <?= $form->field($model, 'programme_to') ?>

    <?= $form->field($model, 'date_initiated') ?>

    <?php // echo $form->field($model, 'date_completed') ?>

    <?php // echo $form->field($model, 'effetive_study_year') ?>

    <?php // echo $form->field($model, 'admitted_student_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
