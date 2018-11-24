<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$modelUser,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'email_address'=>['label'=>'Username:', 'options'=>['placeholder'=>'Email Address','readonly'=>'readonly']],	
		'password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Password:', 'options'=>['placeholder'=>'Password'],
		'hint'=>'<i>Note: The password must contain at least 8 characters in length where it must include: one capital letter, one number, no spaces.</i>',
		],
		'confirm_password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Retype Password:', 'options'=>['placeholder'=>'Retype Password']],
    ]
]);
?>
  <div class="text-right">
       <?= Html::submitButton($modelUser->isNewRecord ? 'Sign Up' : 'Recover Password', ['class' => $modelUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
ActiveForm::end();
?>
    </div>


