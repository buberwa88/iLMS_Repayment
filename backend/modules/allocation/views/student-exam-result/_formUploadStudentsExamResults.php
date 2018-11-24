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
    ]
]); 
echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'semester'=>[
        'type'=>Form::INPUT_WIDGET, 
                 'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Semester',
                'options' => [
                    'data' =>[1=>"Semester I",2=>"Semester II",3=>"Semester III"],
                    'options' => [
                        'prompt' => 'Semester',
                    
                    ],
                ],
            ],
        'is_last_semester'=>[
        'type'=>Form::INPUT_WIDGET, 
                 'widgetClass' => \kartik\select2\Select2::className(),
                //'label' => 'Semester',
                'options' => [
                    'data' =>[0=>"No",1=>"Yes"],
                    'options' => [
                        'prompt' => 'Select',
                    
                    ],
                ],
            ],
        'students_exam_results_file'=>['type' => Form::INPUT_FILE,
               //'label' => 'File',
            ],
        ],
]);
?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Upload' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['indexpending'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>
