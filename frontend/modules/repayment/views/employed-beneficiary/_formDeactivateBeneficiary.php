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
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name']],
        'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
        'surname'=>['label'=>'Surname:', 'options'=>['placeholder'=>'Surname']],
        'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Gender',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',
                   
                    ],
                ],
             ],		
	    ]
]);	
?>	
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
        'NID'=>['label'=>'National Identification Number:', 'options'=>['placeholder'=>'National Identification Number']], 			
        'employee_id'=>['label'=>'Employee ID:', 'options'=>['placeholder'=>'Employee ID']],        
        'basic_salary'=>['label'=>'Basic Salary(TZS):', 'options'=>['placeholder'=>'Basic Salary']],
        'employmentStatus2'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employment Status',
              
                'options' => [
                    'data' => ['ONPOST'=>'ONPOST', 'TERMINATED'=>'TERMINATED', 'RETIRED'=>'RETIRED', 'DECEASED'=>'DECEASED'],
                    'options' => [
                        'prompt' => 'Select Employment Status ',
                   
                    ],
                ],
             ],
    ]
]);	
?>
<?php
 echo $form->field($model, 'support_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'employed_beneficiary/pdf'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => TRUE,
        'showUpload' => false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Support Document (required format .pdf only)',
         'initialPreview'=>[
            "$model->support_document",
           
        ],
        'initialCaption'=>$model->support_document,
        'initialPreviewAsData'=>true,
    ]
]);
 ?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['beneficiaries-verified'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


