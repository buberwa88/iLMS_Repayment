<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationTaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-allocation-task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_task_id')->textInput(['placeholder' => 'Allocation Task']) ?>

    <?= $form->field($model, 'task_name')->textInput(['maxlength' => true, 'placeholder' => 'Task Name']) ?>

    <?= $form->field($model, 'accept_code')->textInput(['maxlength' => true, 'placeholder' => 'Accept Code']) ?>

    <?= $form->field($model, 'reject_code')->textInput(['maxlength' => true, 'placeholder' => 'Reject Code']) ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
