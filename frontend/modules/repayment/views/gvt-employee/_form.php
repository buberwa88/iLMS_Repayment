<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GvtEmployee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gvt-employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vote_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vote_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sub_vote')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_vote_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'check_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employment_date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
