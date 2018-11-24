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

if (!$model->isNewRecord && $model->place_of_birth > 0) {
    $modelz = \backend\modules\application\models\Ward::findOne($model->place_of_birth);

    $model->district_id = $modelz->district_id;
    ################find region Id ##############

    $modelr = \backend\modules\application\models\District::findOne($modelz->district_id);
    $model->region_id = $modelr->region_id;
}

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
	
	'region' => [
                'class' => 'region',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(backend\modules\application\models\Region::find()->asArray()->all(), 'region_id', 'region_name'), 'options' => ['prompt' => '-- Select --'],
                'columnOptions' => ['width' => '185px', 'height' => '10px'],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
			
			'district' => [
                'type' => Form::INPUT_WIDGET,
                'label' => 'District',
                'widgetClass' => DepDrop::className(),
                'options' => [
                    'pluginOptions' => [
                        'depends' => ['employedbeneficiary-region'],
                        'placeholder' => 'Select District',
                        'url' => Url::to(['/repayment/employer/district-name']),
                    ],
                ],
                'columnOptions' => ['id' => 'districtID'],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
			
			'place_of_birth' => [
                'type' => Form::INPUT_WIDGET,
                'label' => 'Ward',
                'widgetClass' => DepDrop::className(),
                'options' => [
                    'pluginOptions' => [
                        'depends' => ['employedbeneficiary-district'],
                        'placeholder' => 'Select ward',
                        'url' => Url::to(['/repayment/employer/ward-name']),
                    ],
                ],
                'columnOptions' => ['id' => 'wardID'],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
	
        'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
        'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Form IV Index Number']],
        
        
        'programme' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme Studied:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                    'options' => [
                        'prompt' => ' Select Programme ',
                        'id' => 'programme_id',
                    
                    ],
                ],
				'hint'=>'<i>Note: Institution employee graduated.</i>',
            ],
        'programme_level_of_study' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Level of study:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                    'options' => [
                        'prompt' => ' Select ',
                        'id' => 'applicant_category_id',
                    
                    ],
                ],
				'hint'=>'<i>Note: Institution employee graduated.</i>',
            ],
        'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year']],
        'programme_completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year']],
        
        
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
        'employee_id'=>['label'=>'Employee ID:', 'options'=>['placeholder'=>'Employee ID']],        
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


