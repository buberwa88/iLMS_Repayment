<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
 
//contained_student
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
     'approval_comment'=>['type' => Form::INPUT_TEXTAREA,'label'=>'Description (Reason)', 'options'=>['placeholder'=>'Enter Description']],
      
    
        
    ]
]);
?>
 <div class="text-right">
<?= Html::submitButton($model->isNewRecord ? 'Approve Allocation Batch' : 'Approve Allocation Batch', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
      
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      
 <?php ActiveForm::end(); ?>
    </div>
