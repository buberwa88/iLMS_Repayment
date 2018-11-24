 
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
        'sub_cluster_name'=>['label'=>'Sub Cluster Name', 'options'=>['placeholder'=>'Sub Cluster Name...']],
  
    ]
]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[
        'sub_cluster_desc'=>['label'=>'Description', 'options'=>['placeholder'=>'Description']],
        
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
