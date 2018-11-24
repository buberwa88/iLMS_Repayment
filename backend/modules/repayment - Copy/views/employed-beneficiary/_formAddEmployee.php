<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employed-beneficiary-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_check_number">Check Number:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_check_number')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_f4indexno">Form Four Index No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_f4indexno')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_firstname">Full Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_firstname')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_mobile_phone_no">Mobile Phone Number:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_mobile_phone_no')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_current_nameifchanged">Current Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_current_nameifchanged')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_NIN">NIN:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_NIN')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="basic_salary">Basic Salary(TZS):</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'basic_salary')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>
       </div>
    <div class="space10"></div>
     <div class="col-sm-12">
    <div class="form-group button-wrapper">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>
     </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
<div class="space10"></div>
