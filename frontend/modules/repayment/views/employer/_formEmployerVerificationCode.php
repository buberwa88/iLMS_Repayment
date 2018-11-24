<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;

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
         'email_verification_code'=>['label'=>'Verification Code:', 'options'=>['placeholder'=>'Enter Verification Code']], 		      			
    ]
]);
?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
  
<?php
ActiveForm::end();
?>
    </div>


