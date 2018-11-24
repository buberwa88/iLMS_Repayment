<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $institution,
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
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                'options' => [
                    'prompt' => '-- Select --',
                    'multiple' => TRUE,
                ],
            ],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($institution->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
   <?= Html::a('Cancel', ['/allocation/scholarship-definition/view','id'=>$model->scholarship_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>





