<?php
 use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//contained_student
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'contained_student' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'contained Student',
                'options' => [
                    'data' => [1=>"New applicant",2=>"Continuing student"],
                    'options' => [
                        'prompt' => '',
                    
                    ],
                ],
            ],
        'batch_number'=>['label'=>'Batch Number', 'options'=>['placeholder'=>'Enter Batch Number']],
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
       
    'available_budget'=>['label'=>'Available Budget', 'options'=>['placeholder'=>'Enter Available Budget']],  
    'batch_desc'=>['type' => Form::INPUT_TEXTAREA,'label'=>'Description', 'options'=>['placeholder'=>'Enter Description']],
      
    
        
    ]
]);
?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Allocate' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>
