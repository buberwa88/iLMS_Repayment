<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic  Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['in', 'is_current', [0, 1]])->orderBy('academic_year')->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Select Academic  Year',
                ],
            ],
        ],
        'study_level' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->asArray()->All(), 'applicant_category_id', 'applicant_category'),
                'options' => [
                    'id' => 'study-level',
                    'prompt' => '--select--',
                ],
            ],
        ],
        'loan_item_category' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['loan_items_category'],
                'options' => [
                    'id' => 'item-category',
                    'prompt' => '--select --',
                ],
            ],
        ],
        'loan_item_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\depdrop\DepDrop::classname(),
            'label' => 'Loan Item',
            'options' => [
                //  'data' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->asArray()->all(), 'loan_item_id', 'item_name'),
                'options' => [
                    'id' => 'loan_item-id',
                    'prompt' => '--Select Item --',
                ],
                'pluginOptions' => [
                    'depends' => ['item-category', 'study-level'],
                    'loading' => true,
                    'placeholder' => '--Select Item --',
                    'url' => \yii\helpers\Url::to(['/allocation/loan-item-priority/items'])
                ],
            ],
        ],
        'priority_order' => [
            'label' => 'Priority order',
            'options' => ['placeholder' => 'Enter priority order']
        ],
        'loan_award_percentage' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'placeholder' => ' Enter Minimum % of the amount to be awarded',
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
    ?>
</div>
