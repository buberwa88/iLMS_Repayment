<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<div class="criteria-question-search col-lg-12">
    
<?php
  $tableall=\yii::$app->db->schema->getTableNames();
  $source_table=array();
  foreach (  $tableall as   $tablealls=>$value){
   $source_table[$value]=$value;    
  } 
$form = ActiveForm::begin([ 'action' => ['index','id'=>$id],
        'method' => 'get','type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>3,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
         
         'academic_year_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Academic  Year',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => 'Academic  Year',
                    
                    ],
                ],
            ],
          'type' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Type',
                'options' => [
                    'data' =>  backend\modules\allocation\models\CriteriaField::getCriteriaFieldTypes(),
                    'options' => [
                        'prompt' => 'Select Type',
                    
                    ],
                ],
            ],
        'source_table' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Source Table',
                'options' => [
                    'data' =>$source_table,
                    'options' => [
                        'prompt' => 'Select Source Table',
                        'id'=>'source-table_field_Id'
                    
                    ],
                ],
            ],
    ]
]);
?>
 
 <div class="form-group pull-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
       
    </div>
 <?php
ActiveForm::end();
?>
    </div>
<div class="space12"></div>
