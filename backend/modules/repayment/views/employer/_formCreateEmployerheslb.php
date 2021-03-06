<script type="text/javascript">
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("employer_type_id");
		var employer_type_value= ddlPassport.value;
		
		//alert (claim_category_value);
                if(employer_type_value=='2'){
                          document.getElementById('employer_type_government').style.display = 'block';
                          document.getElementById('employer_type_private').style.display = 'none';
                                   }
                                else{
                          document.getElementById('employer_type_private').style.display = 'block';
                          document.getElementById('employer_type_government').style.display = 'none';
                          						  
                                }
    }
</script>
<?php

//use kartik\password\StrengthValidator;
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
/*
if (!$model1->isNewRecord && $model1->place_of_birth > 0) {
    $modelz = \backend\modules\application\models\Ward::findOne($model1->place_of_birth);

    $model1->district = $modelz->district_id;
    ################find region Id ##############

    $modelr = \backend\modules\application\models\District::findOne($modelz->district);
    $model1->region = $modelr->region_id;
}
*/
if (!$model1->isNewRecord && $model2->region > 0) {
    $modelr = \backend\modules\application\models\District::findOne($model2->region);
    $model2->region = $modelr->region_id;

    $modelDistr = \backend\modules\application\models\District::findOne($model2->region);
    $model2->district = $modelDistr->region_id;
}

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<i><strong><h1>Employer Details</h1></strong></i>

<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'employerName'=>['label'=>'Employer Name:', 'options'=>['placeholder'=>'Employer Name','onkeyup'=>"this.value = this.value.toUpperCase();"]],
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'short_name'=>['label'=>'Employer Short Name:', 'options'=>['placeholder'=>'Employer Short Name']],
    ]
]);
?>

 <?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[   
        'employer_type_id' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
				'label'=>'Employer Type:',
                'items' =>ArrayHelper::map(\backend\modules\repayment\models\EmployerType::find()->AsArray()->all(),'employer_type_id', 'employer_type'), 
                'options' => [
                        'prompt' => 'Select Employer Type',
                        'id' => 'employer_type_id',
                        //'onchange'=>'ShowHideDiv()',
                    ],
              ],
            //'TIN'=>['label'=>'TIN:', 'options'=>['placeholder'=>'TIN']],			         			
    ]
]);
?>
<?=
$form->field($model2, 'TIN')->label('TIN:')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '999-999-999'
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[         			
			'nature_of_work_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Sector/Industry:',
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
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         	'postal_address'=>['label'=>'Postal Address:', 'options'=>['placeholder'=>'Postal Address']],
			'physical_address'=>['label'=>'Physical Address:', 'options'=>['placeholder'=>'Physical Address']],      
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[         	
        'region' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Region:',
            'options' => [
                'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                'options' => [
                    'prompt' => 'Select Region Name',
                    'id' => 'region_Id',
                ],
				'pluginOptions' => [
                'allowClear' => true
                ],
            ],
        ],
        'district' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'District:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(\common\models\District::find()->where(['region_id' => $model2->region])->all(), 'district_id', 'district_name'),
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
        'ward_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Ward:',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id' => $model2->district])->all(), 'ward_id', 'ward_name'),
                //'disabled' => $model->isNewrecord ? false : true,
                'pluginOptions' => [
                    'depends' => ['district_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/repayment/employer/ward-name']),
                ],
            ],
        ],
        
        
    ]
]);
?>
<?=
$form->field($model2, 'phone_number_employer')->label('Work Phone No.')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '255 99 999 9999'
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'fax_number'=>['label'=>'Fax Number:', 'options'=>['placeholder'=>'Fax Number']],
    ]
]);
 ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'email_address'=>['label'=>'Office Email Address:', 'options'=>['placeholder'=>'Email Address']],
    ]
]);
 ?>
<hr>
<i><strong><h1>Contact Person Details</h1></strong></i>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name']],
        'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
        'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
    ]
]);
?>
<?=
$form->field($model2, 'phone_number')->label('Mobile Phone No.')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '255 99 999 9999'
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
		'email_address'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address'],
		'hint'=>'<i>Note: This will be used as username during login.</i>',
		],
		'confirm_email'=>['label'=>'Confirm Email Address:', 'options'=>['placeholder'=>'Confirm Email Address']],
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model2,
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
<div class="text-right">
       <?= Html::submitButton($model1->isNewRecord ? 'Create' : 'Create', ['class' => $model1->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


