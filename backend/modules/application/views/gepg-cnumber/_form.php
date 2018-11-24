<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgCnumber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-cnumber-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'response_message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'retrieved')->textInput() ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trsxsts')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trans_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_received')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
