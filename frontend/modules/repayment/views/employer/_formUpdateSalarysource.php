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
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'salary_source'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Salary Source',              
                'options' => [
                    'data' => ['1'=>'Central Government', '2'=>'Own Source', '3'=>'Both(Own source and Government)'],
                    'options' => [
                        'prompt' => 'Select Salary Source ',
                   
                    ],
                ],
             ],
			 'vote_number'=>['label'=>'Vote Number', 'options'=>['placeholder'=>'Vote Number']],
    ]
]);
 ?>
<?= $form->field($model1, 'industry')->hiddenInput(['value'=>0])->label(false); ?>
<?= $form->field($model1, 'sector')->hiddenInput(['value'=>0])->label(false); ?>
  <div class="text-right">
       <?= Html::submitButton($model1->isNewRecord ? 'Sign Up' : 'Update', ['class' => $model1->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['employed-beneficiary/index'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


