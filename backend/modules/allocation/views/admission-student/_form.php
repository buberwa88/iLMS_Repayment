<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data']]);
 ?>      
 <?php
/// echo strtotime(date('Y-m-d H:i:s'));
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution',
                'options' => [
                    'data' =>ArrayHelper::map(frontend\modules\application\models\LearningInstitution::find()->where(["institution_type"=>"UNIVERSITY"])->asArray()->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution',
                    
                    ],
                ],
            ],
        // 'batch_number'=>['label'=>'Batch  Number', 'options'=>['placeholder'=>'Batch Number']],
         'students_admission_file'=>['type' => Form::INPUT_FILE,
               //'label' => 'File',
            ],
         'batch_desc'=>['type' => Form::INPUT_TEXTAREA,
               'label' => 'Description',
            ],
      
        
    ]
]);
 
 ?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Upload' : 'Upload', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>
