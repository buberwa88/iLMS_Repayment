<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<i><strong><h1>Employer Information</h1></strong></i>

 <?php
echo Form::widget([ // fields with labels
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'employerName'=>['label'=>'Employer Name:', 'options'=>['placeholder'=>'Employer Name']], 
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
			'short_name'=>['label'=>'Employer Short Name:', 'options'=>['placeholder'=>'Employer Short Name']],
			'nature_of_work_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employer Nature of Work:',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\repayment\models\NatureOfWork::find()->asArray()->all(), 'nature_of_work_id', 'description'),
                    'options' => [
                        'prompt' => 'Select Nature of Work',
                    ],
                ],
            ],
			'TIN'=>['label'=>'TIN:', 'options'=>['placeholder'=>'TIN']],		
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         	'postal_address'=>['label'=>'Postal Address:', 'options'=>['placeholder'=>'Postal Address']],
			'physical_address'=>['label'=>'Physical Address:', 'options'=>['placeholder'=>'Physical Address']],
			
			'district' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\District::find()->all(), 'district_id', 'district_name'),
                    'options' => [
                        'prompt' => ' Select District ',
                        'id'=>'ward-id'
                    
                    ],
                ],
            ],
			'ward_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Ward:',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->Where(['district_id'=>$model1->district])->all(), 'ward_id', 'ward_name'),
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
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'phone_number'=>['label'=>'Telephone No:', 'options'=>['placeholder'=>'Telephone No'],
		'hint'=>'Example: 0769853625,0652354251,25589658'
		],        
    ]
]);
?>
<hr>
<i><strong><h1>Contact Person</h1></strong></i>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name']],
        'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
        'surname'=>['label'=>'Surname:', 'options'=>['placeholder'=>'Surname']],
    ]
]);
?>
<hr>
<i><strong><h1>Login Credentials</h1></strong></i>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'email_address'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address']],		
		'password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Password:', 'options'=>['placeholder'=>'Password']],
		'confirm_password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Retype Password:', 'options'=>['placeholder'=>'Retype Password']],
    ]
]);
?>
<?= $form->field($model3, 'verifyCode')->widget(Captcha::className(), [
		                'captchaAction' => '/repayment/default/captcha',
                        'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10">{input}</div></div>',						
                    ]) ?>

  <div class="text-right">
       <?= Html::submitButton($model1->isNewRecord ? 'Sign Up' : 'Update', ['class' => $model1->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/login'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


