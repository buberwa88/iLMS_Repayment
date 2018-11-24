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

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		 'attachment_desc'=>['label'=>'Attachment Desc:', 'options'=>['placeholder'=>'Attachment Desc']],
		 'require_verification'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Require Verification',              
                'options' => [
                    'data' => ['1'=>'Yes', '0'=>'No'],
                    'options' => [
                        'prompt' => 'Select ',
                   
                    ],
                ],
             ],
   ]
]);	
?>	
<?= $form->field($model, 'verification_prompt')->textArea(['maxlength' => true]) ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		 'is_active'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Is Active',              
                'options' => [
                    'data' => ['1'=>'Yes', '0'=>'No'],
                    'options' => [
                        'prompt' => 'Select ',
                   
                    ],
                ],
             ],
   ]
]);	
?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/attachment-definition'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


