<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\application\models\Bank;
use backend\modules\allocation\models\Currency;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\BankAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-account-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="email">Bank Name:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?= $form->field($model, 'bank_id')->label(false)->dropDownList(
                                ArrayHelper::map(Bank::find()->all(), 'bank_id', 'bank_name'),['prompt'=>'Select Bank']
                    ) ?> 
       </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Branch Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'branch_name')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Account Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'account_name')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Account Number:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'account_number')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="email">Currency:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?= $form->field($model, 'currency_id')->label(false)->dropDownList(
                                ArrayHelper::map(Currency::find()->all(), 'currency_id', 'currency_ref'),['prompt'=>'Select Currency']
                    ) ?> 
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
