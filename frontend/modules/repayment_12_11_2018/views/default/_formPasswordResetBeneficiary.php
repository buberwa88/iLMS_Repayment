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
use kartik\date\DatePicker;

$this->title = 'Activate Account - Loan Beneficiary';
$this->params['breadcrumbs'][] = "Activate Account - Loan Beneficiary";
?>
   <center> <p>Please provide the following details</p></center>
            <?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Form IV Index Number:']], 
         'beneficiaryCurrentEmail'=>['label'=>'Current Email Address:', 'options'=>['placeholder'=>'Current Email Address:']], 
    ]
]);
?>		 		 
		 <?= $form->field($model, 'dateOfBirth')->widget(DatePicker::classname(), [
           'name' => 'dateOfBirth', 
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
                        'id'=>'region-id',                    
                    ],
					//'id'=>'region-id',
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
			
			'ward' => ['type' => Form::INPUT_WIDGET,
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
           'learningInstitution' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                    ],
                ],
				'hint'=>'<i>Note: Institution loan beneficiary graduated.</i>',
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
