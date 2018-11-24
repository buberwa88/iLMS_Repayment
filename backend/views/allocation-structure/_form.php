<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?php $form = ActiveForm::begin(); ?>
 
    <?= $form->field($model, 'structure_name')->textInput(['maxlength' => true, 'placeholder' => 'Structure Name']) ?>

    <?= $form->field($model, 'parent_id')->textInput(['placeholder' => 'Parent']) ?>

    <?= $form->field($model, 'order_level')->textInput(['placeholder' => 'Order Level']) ?>
   <?= $form->field($model, 'status')->label(false)->dropDownList(
                                [0=>"In Active",1=>'Active'], 
                                [
                                'prompt'=>'[--Select Status--]',
                                ]
                    ) ?> 
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
    </div>

    <?php ActiveForm::end(); ?>

</div>
