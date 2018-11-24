 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model' => $model_clone,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Clone to Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::getNextCommingAcademicYears(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => '- Select - ',
                ],
            ],
        ],
        'allocation_plan_title' => ['type' => Form::INPUT_TEXT,
            'label' => 'New framework Name',
            'options' => [
                'placehoder' => 'Enter New Allocation Framework Name if any',
            ],
        ],
        'allocation_plan_desc' => ['type' => Form::INPUT_TEXT,
            'options' => ['prompt' => 'Enter Description IF any',
            ],
        ],
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton('Submit', ['class' => $model_clone->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
