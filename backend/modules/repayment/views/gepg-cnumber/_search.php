<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgCnumberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-cnumber-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'response_message') ?>

    <?= $form->field($model, 'retrieved') ?>

    <?= $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'trsxsts') ?>

    <?php // echo $form->field($model, 'trans_code') ?>

    <?php // echo $form->field($model, 'date_received') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
