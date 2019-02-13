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
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'method_desc'=>['label'=>'Method Name:', 'options'=>['placeholder'=>'Method Name:']],		
    ]
]);
?>
  <div class="text-right">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	 <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/pay-method/index'], ['class' => 'btn btn-warning']);?>
  
<?php
ActiveForm::end();
?>
    </div>