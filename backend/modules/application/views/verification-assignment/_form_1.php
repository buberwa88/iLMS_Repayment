<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'assignee')->textInput() ?>

    <?= $form->field($model, 'study_level')->textInput() ?>

    <?= $form->field($model, 'total_applications')->textInput() ?>

    <?= $form->field($model, 'assigned_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
