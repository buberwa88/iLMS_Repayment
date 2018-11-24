
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
            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['IN', 'is_current', [\backend\modules\allocation\models\AcademicYear::IS_CURRENT_YEAR, \backend\modules\allocation\models\AcademicYear::IS_NOT_CURRENT_YEAR]])->orderBy('academic_year')->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'id' => 'academic-year',
                    'readonly' => TRUE, 'disabled' => TRUE
                ],
            ],
        ],
        'student_f4indexno' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => 'Enter Form-4 Index Number',
                'id' => 'f4-index-no'
            ],
        ],
        'student_reg_no' => ['type' => Form::INPUT_TEXT,
            'options' => ['prompt' => 'Entern Student Reg#',
                'id' => 'student-regno'
            ],
        ],
        'programme_from' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\depdrop\DepDrop::classname(),
            'options' => [
              //  'data' => ArrayHelper::map(\backend\modules\application\models\Programme::find()->orderBy('programme_name')->asArray()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'id' => 'programme-id',
                    'readonly' => TRUE, 'disabled' => TRUE
                ],
                'pluginOptions' => [
                    'depends' => ['f4-index-no', 'student-regno'],
                    'loading' => true,
                    'url' => \yii\helpers\Url::to(['/allocation/student-transfers/student-current-programme'])
                ],
            ],
        ],
        'programme_to' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\application\models\Programme::find()->where(['is_active' => backend\modules\allocation\models\Programme::STATUS_ACTIVE])
                                ->andWhere('programme_id !=:id', [':id' => $model->programme_from])->orderBy('programme_name')->asArray()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => '-- select --',
                ],
            ],
        ]
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
