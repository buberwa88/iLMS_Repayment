<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'employer_type'=>['label'=>'Employer Type', 'options'=>['placeholder'=>'Employer Type']],
         'has_TIN'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Has TIN?',              
                'options' => [
                    'data' => ['1'=>'Yes', '0'=>'No'],
                    'options' => [
                        'prompt' => 'Select Option',
                   
                    ],
                ],
             ],	
            'is_active'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Is Active',              
                'options' => [
                    'data' => ['1'=>'Active', '0'=>'Inactive'],
                    'options' => [
                        'prompt' => 'Select Option',
                   
                    ],
                ],
             ],	
        /*			 
		 'is_active'=>[
            'type'=>Form::INPUT_RADIO_LIST, 
            'items'=>[1=>'Active', 0=>'Inactive'],
            'default'=>[1=>'Active'],			
            'label'=>Html::label('Status'), 
            'options'=>['inline'=>true]
        ],
		*/
    ]
]);
 
 ?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employer-type/index'], ['class' => 'btn btn-warning']);?>
  
<?php
ActiveForm::end();
?>
    </div>
