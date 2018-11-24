<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\SystemSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'system_setting_id') ?>

    <?= $form->field($model, 'setting_name') ?>

    <?= $form->field($model, 'setting_code') ?>

    <?= $form->field($model, 'setting_value') ?>

    <?= $form->field($model, 'value_data_type') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
