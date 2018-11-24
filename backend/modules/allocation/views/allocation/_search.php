<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_id') ?>

    <?= $form->field($model, 'allocation_batch_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'loan_item_id') ?>

    <?= $form->field($model, 'allocated_amount') ?>

    <?php // echo $form->field($model, 'is_canceled') ?>

    <?php // echo $form->field($model, 'cancel_comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
