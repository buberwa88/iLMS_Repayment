 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<div class="criteria-question-search col-lg-12">
    
<?php
$form = ActiveForm::begin([ 'action' => ['index','id'=>$id],
        'method' => 'get','type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>2,
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
                    'data' =>[ 1 =>'Eligibility',2=>'Needness'],
                    'options' => [
                        'prompt' => 'Select Type',
                    
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
