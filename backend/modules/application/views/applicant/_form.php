<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Applicant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'NID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f6indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mailing_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth')->textInput() ?>

    <?= $form->field($model, 'place_of_birth')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loan_repayment_bill_requested')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
