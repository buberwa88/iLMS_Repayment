<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSetting */
/* @var $form yii\widgets\ActiveForm */
 
?>

<div class="refund-internal-operational-setting-form">

    <?php $form = ActiveForm::begin(); ?>
 
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Code']) ?>

    <?= $form->field($model, 'access_role_master')->textInput(['maxlength' => true, 'placeholder' => 'Access Role Master']) ?>

    <?= $form->field($model, 'access_role_child')->textInput(['maxlength' => true, 'placeholder' => 'Access Role Child']) ?>

    <?= $form->field($model, 'flow_order_list')->textInput(['placeholder' => 'Flow Order List']) ?>
    
   <?= $form->field($model, 'is_active')->textInput(['placeholder' => 'Is Active']) ?>
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
