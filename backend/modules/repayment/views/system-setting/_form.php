<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\SystemSetting */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'setting_name' => ['label' => 'Item Name'],
        'setting_code' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Item Code',
            'options' => [
                'data' => \backend\modules\repayment\models\SystemSetting::getItemListCode(),
                'options' => [
                    'prompt' => 'Select',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'setting_value' => ['label' => 'Rate'],
    ]
]);
?>
<?= $form->field($model, 'value_data_type')->dropDownList([ 'PERCENT' => 'PERCENT', 'AMOUNT' => 'AMOUNT', 'DAY' => 'DAY'], ['prompt' => '']) ?>
<?php
/*
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'item_formula' => ['label' => 'Item Formula'],
    ]
]);
*/
?>
<?=
$form->field($model, 'graduated_from')->widget(DatePicker::classname(), [
    'name' => 'graduated_from',
    //'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
<?=
$form->field($model, 'graduated_to')->widget(DatePicker::classname(), [
    'name' => 'graduated_to',
    //'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>

<?php $model->isNewRecord == 1 ? $model->is_active = 1 : $model->is_active; ?>
    <?= $form->field($model, 'is_active')->radioList(array(1 => 'Active', '0' => 'Inactive')); ?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
    ?>

    <?php
    ActiveForm::end();
    ?>
</div>
