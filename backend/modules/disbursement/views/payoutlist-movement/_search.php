<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payoutlist-movement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'movement_id') ?>

    <?= $form->field($model, 'disbursement_batch_id') ?>

    <?= $form->field($model, 'from_officer') ?>

    <?= $form->field($model, 'to_officer') ?>

    <?= $form->field($model, 'movement_status') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
