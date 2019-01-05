<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LawsonMonthlyDeduction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lawson-monthly-deduction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ActualBalanceAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CheckDate')->textInput() ?>

    <?= $form->field($model, 'CheckNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DateHired')->textInput() ?>

    <?= $form->field($model, 'DeductionAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DeductionCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DeductionDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DeptName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NationalId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'VoteName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Votecode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
