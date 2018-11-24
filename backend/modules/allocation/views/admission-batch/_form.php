 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
    <p>Click to Download
       <a target="_black" href="#">Excel Format : For Import Admitted Student/Applicant</a></p>
        
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
            'academic_year_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Academic Year',
                'options' => [
                    'data' =>ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => ' Select Academic',
                    
                    ],
                ],
            ],
         'batch_number'=>['label'=>'Batch  Number', 'options'=>['placeholder'=>'Batch Number']],
         'file'=>['type' => Form::INPUT_FILE,
               'label' => 'File',
            ],
         'batch_desc'=>['type' => Form::INPUT_TEXTAREA,
               'label' => 'Description',
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
