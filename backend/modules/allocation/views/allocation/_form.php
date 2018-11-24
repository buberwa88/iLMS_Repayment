<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Allocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_batch_id')->textInput() ?>

    <?= $form->field($model, 'application_id')->textInput() ?>

    <?= $form->field($model, 'loan_item_id')->textInput() ?>

    <?= $form->field($model, 'allocated_amount')->textInput() ?>

    <?= $form->field($model, 'is_canceled')->textInput() ?>

    <?= $form->field($model, 'cancel_comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
