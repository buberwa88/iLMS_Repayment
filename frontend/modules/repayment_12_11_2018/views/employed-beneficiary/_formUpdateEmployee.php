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
		<?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
           'name' => 'date_of_birth', 
    //'value' => date('Y-m-d', strtotime('+2 days')),
	
    'options' => ['placeholder' => 'yyyy-mm-dd',
                  'todayHighlight' => false,
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
	
	'region' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Region:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => ' Select Region ',
                        'id'=>'region-id'
                    
                    ],
                ],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
			
			'district' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District:',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\District::find()->Where(['region_id'=>$model->region])->all(), 'district_id', 'district_name'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['region-id'],
                        'placeholder' => 'Select District',
                        'url' => Url::to(['/repayment/employer/district-name']),
                    ],
					'options' => [
                        'id'=>'ward-id',                    
                    ],
                ],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
			
			'ward_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Ward:',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->Where(['district_id'=>$model->district])->all(), 'ward_id', 'ward_name'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['ward-id'],
                        'placeholder' => 'Select Ward',
                        'url' => Url::to(['/repayment/employer/ward-name']),
                    ],
                ],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
	
        'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
        'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Form IV Index Number']],
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_id',
                    
                    ],
                ],
				'hint'=>'<i>Note: Institution employee graduated.</i>',
            ],
        'NID'=>['label'=>'National Identification Number:', 'options'=>['placeholder'=>'National Identification Number']], 			
        'employee_id'=>['label'=>'Check Number:', 'options'=>['placeholder'=>'Check Number']],        
        'basic_salary'=>['label'=>'Basic Salary(TZS):', 'options'=>['placeholder'=>'Basic Salary']],
        'employment_status'=>['type' => Form::INPUT_WIDGET,
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

  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employed-beneficiary/un-verified-uploaded-employees'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


