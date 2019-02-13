<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[	
	    'employer_group_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Employer Group',
            'options' => [
                'data' => ArrayHelper::map(backend\modules\repayment\models\EmployerGroup::findBySql('SELECT employer_group_id,group_name FROM `employer_group`')->asArray()->all(), 'employer_group_id', 'group_name'),
                'options' => [
                    'prompt' => 'Select Group',
                //'onchange'=>'ShowHideDivRepaymentItemType()',
                //'id' => 'loan_repayment_item_id',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],	
         'employer_type'=>['label'=>'Employer Type', 'options'=>['placeholder'=>'Employer Type']],
         'has_TIN'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Has TIN?',              
                'options' => [
                    'data' => ['1'=>'Yes', '2'=>'No'],
                    'options' => [
                        'prompt' => 'Select Option',
                   
                    ],
                ],
             ], 
        'is_active'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Is Active',              
                'options' => [
                    'data' => ['1'=>'Active', '0'=>'Inactive'],
                    'options' => [
                        'prompt' => 'Select Option',
                   
                    ],
                ],
             ],				 
    ]
]);
 ?>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employer-type/index'], ['class' => 'btn btn-warning']);?>
  
<?php
ActiveForm::end();
?>
    </div>
