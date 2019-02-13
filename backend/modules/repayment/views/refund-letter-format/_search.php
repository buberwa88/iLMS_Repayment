<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-refund-letter-format-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_letter_format_id')->textInput(['placeholder' => 'Refund Letter Format']) ?>

    <?= $form->field($model, 'letter_name')->textInput(['maxlength' => true, 'placeholder' => 'Letter Name']) ?>

    <?= $form->field($model, 'header')->textInput(['maxlength' => true, 'placeholder' => 'Header']) ?>

    <?= $form->field($model, 'footer')->textInput(['maxlength' => true, 'placeholder' => 'Footer']) ?>

    <?= $form->field($model, 'letter_heading')->textInput(['maxlength' => true, 'placeholder' => 'Letter Heading']) ?>

    <?php /* echo $form->field($model, 'letter_body')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'is_active')->textInput(['placeholder' => 'Is Active']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
