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
          <label class="control-label" for="employee_id">Check Number:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_id')->label(false)->textInput(['maxlength' => true]) ?>
   </div>
        </div>
            </div>           
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_mobile_phone_no">Mobile Phone Number:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
        <?php //echo "$employees_phone_number"." TELESPHORY"; ?>
    <?= $form->field($model, 'employee_mobile_phone_no')->label(false)->textInput(['maxlength' => true,'value'=>$employees_phone_number]) ?>
   </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_current_nameifchanged">Current Name:</label>
        </div>               
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_current_nameifchanged')->label(false)->textInput(['maxlength' => true,'value'=>$employee_current_name]) ?>
   </div>
            <i><strong>NOTE: Current Name to be filled if name changed.</strong></i>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employee_NIN">NIN:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employee_NIN')->label(false)->textInput(['maxlength' => true,'value'=>$employee_NIN]) ?>
   </div>
            <i><strong>NOTE: This is the National Identification Number.</strong></i>
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
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employment_status">Employee Status:</label>
        </div>               
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'employment_status')->label(false)->dropDownList([ 'ONPOST' => 'ONPOST', 'TERMINATED' => 'TERMINATED', 'RETIRED' => 'RETIRED', 'DECEASED' => 'DECEASED', ], ['prompt' => '']) ?>
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
