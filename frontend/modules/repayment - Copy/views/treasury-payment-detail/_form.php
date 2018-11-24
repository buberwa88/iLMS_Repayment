<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPaymentDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="treasury-payment-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'treasury_payment_id')->textInput() ?>

    <?= $form->field($model, 'employer_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
