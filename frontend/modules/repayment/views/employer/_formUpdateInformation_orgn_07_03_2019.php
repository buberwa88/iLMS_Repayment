<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;

$results=frontend\modules\repayment\models\Employer::getEmployerCategory($employerModel->employer_id);
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
if (!$employerModel->isNewRecord && $employerModel->ward_id > 0) {
    $modelz = \backend\modules\application\models\Ward::findOne($employerModel->ward_id);

    $employerModel->district = $modelz->district_id;
    ################find region Id ##############

    $modelr = \backend\modules\application\models\District::findOne($modelz->district);
    $employerModel->region = $modelr->region_id;
}
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<i><strong><h1>Employer Details</h1></strong></i>

 <?php
echo Form::widget([ // fields with labels
    'model'=>$employerModel,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'employer_name'=>['label'=>'Employer Name:', 'options'=>['placeholder'=>'Employer Name']], 
		 'short_name'=>['label'=>'Employer Short Name:', 'options'=>['placeholder'=>'Employer Short Name']],
		 'TIN'=>['label'=>'TIN:', 'options'=>['placeholder'=>'TIN']],
		 'employer_type_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employer Type:',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\repayment\models\EmployerType::find()->asArray()->all(), 'employer_type_id', 'employer_type'),
                    'options' => [
                        'prompt' => 'Select Employer Type',
                    ],
                ],
            ],			
			'nature_of_work_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Sector:',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\repayment\models\NatureOfWork::find()->asArray()->all(), 'nature_of_work_id', 'description'),
                    'options' => [
                        'prompt' => 'Select Sector',
                    ],
                ],
            ],         			
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$employerModel,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         	'postal_address'=>['label'=>'Postal Address:', 'options'=>['placeholder'=>'Postal Address']],
			'physical_address'=>['label'=>'Physical Address:', 'options'=>['placeholder'=>'Physical Address']],
			
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
            ],
			
			'district' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District:',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\District::find()->Where(['region_id'=>$employerModel->region])->all(), 'district_id', 'district_name'),
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
            ],
			
			'ward_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Ward:',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->Where(['district_id'=> $employerModel->district])->all(), 'ward_id', 'ward_name'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['ward-id'],
                        'placeholder' => 'Select Ward',
                        'url' => Url::to(['/repayment/employer/ward-name']),
                    ],
                ],
            ],
    ]
]);

echo Form::widget([ // fields with labels
    'model'=>$employerModel,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number'],
		'hint'=>'<i>Example: 0769853625,0652354251,25589658</i>'
		],        
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$employerModel,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'fax_number'=>['label'=>'Fax Number:', 'options'=>['placeholder'=>'Fax Number']],
		'email_address'=>['label'=>'Office Email Address:', 'options'=>['placeholder'=>'Email Address']],		
    ]
]);
 ?>
 <?php
 if(strcmp(strtoupper($results->employerType->employer_type),"GOVERNMENT")==0){
echo Form::widget([ // fields with labels
    'model'=>$employerModel,
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
    ]
]);
}
 ?>
<!--
<hr>
<i><strong><h1>Contact Person Details</h1></strong></i>
---->
<?php
/*
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name']],
        'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
        'surname'=>['label'=>'Surname:', 'options'=>['placeholder'=>'Surname']],
		'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number'],
		'hint'=>'<i>Example: 0769853625,0652354251,25589658</i>',
		],
		'email_address'=>['label'=>'Email Address(Username):', 'options'=>['placeholder'=>'Email Address'],
		],
    ]
]);
 * 
 */
?>
  <div class="text-right">
       <?= Html::submitButton($employerModel->isNewRecord ? 'Sign Up' : 'Update', ['class' => $employerModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['view','id'=>$employerModel->employer_id], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


