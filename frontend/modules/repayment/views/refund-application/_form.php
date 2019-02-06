<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'refund_claimant_id')->textInput() ?>

    <?= $form->field($model, 'application_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_claimant_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'finaccial_year_id')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'trustee_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trustee_midlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trustee_surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trustee_sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'current_status')->textInput() ?>

    <?= $form->field($model, 'refund_verification_framework_id')->textInput() ?>

    <?= $form->field($model, 'check_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_id')->textInput() ?>

    <?= $form->field($model, 'refund_type_id')->textInput() ?>

    <?= $form->field($model, 'liquidation_letter_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'submitted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
