<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationBudget */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
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
                'data' => \yii\helpers\ArrayHelper::map(backend\modules\allocation\models\AcademicYear::find()->where(['IN', 'is_current', [backend\modules\allocation\models\AcademicYear::IS_NOT_CURRENT_YEAR, backend\modules\allocation\models\AcademicYear::IS_CURRENT_YEAR]])->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Academic Year',
                ],
            ],
        ], 'study_level' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Level of Study',
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\allocation\models\ApplicantCategory::find()->asArray()->All(), 'applicant_category_id', 'applicant_category'),
                'options' => [
                    'prompt' => '--select--',
                ],
            ],
        ],
        'applicant_category' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Applicant Category',
            'options' => [
                'data' => backend\modules\allocation\models\AllocationBudget::applicantCategoryList(),
                'options' => [
                    'prompt' => '--select --',
                ],
            ],
        ],
        'place_of_study' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//                'label' => 'Status',
            'options' => [
                'data' => backend\modules\allocation\models\AllocationBudget::getPlaceOfStudies(),
                'options' => [
                    'prompt' => '--select --',
                ],
            ],
        ],
        'budget_scope' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => backend\modules\allocation\models\AllocationBudget::getScopeList(),
                'options' => [
                    'prompt' => '--select--',
                ],
            ],
        ], 'budget_amount' => [
            'type' => Form::INPUT_TEXT,
        ], 'is_active' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => backend\modules\allocation\models\AllocationBudget::getStatusList(),
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
    ?></div>
