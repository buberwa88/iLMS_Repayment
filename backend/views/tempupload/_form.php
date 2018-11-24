<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Tempupload */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tempupload-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file')->fileInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
