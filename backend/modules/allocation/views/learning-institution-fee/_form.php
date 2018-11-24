 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

        'academic_year_id' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['is_current' => 1])->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Academic year ',
                ],
            ],
        ],
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Institution/School',
            'options' => [
                'data' => ArrayHelper::map(backend\modules\allocation\models\LearningInstitution::getNonHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                'options' => [
                    'prompt' => 'Institution/School ',
                ],
            ],
        ],
        'study_level' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Level of Study',
            'options' => [
                'data' => backend\modules\allocation\models\LearningInstitution::getSecondarySchoolsStudyLevels(),
                'options' => [
                    'prompt' => 'Select Level of Study'
                ],
            ],
        ],
        'fee_amount' => [
            'label' => 'Annul Fee Amount',
            'options' => ['placeholder' => 'Enter Annual Fee Amount']
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
