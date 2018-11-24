 
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
            'label' => 'From Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::getCurrentAndPreviousAcademicYears(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => '- Select - ',
                ],
            ],
        ],
        'source_study_year' => [
            'type' => Form::INPUT_WIDGET,
            'label' => 'From Year of Study',
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['programme_years_of_study'],
                'options' => [
                    'prompt' => 'Select years of Study',
                ],
            ],
        ], 'destination_academic_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'To Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::getNextCommingAcademicYears(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => '- Select - ',
                ],
            ],
        ], 'destination_study_year' => [
            'type' => Form::INPUT_WIDGET,
            'label' => 'To Year of Study',
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['programme_years_of_study'],
                'options' => [
                    'prompt' => 'Select years of Study',
                ],
            ],
        ],
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'To Learning Institution',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                'options' => [
                    'prompt' => ' Select Higher Learning Institution',
                ],
            ],
        ],
        'programme_name' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'To Programme Name',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->where(['is_active' => backend\modules\allocation\models\Programme::STATUS_ACTIVE])->asArray()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => ' Select Programme Group',
                ],
            ],
        ],
        'loan_items' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Loan Items',
            'options' => [
                'data' => ArrayHelper::map(backend\modules\allocation\models\ProgrammeCost::getProgrammeLoanItemsByProgrammeID($programme->programme_id), 'loan_item_id', 'loanItem.item_name'),
                'options' => [
                    'multiple' => true,
                    'prompt' => ' Select Programme Group',
                ],
            ],
        ],
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
