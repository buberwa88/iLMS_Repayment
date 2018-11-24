<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Tempemplyebasic012457 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tempemplyebasic012457-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'loan_repayment_id')->textInput() ?>

    <?= $form->field($model, 'applicant_id')->textInput() ?>

    <?= $form->field($model, 'old_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
