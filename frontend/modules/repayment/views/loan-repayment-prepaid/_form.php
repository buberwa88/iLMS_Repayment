<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentPrepaid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-prepaid-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employer_id')->textInput() ?>

    <?= $form->field($model, 'applicant_id')->textInput() ?>

    <?= $form->field($model, 'loan_summary_id')->textInput() ?>

    <?= $form->field($model, 'monthly_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_bill_generated')->textInput() ?>

    <?= $form->field($model, 'date_control_received')->textInput() ?>

    <?= $form->field($model, 'receipt_date')->textInput() ?>

    <?= $form->field($model, 'date_receipt_received')->textInput() ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <?= $form->field($model, 'cancelled_by')->textInput() ?>

    <?= $form->field($model, 'cancelled_at')->textInput() ?>

    <?= $form->field($model, 'cancel_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gepg_cancel_request_status')->textInput() ?>

    <?= $form->field($model, 'monthly_deduction_status')->textInput() ?>

    <?= $form->field($model, 'date_deducted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
