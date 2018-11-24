 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
 
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
    'disbursement_structure_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Structure Name',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementStructure::find()->all(),'disbursement_structure_id','structure_name'),
                    'options' => [
                        'prompt' => 'Select Disbursement Structure',
                        
                    
                    ],
                ],
            ],
  'disbursement_task_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Disbursement Task',
                'options' =>[
                    'data' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementTask::find()->all(),'disbursement_task_id','task_name'),
                    'options' => [
                        'prompt' => 'Select Disbursement Task',
                       
                    ],
                ],
      ]
    ]
]);
 
?>
 
  <div class="text-right">
 <?= $form->field($model, 'disbursement_schedule_id')->label(false)->hiddenInput(["value"=>$model->isNewRecord ?$disbursement_schedule_id:$model->disbursement_schedule_id]) ?>
 <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
  <?= Html::a('Cancel', ['index','id'=>$model->isNewRecord ?$disbursement_schedule_id:$model->disbursement_schedule_id], ['class' => 'btn btn-primary']) ?>
              
      <?php
ActiveForm::end();
?>
 
    </div>
