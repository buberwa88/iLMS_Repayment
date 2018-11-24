<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $student,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'scholarship_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['in', 'is_current', [0, 1]])->orderBy('academic_year')->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'student_f4indexno' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => '-- Enter Form 4 Index Number --',
            ],
        ],
        'student_f6indexno' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => '-- Enter Form 6 Index Number --',
            ],
        ],
        'student_firstname' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => '-- Enter Firs Name --',
            ],
        ],
        'student_lastname' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => '-- Enter Last Name --',
            ],
        ],
        'student_middlenames' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => '-- Enter Other Names --',
            ],
        ],
        'student_admission_no' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => '-- Enter Student Admission Number --',
            ],
        ],
        'programme_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'multiple' => FALSE,
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($student->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
     <?= Html::a('Cancel', ['/allocation/scholarship-definition/view','id'=>$model->scholarship_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>





