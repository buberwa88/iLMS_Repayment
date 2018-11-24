<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
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
          <label class="control-label" for="employer_name">Employer Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'employer_name')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employer_type">Employer Type:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'employer_type')->label(false)->dropDownList([ 'PRIVATE' => 'PRIVATE', 'GOVERNMENT' => 'GOVERNMENT', 'NGO/NPO' => 'NGO/NPO', ], ['prompt' => 'Select']) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="employer_code">Employer Code:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'employer_code')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="short_name">Employer Short Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'short_name')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="company_nature_of_work">Employer Nature of Work:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'company_nature_of_work')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="postal_address">Postal Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'postal_address')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="district">District:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?=
                        $form->field($model1, 'district')->label(false)->widget(DepDrop::classname(), [
                            'data' => ArrayHelper::map(backend\modules\application\models\District::find()->all(), 'district_id', 'district_name'),
                            'options' => ['prompt' => 'Select Project Output', 'id' => 'ward_id'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => [''],
                                'url' => Url::to(['/repayment/employer/ward-name']),
                                'loadingText' => 'Loading child level 1 ...',
                            ]
                        ]);
                        ?>
       </div>
        </div>
               </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="ward_id">Ward:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?=
                        $form->field($model1, 'ward_id')->label(FALSE)->widget(DepDrop::classname(), [
                            'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->all(), 'ward_id', 'ward_name'),
                            'options' => ['placeholder' => 'Select ...', 'id' => 'ward_id1'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['ward_id'],
                                'url' => Url::to(['/repayment/employer/ward-name']),
                                'loadingText' => 'Loading child level 2 ...',
                            ]
                        ]);
                        ?> 
       </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="phone_number">Fixed Telephone No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model1, 'phone_number')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="phone_number">Mobile Telephone No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'phone_number')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="firstname">Contact Person First Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'firstname')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="middlename">Contact Person Middle Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'middlename')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="surname">Contact Person Surname:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'surname')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email_address">Valid Email Address:</label>
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
          <label class="control-label" for="password1">Password:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'password1')->label(false)->passwordInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="password2">Retype Password:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model2, 'password2')->label(false)->passwordInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
    <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="verifyCode">Verification Code:</label>
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
