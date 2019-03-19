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

$yearmax = date("Y")-2;
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}

$yearmax2 = date("Y")-3;
for ($y = 1982; $y <= $yearmax2; $y++) {
    $year2[$y] = $y;
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
        'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
        'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Gender:',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',
                   
                    ],
					'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
             ],
        'programme_level_of_study' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Level of study:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                    'options' => [
                        'prompt' => 'Select',
                        //'id' => 'applicant_category_id',
                    
                    ],
					'pluginOptions' => [
                    'allowClear' => true
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
		'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => 'Select Learning Institution',
                        'id' => 'learning_institution_Id',                    
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
                    'prompt' => 'Select Programme',
                        'id' => 'programme_Id',
                ],
                'pluginOptions' => [
                    'depends' => ['learning_institution_Id'],
                    'placeholder' => 'Select',
                    'url' => Url::to(['/repayment/employer/programme-name']),
                ],
            ],
        ],	        
        //'programme_entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_PhD_id']],

        'programme_entry_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Entry Year:',
            'options' => [
                'data' => $year,
                'options' => [
                    'prompt' => 'Select',
                    'id' => 'programme_entry_year_PhD_id',
                    //'onchange' => 'check_necta()'
                    //'id'=>'entry_year_id'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],

        'programme_completion_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Completion Year:',
            'options' => [
                'data' => $year,
                'options' => [
                    'prompt' => 'Select',
                    'id' => 'programme_completion_year_PhD_id',
                    //'onchange' => 'check_necta()'
                    //'id'=>'entry_year_id'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
    ]
]);	
?>
<?=
$form->field($model, 'phone_number')->label('Telephone Number:')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '255 99 999 9999'
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[	
        //'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
        'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Example: S0105.0011']],
        'form_four_completion_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Form IV Completion Year:',
            'options' => [
                'data' => $year2,
                'options' => [
                    'prompt' => 'Select',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
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
                    'data' => ['1'=>'Central Government', '2'=>'Own Source'],
                    'options' => [
                        'prompt' => 'Select Salary Source',
                   
                    ],
					'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
             ],
        'traced_by' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Traced By:',
                  'options' => [
                      //'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                      
                      'data' =>ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` WHERE user.login_type=5')->asArray()->all(), 'user_id', 'Name'),
                      
                       'options' => [
                        'prompt' => 'Select',                        
                    ],
					'pluginOptions' => [
                        'allowClear' => true
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
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employed-beneficiary/add-uploademployee'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


