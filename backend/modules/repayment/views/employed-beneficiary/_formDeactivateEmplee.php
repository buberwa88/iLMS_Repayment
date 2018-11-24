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
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,]);
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
<?php
 echo $form->field($model, 'support_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'employed_beneficiary/pdf'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => TRUE,
        'showUpload' => false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Support Document (required format .pdf only)',
         'initialPreview'=>[
            "$model->support_document",
           
        ],
        'initialCaption'=>$model->support_document,
        'initialPreviewAsData'=>true,
    ]
]);
 ?>
  <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['employed-beneficiary/mult-employed','id' => $model->applicant_id], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>


