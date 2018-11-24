<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
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
		 'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name','readOnly'=>'readOnly']],
         'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name','readOnly'=>'readOnly']],
         'surname'=>['label'=>'Surname:', 'options'=>['placeholder'=>'Surname','readOnly'=>'readOnly']],
		 'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Gender',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',						
                        //'readOnly'=>'readOnly',
                    ],
					'disabled' => true,
					
                ],
				
             ],
   ]
]);	
?>		 
			 <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
           'name' => 'date_of_birth', 
    //'value' => date('Y-m-d', strtotime('+2 days')),
	
    'options' => ['placeholder' => 'yyyy-mm-dd',
                  'todayHighlight' => false,
				  'disabled' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[	

			'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number','disabled' => true]],
			'postal_address'=>['label'=>'Postal Address:', 'options'=>['placeholder'=>'Postal Address','disabled' => true]],
			'physical_address'=>['label'=>'Physical Address:', 'options'=>['placeholder'=>'Physical Address','disabled' => true]],
			'email_address'=>['label'=>'Current Email Address:', 'options'=>['placeholder'=>'Email Address','disabled' => true]],			
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_id',
                    
                    ],
					'disabled' => true,
                ],
				'hint'=>'<i>Note: Institution loan beneficiary graduated.</i>',
            ],
			'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Example: S0175.0033.2004']],
			
			
    ]
]);
?>			
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['loan-beneficiary/index'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


