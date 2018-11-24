<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use wbraganca\dynamicform\DynamicFormWidget;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="customer-form">
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'dynamic-form']);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['in', 'is_current', [0, 1]])->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'id' => 'academic_year',
                    'placeholder' => '--select--'
                ],
            ],
        ],
        'programme_category_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Category',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeCategory::find()->asArray()->all(), 'programme_category_id', 'programme_category_name'),
                'options' => [
                    'prompt' => 'Select Programme Category',
                    'id' => 'programme_category'
                ],
            ],
        ]
    ]
]);
?>
<?= $form->field($model, 'cluster_definition_id')->label(FALSE)->hiddenInput(["value" =>$cluster_id]) ?>
   <div class="row">
   <div class="panel panel-default">
        <div class="panel-body" style="margin: 0;">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 1, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $ClusterProgramme[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'programme_group_id',
                    'programme_priority',
                ],
            ]); ?>

           
                <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($ClusterProgramme as $i => $ClusterProgramme2): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Programmes</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                         <div class="col-sm-5">
                            <?php
echo Form::widget([ // fields with labels
    'model'=>$ClusterProgramme2,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[	
           "[{$i}]programme_group_id" => [
                'class' => "[{$i}]programme_group_id",
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(backend\modules\allocation\models\ProgrammeGroup::find()->asArray()->all(), 'programme_group_id', 'group_name'), 'options' => ['prompt' => '-- Select --'],                
            ],
]
]);
?>
                        </div>                        
                        <div class="col-sm-5">                        
                        <?= $form->field($ClusterProgramme2, "[{$i}]programme_priority")->dropDownList([ '1' => '1', '2' => '2', '3' => '3', '4' => '4', ], ['prompt' => 'Select']) ?>    

                    </div>
                
            <?php endforeach; ?>
            </div>            
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
       </div>
    </div>
    </div>
    

    <div class="text-right">        
		<?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        <?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index','id'=>$cluster_id], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
