<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AcademicYear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-method-form">
   
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Method Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'method_desc')->label(false)->textInput(['maxlength' => true]) ?>
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