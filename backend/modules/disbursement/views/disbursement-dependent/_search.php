<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementDependentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursement-dependent-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'disbursement_setting2_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'instalment_definition_id') ?>

    <?= $form->field($model, 'loan_item_id') ?>

    <?= $form->field($model, 'associated_loan_item_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
