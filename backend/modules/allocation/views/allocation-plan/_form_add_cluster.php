<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $cluster,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'cluster_definition_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\ClusterDefinition::find()->where(['is_active' => \backend\modules\allocation\models\ClusterDefinition::STATUS_ACTIVE])->asArray()->all(), 'cluster_definition_id', 'cluster_name'),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'cluster_priority' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['priority_order_list'],
                'options' => [
                    'prompt' => '-- Select --',
                ],
            ],
        ],
        'student_percentage_distribution' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '-- Enter % Distribution in Student--',
            ],
        ],
        /*
        'budget_percentage_distribution' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '-- Enter % contibution in the Budget --',
            ],
        ],
        */
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($cluster->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/allocation/allocation-plan/view','id'=>$model->allocation_plan_id], ['class' => 'btn btn-warning        ']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>





