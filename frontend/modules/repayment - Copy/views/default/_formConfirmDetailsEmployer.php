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
          <label class="control-label" for="email">Office Email Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'email_address')->label(false)->textInput(['value'=>$employerID->email_address,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>
			<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Contact Person Email Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'email_address2')->label(false)->textInput(['value'=>$employerID->employer_code,'readOnly'=>'readOnly']) ?>
	</div>
        </div>
            </div>			
    </div>
	<div class="space10"></div>
     <div class="col-sm-12">
    <div class="form-group button-wrapper">
 <?= Html::a('Click Here to Confirm', ['confirmed-send-email', 'user_id' => $applicantDetail->user_id], ['class' => 'btn btn-primary']) ?>
 <?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/login'], ['class' => 'btn btn-warning'])?>
    </div>
     </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
