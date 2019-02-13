<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_request')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'retry')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'response_message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'cancelled_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cancelled_by')->textInput() ?>

    <?= $form->field($model, 'cancelled_date')->textInput() ?>

    <?= $form->field($model, 'cancelled_response_status')->textInput() ?>

    <?= $form->field($model, 'cancelled_response_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
