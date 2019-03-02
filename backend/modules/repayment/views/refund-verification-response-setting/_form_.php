<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$verificationStatus = \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatusGeneral();

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationResponseSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-verification-response-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'verification_status')->textInput() ?>

    <?= $form->field($model, 'response_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_role_master')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_role_child')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
