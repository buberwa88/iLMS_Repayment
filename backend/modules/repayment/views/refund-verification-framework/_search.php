<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFrameworkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-refund-verification-framework-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_verification_framework_id')->textInput(['placeholder' => 'Refund Verification Framework']) ?>

    <?= $form->field($model, 'verification_framework_title')->textInput(['maxlength' => true, 'placeholder' => 'Verification Framework Title']) ?>

    <?= $form->field($model, 'verification_framework_desc')->textInput(['maxlength' => true, 'placeholder' => 'Verification Framework Desc']) ?>

    <?= $form->field($model, 'verification_framework_stage')->textInput(['maxlength' => true, 'placeholder' => 'Verification Framework Stage']) ?>

    <?= $form->field($model, 'support_document')->textInput(['maxlength' => true, 'placeholder' => 'Support Document']) ?>

    <?php /* echo $form->field($model, 'confirmed_by')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\User::find()->orderBy('user_id')->asArray()->all(), 'user_id', 'username'),
        'options' => ['placeholder' => 'Choose User'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'confirmed_at')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Confirmed At',
                'autoclose' => true,
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'is_active')->textInput(['placeholder' => 'Is Active']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
