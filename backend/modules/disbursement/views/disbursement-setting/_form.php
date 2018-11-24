  
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
 use yii\helpers\Url;
use yii\helpers\Html;
 $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'id'=>'fork']);
  
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
         'instalment_definition_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Instalment',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\disbursement\models\InstalmentDefinition::findAll(["is_active" => 1]), 'instalment_definition_id', 'instalment'),
                    'options' => [
                        'prompt' => 'Select Instalment',
                         
                    
                    ],
                ],
            ],
        'loan_item_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Loan Item',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\allocation\models\LoanItem::findAll(["is_active" => 1]), 'loan_item_id', 'item_name'),
                    'options' => [
                        'prompt' => 'Select Loan Item',
                        'id'=>'loan_item_Id'
                    
                    ],
                ],
            ],
    'percentage'=>['label'=>'Value(%)', 'options'=>['placeholder'=>'']],    
 
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
  </div>
