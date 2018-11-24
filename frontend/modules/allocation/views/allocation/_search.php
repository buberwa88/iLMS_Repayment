<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-batch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_batch_id') ?>

    <?= $form->field($model, 'batch_number') ?>

    <?= $form->field($model, 'batch_desc') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'available_budget') ?>

    <?php // echo $form->field($model, 'is_approved') ?>

    <?php // echo $form->field($model, 'approval_comment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'is_canceled') ?>

    <?php // echo $form->field($model, 'cancel_comment') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
