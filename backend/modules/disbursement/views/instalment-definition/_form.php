<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'instalment'=>['label'=>'instalment', 'options'=>['placeholder'=>'Instalment']],
        'instalment_desc'=>['type' => Form::INPUT_TEXTAREA,'label'=>'Description', 'options'=>['placeholder'=>'']],
         'is_active' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Status',
                'options' => [
                    'data' =>[1=>'Active',2=>'Inactive'],
                    'options' => [
                        'prompt' => 'Status',
                    ],
                     'pluginOptions' => [
                         'allowClear' => true
                           ],
                ],
            ],
      
    ]
]);

?>
  <div class="text-right">
        
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
 
    </div>
