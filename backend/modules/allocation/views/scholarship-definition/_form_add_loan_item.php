<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $loan_item,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'scholarship_definition_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'loan_item_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->asArray()->all(), 'loan_item_id', 'item_name'),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'is_loan_item' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => backend\modules\allocation\models\ScholarshipLoanItem::getScholarshipLoanItemTypesOptions(),
                'options' => [
//                    'placeholder' => '-- Select --',
                ],
            ],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($loan_item->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
      <?= Html::a('Cancel', ['/allocation/scholarship-definition/view','id'=>$model->scholarship_id], ['class' => 'btn btn-warning']) ?>
   <?php
    ActiveForm::end();
    ?>
</div>


