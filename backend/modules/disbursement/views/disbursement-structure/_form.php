 
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
           'structure_name'=>['label'=>'Structure Name', 'options'=>['placeholder'=>'Structure Name']],
           'parent_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Parent',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementStructure::find()->asArray()->all(), 'disbursement_structure_id', 'structure_name'),
                    'options' => [
                        'prompt' => 'Parent Item',
                        
                    
                    ],
                  'pluginOptions' => [
                         'allowClear' => true
                           ],
                ],
             ],
        'order_level'=>['label'=>'Order Level', 'options'=>['placeholder'=>'Order Level']],
         'status' => ['type' => Form::INPUT_WIDGET,
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
