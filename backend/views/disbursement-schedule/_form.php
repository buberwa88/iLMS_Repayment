<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursement-schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'operator_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
