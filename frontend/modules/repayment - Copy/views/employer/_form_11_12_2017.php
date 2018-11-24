<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\application\models\Ward;
use backend\modules\application\models\District;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employer-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Employer Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'employer_name')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Employer Type:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'employer_type')->label(false)->dropDownList([ 'PRIVATE' => 'PRIVATE', 'GOVERNMENT' => 'GOVERNMENT', ], ['prompt' => 'Select']) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Employer Code:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'employer_code')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Postal Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'postal_address')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="email">District:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?= $form->field($model1, 'district')->label(false)->dropDownList(
                                ArrayHelper::map(District::find()->all(), 'district_id', 'district_name'),
    
    
    ['prompt'=>'Select District',
     'onchange'=>'$.post("index.php?r=ward/lists&id=' . '"+$(this).val(),function(data){
                      $("select#employer-ward_id").html(data);
                    });'   
        ]
                    ) ?> 
       </div>
        </div>
               </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="email">Ward:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?= $form->field($model1, 'ward_id')->label(false)->dropDownList(
                                ArrayHelper::map(ward::find()->all(), 'ward_id', 'ward_name'),['prompt'=>'Select Ward']
                    ) ?> 
       </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Fixed Telephone No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'phone_number')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Mobile Telephone No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'phone_number')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Contact Person First Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'firstname')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Contact Person Middle Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'middlename')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Contact Person Surname:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'surname')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Valid Email Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'email_address')->label(false)->textInput(['maxlength' => true]) ?>        
    </div>
            <i><strong>Please ensure that you can login in to the email address you enter above.</strong></i>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Password:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'password1')->label(false)->passwordInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Retype Password:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'password2')->label(false)->passwordInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
    <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Verification Code:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">        
        <?= $form->field($model3, 'verifyCode')->label(false)->widget(Captcha::className(), [
		                'captchaAction' => '/repayment/default/captcha',
                        'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
    </div>
        </div>
            </div>
       </div>
    <div class="space10"></div>
     <div class="col-sm-12">
    <div class="form-group button-wrapper">
        <?= Html::submitButton($model1->isNewRecord ? 'Sign Up' : 'Update', ['class' => $model1->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
<div class="space10"></div>
