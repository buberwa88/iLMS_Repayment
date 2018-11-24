<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationTask */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="allocation-task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'allocation_task_id')->textInput(['placeholder' => 'Allocation Task']) ?>

    <?= $form->field($model, 'task_name')->textInput(['maxlength' => true, 'placeholder' => 'Task Name']) ?>

    <?= $form->field($model, 'accept_code')->textInput(['maxlength' => true, 'placeholder' => 'Accept Code']) ?>

    <?= $form->field($model, 'reject_code')->textInput(['maxlength' => true, 'placeholder' => 'Reject Code']) ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <div class="form-group">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
