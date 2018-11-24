<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'is_full_scholarship' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Grant/Scholarship Type',
            'options' => [
                'data' => backend\modules\allocation\models\ScholarshipDefinition::getGrantTypes(),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'scholarship_name' => ['type' => Form::INPUT_TEXT,
            'label' => 'Grant/Scholarship Name',
            'options' => [
                'placeholder' => 'Enter description information abou the grant/scholarship',
            ],
        ],
        'scholarship_desc' => ['type' => Form::INPUT_TEXT,
            'label' => 'Grant/Scholarship Description',
            'options' => [
                'placeholder' => 'Enter description information abou the grant/scholarship',
            ],
        ],
        'sponsor' => ['type' => Form::INPUT_TEXT,
            'label' => 'Sponsor',
            'options' => [
                'placeholder' => 'Enter Sponsor Details',
            ]
        ],
        'start_year' => ['type' => Form::INPUT_TEXT,
//            'widgetClass' => \kartik\date\DatePicker::className(),
            'label' => 'Start Year',
            'options' => [
                'placeholder' => 'Enter Year',
            ],
        ],
        'end_year' => ['type' => Form::INPUT_TEXT,
//            'widgetClass' => \kartik\date\DatePicker::className(),
            'label' => 'End Year',
            'options' => [
                'placeholder' => 'Enter Year',
            ],
        ],
        'country_of_study' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Country of Study',
            'options' => [
                'data' => ArrayHelper::map(\common\models\Country::find()->asArray()->all(), 'country_code', 'country_name'),
                'options' => [
                    'placeholder' => '--select--',
                ],],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning        ']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>

