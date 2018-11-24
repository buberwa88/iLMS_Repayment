<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
?>

<div class="programme-search">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,'method'=>'GET']);
    echo Form::widget([// fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'academic_year' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Academic Year',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'id' => 'academic_year',
                        'placeholder' => '--select--'
                    ],
                ],
            ],
            'programme_group_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme Group',
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeGroup::find()->where(['is_active' => backend\modules\allocation\models\ProgrammeGroup::STATUS_ACTIVE])->asArray()->all(), 'programme_group_id', 'group_name'),
                    'options' => [
                        'prompt' => ' Select Programme Group',
                    ],
                ],
            ],
            'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Higher Learning Institution',
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' -- Select Institution --',
                    ],
                ],
            ],
            'programme_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme Name',
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                    'options' => [
                        'prompt' => '-- Select Programme --',
                    ],
                ],
            ],
            'year_of_study' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Year of Study',
                'options' => [
                    'data' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4',],
                    'options' => [
                        'prompt' => '--Select--',
                    ],
                ],
            ]
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
