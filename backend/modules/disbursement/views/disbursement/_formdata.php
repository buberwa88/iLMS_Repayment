<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\Disbursement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'disbursement_batch_id')->textInput() ?>

    <?= $form->field($model, 'application_id')->textInput() ?>

    <?= $form->field($model, 'programme_id')->textInput() ?>

    <?= $form->field($model, 'loan_item_id')->textInput() ?>

    <?= $form->field($model, 'disbursed_amount')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
