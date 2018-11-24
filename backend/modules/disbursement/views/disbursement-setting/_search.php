<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursement-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'disbursement_setting_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'instalment_definition_id') ?>

    <?= $form->field($model, 'loan_item_id') ?>

    <?= $form->field($model, 'percentage') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
