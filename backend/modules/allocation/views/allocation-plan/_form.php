<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'academic_year_id' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['IN', 'is_current', [\backend\modules\allocation\models\AcademicYear::IS_CURRENT_YEAR, \backend\modules\allocation\models\AcademicYear::IS_NOT_CURRENT_YEAR]])->orderBy('academic_year')->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => '-- select --',
                ],
            ],
        ],
        'allocation_plan_title' => ['type' => Form::INPUT_TEXT,
            'options' => ['prompt' => 'Select Academic  Year',
            ],
        ],
        'allocation_plan_desc' => ['type' => Form::INPUT_TEXT,
            'options' => ['prompt' => 'Select Academic  Year',
            ],
        ],
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
