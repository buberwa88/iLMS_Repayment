<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'AllocationUserStructure', 
        'relID' => 'allocation-user-structure', 
        'value' => \yii\helpers\Json::encode($model->allocationUserStructures),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="allocation-structure-form">
 
    <?php 
    $form = ActiveForm::begin();
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'attributes'=>[
            'structure_name'=>['label'=>'Structure Name', 'options'=>['placeholder'=>'Structure Name']],
            'parent_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Parent',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\allocation\models\AllocationStructure::find()->asArray()->all(), 'allocation_structure_id', 'structure_name'),
                    'options' => [
                        'prompt' => 'Parent Item',
                        
                        
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            'order_level'=>['label'=>'Order Level', 'options'=>['placeholder'=>'Order Level']],
            'status' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Status',
                'options' => [
                    'data' =>[1=>'Active',2=>'Inactive'],
                    'options' => [
                        'prompt' => 'Status',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            
        ]
    ]);
    
    ?>
   
    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('AllocationUserStructure'),
            'content' => $this->render('_formAllocationUserStructure', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->allocationUserStructures),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
     <?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
