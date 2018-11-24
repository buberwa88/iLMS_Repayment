<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use kartik\date\DatePicker;

$this->title = 'Recover Password';
$this->params['breadcrumbs'][] = "Recover Password";
?>
   <center> <p>Please provide the following detail</p></center>
            <?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'recover_password'=>['label'=>'Email Address or Form IV Index Number:', 'options'=>['placeholder'=>'Enter Email Address or Form IV Index Number'],
		 'hint'=>'<i>Enter Email Address or Form IV Index Number</i>'
		 ], 

    ]
]);
?>		
				<div class="text-right">
       <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/login'], ['class' => 'btn btn-warning']);
?>
<?php ActiveForm::end(); ?>
    </div>
