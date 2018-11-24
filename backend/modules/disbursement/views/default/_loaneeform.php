<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Applicant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-form">
 
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bank_account_number')->textInput() ?>

    <?= $form->field($model, 'registration_number')->textInput(['maxlength' => true]) ?>
 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
