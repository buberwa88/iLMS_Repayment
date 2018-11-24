<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'loan_repayment_id')->textInput() ?>

    <?= $form->field($model, 'applicant_id')->textInput() ?>

    <?= $form->field($model, 'loan_repayment_item_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'loan_summary_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
