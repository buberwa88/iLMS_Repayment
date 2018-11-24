 
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
         'currency_ref'=>['label'=>'Currency', 'options'=>['placeholder'=>'Currency']],
         'currency_postfix'=>['label'=>'Currency Post Fix', 'options'=>['placeholder'=>'Currency Post Fix']],
         'currency_desc'=>['type' => Form::INPUT_TEXTAREA,
               'label' => 'Description',
            ],
      
        
    ]
]);
 
 ?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);

ActiveForm::end();
?>
    </div>
