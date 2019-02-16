<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundStatusReasonSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-status-reason-setting-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=
    $form->field($model, 'category')->widget(\kartik\widgets\Select2::classname(), [
        'data' => $model->getApplcationProcessingSections(),
        'options' => ['placeholder' => 'Choose Category'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?=
    $form->field($model, 'status')->widget(\kartik\widgets\Select2::classname(), [
        'data' =>$model->getStatusTypes(),// [1 => "Valid", 2 => "Invalid", 3 => "Waiting", 4 => "Incomplete"],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true, 'placeholder' => 'Reason']) ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->controller->action->id != 'create'): ?>
            <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
