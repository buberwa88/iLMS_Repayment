 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'cluster_name' => ['label' => 'Cluster Name', 'options' => ['placeholder' => 'Cluster Name']],
        'cluster_desc' => ['type' => Form::INPUT_TEXTAREA,
            'label' => 'Description',
        ],
        'priority_order' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'Status    ',
            'options' => [
                'data' => Yii::$app->params['priority_order_list'],
                'options'=>[
                    'prompt'=>'-- select --'
                ]
            ],
        ],
        'is_active' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'Status    ',
            'options' => [
                'data' => \backend\modules\allocation\models\ClusterDefinition::getStatusList(),
            ],
        ],
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
