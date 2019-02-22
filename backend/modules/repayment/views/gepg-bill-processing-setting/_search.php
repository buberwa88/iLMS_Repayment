<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBillProcessingSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bill-processing-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gepg_bill_processing_setting_id') ?>

    <?= $form->field($model, 'bill_type') ?>

    <?= $form->field($model, 'bill_processing_uri') ?>

    <?= $form->field($model, 'bill_prefix') ?>

    <?= $form->field($model, 'operation_type') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
