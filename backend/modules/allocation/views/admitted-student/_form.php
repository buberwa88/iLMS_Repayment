 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'admission_batch_id'=>['label'=>'Admission batch', 'options'=>['placeholder'=>'Admission Batch']],
         'programme_id'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme',
              
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                    'options' => [
                        'prompt' => 'Select Program ',
                   
                    ],
                ],
             ],
          'has_transfered'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Transfer Status',
              
                'options' => [
                    'data' => [0=>'No transfer', 1=>'Transfer Initiated', 2=>'Transfer Completed'],
                    'options' => [
                        'prompt' => 'Select Program ',
                   
                    ],
                ],
             ],
         'f4indexno'=>['label'=>'f4indexno', 'options'=>['placeholder'=>'F4 Index No']],
        
      
        
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
