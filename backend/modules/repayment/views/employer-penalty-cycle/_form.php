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
        'employer_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\repayment\models\Employer::find()->where('employer_type_id<>2')->all(), 'employer_id', 'employer_name'),
                'options' => [
                    'placeholder' => '-- All Employer --',
                ],
            ],
        ],
        'duration_type' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => backend\modules\repayment\models\EmployerPenaltyCycle::durationType(),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'penalty_rate' => [
            'type' => Form::INPUT_TEXT
        ],
        'duration' => ['type' => Form::INPUT_TEXT],
        'repayment_deadline_day' => ['type' => Form::INPUT_TEXT],
    ]
]);
?>

<?=
$form->field($model, 'start_date')->widget(DatePicker::classname(), [
    'name' => 'start_date',
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
$form->field($model, 'end_date')->widget(DatePicker::classname(), [
    'name' => 'end_date',
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
    ?>
    <?php
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
    ?>
</div>
<?php
ActiveForm::end();
?>

