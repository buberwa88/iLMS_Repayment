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
         'description'=>['label'=>'Description', 'options'=>['placeholder'=>'Description']], 
    ]
]);
 
 ?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/nature-of-work/index'], ['class' => 'btn btn-warning']);?>
  
<?php
ActiveForm::end();
?>
    </div>
