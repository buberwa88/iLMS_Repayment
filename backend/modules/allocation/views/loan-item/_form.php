 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'item_name' => ['label' => 'Item Name', 'options' => ['placeholder' => 'Item Name...']],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'item_code' => ['label' => 'Item Code', 'options' => ['placeholder' => 'Item Code...']],
    ]
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'rate_type' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Rate Type',
            'options' => [
                'data' => backend\modules\allocation\models\LoanItem::getItemRates(),
                'options' => [
                    'prompt' => 'Rate Type',
                ],
            ],
        ],
        'loan_item_category' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//                'label' => 'Status',
            'options' => [
                'data' => Yii::$app->params['loan_items_category'] ,
                'options' => [
                        'prompt' => '--select --',
                ],
            ],
        ],
        'study_level' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->asArray()->All(), 'applicant_category_id', 'applicant_category'),
                'options' => [
                    'prompt' => '--select--',
                ],
            ],
        ],
        'is_active' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//                'label' => 'Status',
            'options' => [
                'data' => backend\modules\allocation\models\LoanItem::getStatusList(),
                'options' => [
//                        'prompt' => '--select--',
                ],
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
