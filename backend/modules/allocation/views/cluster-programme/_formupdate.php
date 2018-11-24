
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
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
      'programme_category_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme Category',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\allocation\models\ProgrammeCategory::find()->asArray()->all(), 'programme_category_id', 'programme_category_name'),
                    'options' => [
                        'prompt' => 'Select Programme Category',
                        //'onchange'=>'myprogramme(this)',
                        'allowClear' => true,
                        'id'=>'programme_category_Id',
                        'disabled' => true,
                    ],
                ],
            ],
			
		'programme_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->where(['programme_id'=>$model->programme_id])->asArray()->all(), 'programme_id', 'programme_name'),
                    'options' => [
                        'prompt' => 'Select Programme Category',
                        //'onchange'=>'myprogramme(this)',
                        'allowClear' => true,
                        'id'=>'programme_id',
                       'disabled' => true,
                    ],
                ],
            ],	
        'programme_priority'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme Priority',
              
                'options' => [
                    'data' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4'],
                    'options' => [
                        'prompt' => 'Select ',
                   
                    ],
                ],
             ],
    ]
]);
/*
echo $form->field($model, 'programme_id')->widget(DepDrop::classname(), [
    'data'=>ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->where(['programme_id'=>$model->programme_id])->asArray()->all(), 'programme_id', 'programme_name'),
    'options' => ['placeholder' => 'Select ...'],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['programme_category_Id'],
        'url' => Url::to(['/allocation/programme/getprogrammename']),
        'loadingText' => 'Loading child level 3 ...'
    ]
]);
*/
?>
 
  <div class="text-right">
         <?= $form->field($model, 'cluster_definition_id')->label(FALSE)->hiddenInput(["value"=>$model->isNewRecord?$cluster_id:$model->cluster_definition_id]) ?>
  
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
        <?= Html::a('Cancel', ['index','id'=>$model->cluster_definition_id], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>