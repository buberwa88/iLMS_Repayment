<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-item-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Item Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'item_name')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
   <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Item Code:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'item_code')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div> 
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Is Active:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
        <?php $model->isNewRecord==1 ? $model->is_active=1:$model->is_active;?>
        <?= $form->field($model, 'is_active')->label(false)->radioList(array('0'=>'Inactive',1=>'Active')); ?>
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
