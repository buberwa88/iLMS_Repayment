<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Refund */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'claim_category')->textInput() ?>

    <?= $form->field($model, 'employer_id')->textInput() ?>

    <?= $form->field($model, 'applicant_id')->textInput() ?>

    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claimant_letter_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claimant_letter_received_date')->textInput() ?>

    <?= $form->field($model, 'claim_decision_date')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claim_status')->textInput() ?>

    <?= $form->field($model, 'claim_file_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
