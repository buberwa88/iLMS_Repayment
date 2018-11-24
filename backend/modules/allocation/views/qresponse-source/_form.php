 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
  <?php
  $tableall=\yii::$app->db->schema->getTableNames();
  $source_table=array();
  foreach (  $tableall as   $tablealls=>$value){
   $source_table[$value]=$value;    
  }
 // print_r($source_table);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
           'source_table' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Source Table',
                'options' => [
                    'data' =>$source_table,
                    'options' => [
                        'prompt' => 'Select Source Table',
                        'id'=>'source-table_Id'
                    
                    ],
                ],
            ],
         'source_table_text_field' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'source_table_text_field',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => \yii::$app->db->schema->getTableNames(),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['source-table_Id'],
                        'placeholder' => 'All District',
                        'url' => Url::to(['/users/district']),
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

ActiveForm::end();
?>
    </div>
