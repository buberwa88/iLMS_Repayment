<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Appeal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appeal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'application_id')->textInput() ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_paid')->textInput() ?>

    <?= $form->field($model, 'pay_phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_bill_generated')->textInput() ?>

    <?= $form->field($model, 'date_control_received')->textInput() ?>

    <?= $form->field($model, 'date_receipt_received')->textInput() ?>

    <?= $form->field($model, 'current_study_year')->textInput() ?>

    <?= $form->field($model, 'verification_status')->textInput() ?>

    <?= $form->field($model, 'needness')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
