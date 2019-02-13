<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-refund-internal-operational-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_internal_operational_id')->textInput(['placeholder' => 'Refund Internal Operational']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Code']) ?>

    <?= $form->field($model, 'access_role_master')->textInput(['maxlength' => true, 'placeholder' => 'Access Role Master']) ?>

    <?= $form->field($model, 'access_role_child')->textInput(['maxlength' => true, 'placeholder' => 'Access Role Child']) ?>

    <?php /* echo $form->field($model, 'flow_order_list')->textInput(['placeholder' => 'Flow Order List']) */ ?>

    <?php /* echo $form->field($model, 'is_active')->textInput(['placeholder' => 'Is Active']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
