<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
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
        
    ]
]);
echo $form->field($modelh, 'allocation_history_id')->widget(DepDrop::classname(), [
    'data'=> [9=>'Savings'],
    'options' => ['multiple' => true,'placeholder' => 'Select '],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['allocationbatch-contained_student'],
        'url' => Url::to(['/allocation/allocation-batch/allocation-history']),
        'loadingText' => 'Loading child level 2 ...',
    ]
]);
//echo Form::widget([ // fields with labels
//    'model'=>$modelh,
//    'form'=>$form,
//    'columns'=>1,
//    'attributes'=>[
//     'allocation_history_id' => ['type' => Form::INPUT_WIDGET,
//                'widgetClass' => \kartik\select2\Select2::className(),
//                'label' => 'Associated Loan Item',
//                
//               'widgetClass' => DepDrop::className(),
//                'options' => [
//                  'options' => ['multiple' => true,'placeholder' => 'Select Case Activity'],
//                    'data' =>  ArrayHelper::map(backend\modules\allocation\models\LoanItem::find()->where(["is_active" => 1])->all(), 'loan_item_id', 'item_name'),
//                    //'disabled' => $model->isNewrecord ? false : true,
//                    'pluginOptions' => [
//                        'depends' => ['allocationbatch-contained_student'],
//                        'placeholder' => 'Select ',
//                       
//                        'url' => Url::to(['/allocation/allocation-batch/allocation-history']),
//                    ],
//                ],
//            ],
//     //'batch_desc'=>['type' => Form::INPUT_TEXTAREA,'label'=>'Description', 'options'=>['placeholder'=>'Enter Description']],
//      
//    
//        
//    ]
//]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
     'batch_desc'=>['type' => Form::INPUT_TEXTAREA,'label'=>'Description', 'options'=>['placeholder'=>'Enter Description']],
      
    
        
    ]
]);
?>
<?= $form->field($model, 'academic_year_id')->label(FALSE)->hiddenInput(["value"=>$model_year->academic_year_id]) ?>
  <div class="text-right">
<?= Html::submitButton($model->isNewRecord ? 'create Batch' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
      
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      
 <?php ActiveForm::end(); ?>
    </div>
