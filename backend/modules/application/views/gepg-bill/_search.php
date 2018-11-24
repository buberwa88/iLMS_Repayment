<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBillSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'bill_request') ?>

    <?= $form->field($model, 'retry') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'response_message') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'cancelled_reason') ?>

    <?php // echo $form->field($model, 'cancelled_by') ?>

    <?php // echo $form->field($model, 'cancelled_date') ?>

    <?php // echo $form->field($model, 'cancelled_response_status') ?>

    <?php // echo $form->field($model, 'cancelled_response_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
