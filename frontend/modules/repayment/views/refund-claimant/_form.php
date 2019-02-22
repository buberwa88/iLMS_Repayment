<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-claimant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'applicant_id')->textInput() ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f4_completion_year')->textInput() ?>

    <?= $form->field($model, 'necta_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'necta_middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'necta_surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'necta_sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'necta_details_confirmed')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
