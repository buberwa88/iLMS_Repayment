<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-batch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_batch_id')->textInput() ?>

    <?= $form->field($model, 'batch_number')->textInput() ?>

    <?= $form->field($model, 'batch_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'available_budget')->textInput() ?>

    <?= $form->field($model, 'is_approved')->textInput() ?>

    <?= $form->field($model, 'approval_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'is_canceled')->textInput() ?>

    <?= $form->field($model, 'cancel_comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
