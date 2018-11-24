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


           'region' => [
                'class' => 'region',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(\common\models\Region::find()->asArray()->all(), 'region_id', 'region_name'), 'options' => ['prompt' => '-- Select --'],
                'columnOptions' => ['width' => '185px', 'height' => '10px'],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
			
			'district' => [
                'type' => Form::INPUT_WIDGET,
                'label' => 'District',
                'widgetClass' => DepDrop::className(),
                'options' => [
                    'pluginOptions' => [
                        'depends' => ['loanbeneficiary-region'],
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
                        'depends' => ['loanbeneficiary-district'],
                        'placeholder' => 'Select ward',
                        'url' => Url::to(['/repayment/employer/ward-name']),
                    ],
                ],
                'columnOptions' => ['id' => 'wardID'],
				'hint'=>'<i>Note: This is place of birth.</i>',
            ],
			'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],
			'postal_address'=>['label'=>'Postal Address:', 'options'=>['placeholder'=>'Postal Address']],
			'physical_address'=>['label'=>'Physical Address:', 'options'=>['placeholder'=>'Physical Address']],
			'email_address'=>['label'=>'Current Email Address:', 'options'=>['placeholder'=>'Email Address']],
			'NID'=>['label'=>'National Identification Number:', 'options'=>['placeholder'=>'National Identification Number']],
			'f4indexno'=>['label'=>'Form IV Index Number:', 'options'=>['placeholder'=>'Example: S0175.0033.2004']],
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
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
			<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[		
		'password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Password:', 'options'=>['placeholder'=>'Password'],
		'hint'=>'<i>Note: The password must contain at least 8 characters in length where it must include: one capital letter, one number, no spaces.</i>',
		],
		'confirm_password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Retype Password:', 'options'=>['placeholder'=>'Retype Password']],
    ]
]);
?>
<?= $form->field($model3, 'verifyCode')->widget(Captcha::className(), [
		                'captchaAction' => '/repayment/default/captcha',
                        'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10">{input}</div></div>',						
                    ]) ?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/login'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


