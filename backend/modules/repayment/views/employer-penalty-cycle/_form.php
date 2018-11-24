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
        'setting_code' => ['label' => 'Item Code'],
        'setting_value' => ['label' => 'Rate'],
    ]
]);
?>
<?= $form->field($model, 'employer_id')->dropDownList([ 'PERCENT' => 'PERCENT', 'AMOUNT' => 'AMOUNT', 'DAY' => 'DAY'], ['prompt' => '']) ?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'penalty_rate' => ['label' => 'Pernalty Rate'],
        'duration' => ['label' => 'Duration'],
        'duration_type' => ['label' => 'duration type'],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
    ?>
    <?php $model->isNewRecord == 1 ? $model->is_active = 1 : $model->is_active; ?>
    <?= $form->field($model, 'is_active')->radioList(array(1 => 'Active', '0' => 'Inactive')); ?>


</div>
<?php
ActiveForm::end();
?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerPenaltyCycle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employer-penalty-cycle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'cycle_type')->dropDownList([ '0', '1',], ['prompt' => '']) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
