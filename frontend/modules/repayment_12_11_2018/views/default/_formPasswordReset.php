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

$this->title = 'Recover Password';
$this->params['breadcrumbs'][] = "Recover Password";
?>
   <center> <p>This helps show that this account really belongs to you</p></center>
<center>				
				<ul><?= Html::a('Recover Password- Employer', ['/repayment/default/password-reset']) ?></ul>
				<ul><?= Html::a('Recover Password - Loan Beneficiary', ['/repayment/default/password-reset']) ?></ul>
				</center>
            <?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'userCategory'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'User Category',
              
                'options' => [
                    'data' => ['Employer'=>'Employer', 'Beneficiary'=>'Employed Beneficiary'],
                    'options' => [
                        'prompt' => 'Select User Category ',
                   
                    ],
                ],
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
