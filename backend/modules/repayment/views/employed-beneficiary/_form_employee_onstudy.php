<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

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
		 'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name','readOnly'=>'readOnly']],
         'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name','readOnly'=>'readOnly']],
         'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name','readOnly'=>'readOnly']],
		 'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Gender',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',						
                        //'readOnly'=>'readOnly',
                    ],
					'disabled' => true,
					
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
'employerName'=>['label'=>'Employer:', 'options'=>['value'=>$model->employer->employer_name,'readOnly'=>'readOnly']],
'f4indexno'=>['label'=>'F4indexno:', 'options'=>['value'=>$model->applicant->f4indexno,'readOnly'=>'readOnly']],
'employee_status'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employee Status',
              
                'options' => [
                    'data' => ['1'=>'ONSTUDY', '0'=>'Not ONSTUDY'],
                    'options' => [
                        'prompt' => 'Select ',
                   
                    ],
                ],
             ],        
   ]
]);
?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['employed-beneficiary/new-employeeonstudy'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


