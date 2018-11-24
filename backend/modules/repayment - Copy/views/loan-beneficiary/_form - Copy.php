<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-beneficiary-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
<div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">First Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'firstname')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
   <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Middle Name:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'middlename')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div> 
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Surname:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'surname')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Date of Birth:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
        <?= $form->field($model, 'date_of_birth')->label(false)->widget(DatePicker::classname(), [
           'name' => 'date_of_birth', 
    'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'Select date of birth ...',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
    ?> 
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="district">Place of Birth(District):</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?=
                        $form->field($model, 'district')->label(false)->widget(DepDrop::classname(), [
                            'data' => ArrayHelper::map(backend\modules\application\models\District::find()->all(), 'district_id', 'district_name'),
                            'options' => ['prompt' => '...Select....', 'id' => 'place_of_birth'],
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
            <label class="control-label" for="place_of_birth">Place of Birth(Ward):</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?=
                        $form->field($model, 'place_of_birth')->label(FALSE)->widget(DepDrop::classname(), [
                            'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->all(), 'ward_id', 'ward_name'),
                            'options' => ['placeholder' => '....Select ...', 'id' => 'place_of_birth1'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['place_of_birth'],
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
          <label class="control-label" for="email">Current Telephone No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'phone_number')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Email Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'email_address')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Postal Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'postal_address')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Physical Address:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'physical_address')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Form IV Index No:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'f4indexno')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="NID">National ID:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'NID')->label(false)->textInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>         
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="district">University Studied:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?=
                        $form->field($model, 'learning_institution_id')->label(false)->widget(DepDrop::classname(), [
                            'data' => ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->all(), 'learning_institution_id', 'institution_name'),
                            'options' => ['prompt' => '...Select....', 'id' => 'learning_institution_id'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => [''],
                                'url' =>Url::to(['']),
                                'loadingText' => 'Loading child level 1 ...',
                            ]
                        ]);
                        ?>
       </div>
        </div>
               </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="password">Password:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'password')->label(false)->passwordInput(['maxlength' => true]) ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="confirm_password">Retype Password:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'confirm_password')->label(false)->passwordInput(['maxlength' => true]) ?>
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
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
     </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
<div class="space10"></div>