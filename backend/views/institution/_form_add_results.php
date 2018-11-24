<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\allocation\models\Programme;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic  Year',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::getCurrentAndPreviousAcademicYears(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Academic  Year',
                ],
            ],
        ],
        'registration_number' => ['label' => 'Registration #', 'options' => ['placeholder' => 'Enter Registration Number']],
        'f4indexno' => ['label' => 'F4 Index #', 'options' => ['placeholder' => 'Enter F4 Index #']],
        'study_year' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Year Of Study',
            'options' => [
                'data' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                'options' => [
                    'prompt' => 'Year Of Study',
                ],
            ],
        ],
        'programme_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme',
            'options' => [
                'data' => ArrayHelper::map(Programme::getProgrammesByLearningInstitutionId($model->learning_institution_id, Programme::STATUS_ACTIVE), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => 'Programme',
                ],
            ],
        ],
        'exam_status_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Exam Status',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\ExamStatus::find()->asArray()->all(), 'exam_status_id', 'status_desc'),
                'options' => [
                    'prompt' => 'Select Exam Status',
                ],
            ],
        ],
        'semester' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Semester',
            'options' => [
                'data' => [1 => "Semester I", 2 => "Semester II", 3 => "Semester III"],
                'options' => [
                    'prompt' => 'Semester',
                ],
            ],
        ],
        'is_last_semester' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            //'label' => 'Semester',
            'options' => [
                'data' => [0 => "No", 1 => "Yes"],
                'options' => [
                    'prompt' => 'Select',
                ],
            ],
        ],
    ],
]);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['institution/exam-results'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
