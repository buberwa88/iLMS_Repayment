 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;

\backend\modules\allocation\models\AllocationPriority::gettableColumnName($model->source_table);
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'fork']);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

        'source_table' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Source Table',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\SourceTable::find()->all(), 'source_table_id', 'source_table_name'),
                'options' => [
                    'prompt' => 'Select Source Table',
                    'id' => 'source-table_field_Id'
                ],
            ],
        ],
        'field_value' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Response Value',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => \backend\modules\allocation\models\AllocationPriority::gettableColumnName($model->source_table),
                //'disabled' => $model->isNewrecord ? false : true,
                'pluginOptions' => [
                    'depends' => ['source-table_field_Id'],
                    'placeholder' => 'All Source Table Field',
                    'url' => Url::to(['/allocation/allocation/gettable-column-name']),
                ],
            ],
        ],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic  Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Academic  Year',
                ],
            ],
        ],
        'priority_order' => ['label' => 'Priority Order', 'options' => ['placeholder' => '']],
        'baseline' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Baseline',
            'options' => [
                'data' =>  yii::$app->params['AllocationBaseline'],
                'options' => [
                    'prompt' => 'Select Baseline ',
                ],
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
