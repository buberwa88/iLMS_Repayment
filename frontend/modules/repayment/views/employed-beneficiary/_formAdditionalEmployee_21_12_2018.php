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

    $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = EmployerSearch::getEmployer($loggedin);
        $employerID = $employer2->employer_id;

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
            'label' => 'Region',
            'options' => [
                'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                'options' => [
                    'prompt' => 'Select Region Name',
                    'id' => 'region_Id'
                ],
            ],
        ],
        'district' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'District',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(\common\models\District::find()->where(['region_id' => $model->region])->all(), 'district_id', 'district_name'),
                'options' => [
                    'prompt' => 'Select District Name',
                    'id' => 'district_id'
                ],
                'pluginOptions' => [
                    'depends' => ['region_Id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/district-name']),
                ],
            ],
        ],
        'place_of_birth' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Ward',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id' => $model->district])->all(), 'ward_id', 'ward_name'),
                //'disabled' => $model->isNewrecord ? false : true,
                'pluginOptions' => [
                    'depends' => ['district_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/ward-name']),
                ],
            ],
        ],
	
        'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
        'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Example: S0105.0011.2003']],
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
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
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


