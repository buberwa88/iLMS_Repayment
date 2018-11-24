 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'source_academic_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Clone Loan Item From Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::getCurrentAndPreviousAcademicYears(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => '- Select ource Year - ',
                ],
            ],
        ],
        'destination_academic_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Clone to Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::getNextCommingAcademicYears(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => '- Select Destination - ',
                ],
            ],
        ],
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
