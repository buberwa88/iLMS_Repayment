<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'disbursement_id') ?>

    <?= $form->field($model, 'disbursement_batch_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?= $form->field($model, 'loan_item_id') ?>

    <?php // echo $form->field($model, 'disbursed_amount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
