<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		 'verification_framework_title'=>['label'=>'Title', 'options'=>['placeholder'=>'Title']],
                 'verification_framework_desc'=>['label'=>'Description', 'options'=>['placeholder'=>'Description']],
                 'verification_framework_stage'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Confirm',              
                'options' => [
                    'data' => ['1'=>'Yes', '0'=>'No'],
                    'options' => [
                        'prompt' => 'Select',
                   
                    ],
                ],
             ],
   ]
]);	
?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Confirm', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/verification-framework/view','id'=>$model->verification_framework_id], ['class' => 'btn btn-warning']);
ActiveForm::end();
?>
    </div>
