<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Allocation Plan',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AllocationPlan::find()->asArray()->all(), 'allocation_plan_id', 'allocation_plan_title'),
                'options' => [
                    'prompt' => '-- select --',
                ],
            ],
        ],
        'female_percentage'=>['label'=>'Female Percentage'],
        //'male_percentage'=>['label'=>'Male Percentage'],
    ],
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