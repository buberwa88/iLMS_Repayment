<script type="text/javascript">    
	function ShowHideDivStudyLevelsDiploma(element){
    var checked = $(element).is(':checked');
    if (checked) {
       document.getElementById('div_item_level_studyDiploma').style.display = 'block';
    } else {
        // reset values		
        $('#programme_diploma_id').val('');
		$('#learning_institution_diploma_id').val('');
		$('#programme_entry_year_diploma_id').val('');
		$('#programme_completion_year_diploma_id').val('');
        document.getElementById('div_item_level_studyDiploma').style.display = 'none';
    }
}
function ShowHideDivStudyLevelsBachelor(element){
    var checked = $(element).is(':checked');
    if (checked) {
       document.getElementById('div_item_level_studyBachelor').style.display = 'block';
    } else {
        // reset values		
        $('#programme_Bachelor_id').val('');
		$('#learning_institution_Bachelor_id').val('');
		$('#programme_entry_year_Bachelor_id').val('');
		$('#programme_completion_year_Bachelor_id').val('');
        document.getElementById('div_item_level_studyBachelor').style.display = 'none';
    }
}
function ShowHideDivStudyLevelsMasters(element){
    var checked = $(element).is(':checked');
    if (checked) {
       document.getElementById('div_item_level_studyMasters').style.display = 'block';
    } else {
        // reset values		
        $('#programme_Masters_id').val('');
		$('#learning_institution_Masters_id').val('');
		$('#programme_entry_year_Masters_id').val('');
		$('#programme_completion_year_Masters_id').val('');
        document.getElementById('div_item_level_studyMasters').style.display = 'none';
    }
}
function ShowHideDivStudyLevelsPostgraduate_Diploma(element){
    var checked = $(element).is(':checked');
    if (checked) {
       document.getElementById('div_item_level_studyPostgraduate_Diploma').style.display = 'block';
    } else {
        // reset values		
        $('#programme_Postgraduate_Diploma_id').val('');
		$('#learning_institution_Postgraduate_Diploma_id').val('');
		$('#programme_entry_year_Postgraduate_Diploma_id').val('');
		$('#programme_completion_year_Postgraduate_Diploma_id').val('');
        document.getElementById('div_item_level_studyPostgraduate_Diploma').style.display = 'none';
    }
}
function ShowHideDivStudyLevelsPhD(element){
    var checked = $(element).is(':checked');
    if (checked) {
       document.getElementById('div_item_level_studyPhD').style.display = 'block';
    } else {
        // reset values		
        $('#programme_PhD_id').val('');
		$('#learning_institution_PhD_id').val('');
		$('#programme_entry_year_PhD_id').val('');
		$('#programme_completion_year_PhD_id').val('');
        document.getElementById('div_item_level_studyPhD').style.display = 'none';
    }
}
</script>
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
use frontend\modules\repayment\models\EmployerSearch;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
if (!$model->isNewRecord && $model->place_of_birth > 0) {
    $modelz = \backend\modules\application\models\Ward::findOne($model->place_of_birth);

    $model->district = $modelz->district_id;
    ################find region Id ##############

    $modelr = \backend\modules\application\models\District::findOne($modelz->district);
    $model->region = $modelr->region_id;
}
?>
<?php
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
        'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
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
<label>Level of Study</label>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>5,
    'attributes'=>[
'programme_level_of_study'=>[
            'type'=>Form::INPUT_CHECKBOX,
            'label'=>'Diploma',			
            'value' => 0, 
            'options'=>['inline'=>true,
			'id' => 'STUDY_LEVEL1_id',
            'onchange' => 'ShowHideDivStudyLevelsDiploma(this)',
			]
        ],	
'STUDY_LEVEL2'=>[
            'type'=>Form::INPUT_CHECKBOX, 
            'label'=>'Bachelor',			
            'value' => 1,  
            'options'=>['inline'=>true,
			'id' => 'STUDY_LEVEL2_id',
            'onchange' => 'ShowHideDivStudyLevelsBachelor(this)',
			]
        ],
'STUDY_LEVEL3'=>[
            'type'=>Form::INPUT_CHECKBOX, 
            'label'=>'Masters',			
            'value' => 2, 
            'options'=>['inline'=>true,
			'id' => 'STUDY_LEVEL3_id',
            'onchange' => 'ShowHideDivStudyLevelsMasters(this)',
			]
        ],
'STUDY_LEVEL4'=>[
            'type'=>Form::INPUT_CHECKBOX, 
            'label'=>'Postgraduate Diploma',			
            'value' => 3,  
            'options'=>['inline'=>true,
			        'id' => 'STUDY_LEVEL4_id',
                    'onchange' => 'ShowHideDivStudyLevelsPostgraduate_Diploma(this)',
			]
        ],
'STUDY_LEVEL5'=>[
            'type'=>Form::INPUT_CHECKBOX, 
            'label'=>'PhD',			
            'value' => 4, 
            'options'=>['inline'=>true,
			'id' => 'STUDY_LEVEL5_id',
            'onchange' => 'ShowHideDivStudyLevelsPhD(this)',
			]
        ],	
    ]
]);	
?>
<div id="div_item_level_studyDiploma" style="display:none">
<legend><small><strong>Study Level Diploma</strong></small></legend>
    <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_diploma_id',                    
                    ],
					'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                ],
            ],
		'programme' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Studied:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => ' Select Programme ',
                        'id' => 'programme_diploma_id',
                ],
                'pluginOptions' => [
                    'depends' => ['learning_institution_diploma_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/programme-name']),
                ],
            ],
        ],	        
        'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_diploma_id']],
        'programme_completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year','id' => 'programme_completion_year_diploma_id']],		
    ]
]);	
?>
</div>
<div id="div_item_level_studyBachelor" style="display:none">
<legend><small><strong>Study Level Bachelor</strong></small></legend>
    <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_Bachelor_id',                    
                    ],
					'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                ],
            ],
		'programme' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Studied:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => ' Select Programme ',
                        'id' => 'programme_Bachelor_id',
                ],
                'pluginOptions' => [
                    'depends' => ['learning_institution_Bachelor_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/programme-name']),
                ],
            ],
        ],	        
        'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_Bachelor_id']],
        'programme_completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year','id' => 'programme_completion_year_Bachelor_id']],		
    ]
]);	
?>
</div>
<div id="div_item_level_studyMasters" style="display:none">
<legend><small><strong>Study Level Masters</strong></small></legend>
    <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_Masters_id',                    
                    ],
					'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                ],
            ],
		'programme' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Studied:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => ' Select Programme ',
                        'id' => 'programme_Masters_id',
                ],
                'pluginOptions' => [
                    'depends' => ['learning_institution_Masters_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/programme-name']),
                ],
            ],
        ],	        
        'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_Masters_id']],
        'programme_completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year','id' => 'programme_completion_year_Masters_id']],		
    ]
]);	
?>
</div>
<div id="div_item_level_studyPostgraduate_Diploma" style="display:none">
<legend><small><strong>Study Level Postgraduate Diploma</strong></small></legend>
    <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_Postgraduate_Diploma_id',                    
                    ],
					'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                ],
            ],
		'programme' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Studied:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => ' Select Programme ',
                        'id' => 'programme_Postgraduate_Diploma_id',
                ],
                'pluginOptions' => [
                    'depends' => ['learning_institution_Postgraduate_Diploma_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/programme-name']),
                ],
            ],
        ],	        
        'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_Postgraduate_Diploma_id']],
        'programme_completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year','id' => 'programme_completion_year_Postgraduate_Diploma_id']],		
    ]
]);	
?>
</div>
<div id="div_item_level_studyPhD" style="display:none">
<legend><small><strong>Study Level PhD</strong></small></legend>
    <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_PhD_id',                    
                    ],
					'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                ],
            ],
		'programme' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Studied:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => ' Select Programme ',
                        'id' => 'programme_PhD_id',
                ],
                'pluginOptions' => [
                    'depends' => ['learning_institution_PhD_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/programme-name']),
                ],
            ],
        ],	        
        'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_PhD_id']],
        'programme_completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year','id' => 'programme_completion_year_PhD_id']],		
    ]
]);	
?>
</div>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
        'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Example: S0105.0011.2003']],        
        'NID'=>['label'=>'National Identification Number:', 'options'=>['placeholder'=>'National Identification Number']], 			
        'employee_id'=>['label'=>'Employee ID:', 'options'=>['placeholder'=>'Employee ID']],
		'LOAN_BENEFICIARY_STATUS'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Loan Beneficiary Status:',
              
                'options' => [
                    'data' => ['YES'=>'YES', 'NO'=>'NO', 'N/A'=>'N/A'],
                    'options' => [
                        'prompt' => 'Loan Beneficiary Status',
                   
                    ],
					'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                ],
             ],
         'salary_source'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Salary Source:',
              
                'options' => [
                    'data' => ['1'=>'Central Government', '2'=>'Own Source', '3'=>'Both(Own Source and Central Government)'],
                    'options' => [
                        'prompt' => 'Select Salary Source',
                   
                    ],
                ],
             ],		
    ]
]);	
?>
<?= $form->field($model, 'employer_id')->hiddenInput(['value'=>$employerID])->label(false); ?>
<?= $form->field($model, 'employment_status')->hiddenInput(['value'=>'ONPOST'])->label(false); ?>

  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employed-beneficiary/index-view-beneficiary'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


