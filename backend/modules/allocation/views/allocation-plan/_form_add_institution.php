<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $institution,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'institution_type' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => backend\modules\allocation\models\LearningInstitution::getOwneshipsList(),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'student_distribution_percentage' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => 'Enter Student % composition',
            ],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($institution->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/allocation/allocation-plan/view','id'=>$model->allocation_plan_id], ['class' => 'btn btn-warning        ']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>


