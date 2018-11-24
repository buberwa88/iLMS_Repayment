<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

// form with an id used for action buttons in footer
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL], [
           // 'enableAjaxValidation' => true,
            'action' => ['/allocation/allocation-plan/add-scenario', 'id' => $model->allocation_plan_id],
        ]);
?>
<?php
$model_scenario->allocation_plan_id = $model->allocation_plan_id;
echo Form::widget([// fields with labels
    'model' => $model_scenario,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'allocation_scenario' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => \backend\modules\allocation\models\AllocationPlanScenario::getAllocationPlanScenarios(),
                'options' => [
                    'prompt' => '-- Select Criteria--',
                ],
            ],
        ],
        'priority_order' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Priority Order',
            'options' => [
                'data' => Yii::$app->params['priority_order_list'],
                'options' => [
                    'prompt' => '-- Select Priority Order --',
                ],
            ],
        ],
]]);


?>

<div class="text-right">
    <?= Html::submitButton('save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/allocation/allocation-plan/view','id'=>$model->allocation_plan_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>


