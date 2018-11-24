<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;

$model_special_group->allocation_plan_id = $model->allocation_plan_id;
// form with an id used for action buttons in footer
// form with an id used for action buttons in footer
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL], [
            'enableAjaxValidation' => true,
            'method' => 'POST',
            'action' => ['allocation-framework/add-special-group', 'id' => $model->allocation_plan_id],
        ]);

echo Form::widget([// fields with labels
    'model' => $model_special_group,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => ['type' => Form::INPUT_HIDDEN],
        'allocation_group_criteria_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\Criteria::getAllocationSpecialGroups(),'criteria_id','criteria_description'),
                'options' => [
                    'prompt' => '-- Select --',
                ],
            ],
        ],
        'group_description' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '-- Enter Special Group Description--',
            ],
        ],
        'priority_order' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['priority_order_list'],
                'options' => [
                    'prompt' => '-- Select --',
                ],
            ],
        ],
]]);
?>

<div class="text-right">
    <?= Html::submitButton($model_special_group->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/allocation/allocation-plan/view', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning        ']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>

