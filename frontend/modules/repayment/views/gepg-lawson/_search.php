<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GepgLawsonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-lawson-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gepg_lawson_id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'control_number') ?>

    <?= $form->field($model, 'control_number_date') ?>

    <?php // echo $form->field($model, 'deduction_month') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'gepg_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
