<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="confirm-details-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="col-sm-8">
	<div class="profile-user-info profile-user-info-striped">
	<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">First Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'firstname')->label(false)->textInput(['value'=>$applicantDetail->user->firstname,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Middle Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'middlename')->label(false)->textInput(['value'=>$applicantDetail->user->middlename,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Last Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'surname')->label(false)->textInput(['value'=>$applicantDetail->user->surname,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Date of Birth:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
	<?= $form->field($model, 'dateofbirth')->label(false)->textInput(['value'=>$applicantDetail->date_of_birth,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Region(Place of birth):</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'region')->label(false)->textInput(['value'=>$applicantDetail->placeOfBirth->district->region->region_name,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">District(Place of birth):</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'district')->label(false)->textInput(['value'=>$applicantDetail->placeOfBirth->district->district_name,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Ward(Place of birth):</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'placeofbirth')->label(false)->textInput(['value'=>$applicantDetail->placeOfBirth->ward_name,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Form IV Index Number:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
	<?= $form->field($model, 'f4indexno')->label(false)->textInput(['value'=>$applicantDetail->f4indexno,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Learning Institution:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'learningInstitution')->label(false)->textInput(['value'=>$applicantLearningInstitution->programme->learningInstitution->institution_name,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Programme:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
	<?= $form->field($model, 'programme_name')->label(false)->textInput(['value'=>$applicantLearningInstitution->programme->programme_name,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Current Email:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
	<?= $form->field($model, 'beneficiaryCurrentEmail')->label(false)->textInput(['value'=>$email,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
    </div>
	<div class="space10"></div>
     <div class="col-sm-12">
    <div class="form-group button-wrapper">
 <?= Html::a('Click Here to Confirm', ['confirmed-details-beneficiary', 'id' => $applicantDetail->user_id,'email'=>$email], ['class' => 'btn btn-primary']) ?>
 <?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/login'], ['class' => 'btn btn-warning'])?>
    </div>
     </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
