<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationAssignmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-assignment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'verification_assignment_id') ?>

    <?= $form->field($model, 'assignee') ?>

    <?= $form->field($model, 'study_level') ?>

    <?= $form->field($model, 'total_applications') ?>

    <?= $form->field($model, 'assigned_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
