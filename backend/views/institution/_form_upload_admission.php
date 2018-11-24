<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,
            'options' => ['enctype' => 'multipart/form-data', 'method' => 'POST'],
        ]);
?>      
<?php
/// echo strtotime(date('Y-m-d H:i:s'));
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Learning Institution',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                'options' => [
                    'prompt' => '-- Select --',
                ],
            ],
        ],
        'batch_number' => [
            'label' => 'Admission Batch  No.',
            'options' => ['placeholder' => 'Batch Number']
        ],
        'batch_desc' => ['type' => Form::INPUT_TEXTAREA,
            'label' => 'Batch Description',
            'options' => ['placeholder' => 'Batch Descrption Details']
        ],
        'students_admission_file' => ['type' => Form::INPUT_FILE,
            'label' => 'Admission Data File',
        ],
        'academic_year_id' => ['type' => Form::INPUT_HIDDEN,
        ],
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Upload' : 'Upload', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
