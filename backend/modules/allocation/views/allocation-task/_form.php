<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationTask */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="allocation-task-form">

    <?php $form = ActiveForm::begin(); ?>
 
    <?= $form->field($model, 'task_name')->textInput(['maxlength' => true, 'placeholder' => 'Task Name']) ?>

    <?= $form->field($model, 'accept_code')->textInput(['maxlength' => true, 'placeholder' => 'Accept Code']) ?>

    <?= $form->field($model, 'reject_code')->textInput(['maxlength' => true, 'placeholder' => 'Reject Code']) ?>
    <?= $form->field($model, 'status')->label(false)->dropDownList(
                                [0=>"In Active",1=>'Active'], 
                                [
                                'prompt'=>'[--Select Status--]',
                                ]
                    ) ?> 
    <div class="form-group text-right">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
      <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
      <?= Html::resetButton('Reset', ['class'=>'btn btn-default']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
