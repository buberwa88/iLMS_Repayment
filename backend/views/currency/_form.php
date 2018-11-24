<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currency_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_postfix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
