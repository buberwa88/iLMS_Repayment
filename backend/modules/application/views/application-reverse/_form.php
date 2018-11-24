<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationReverse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-reverse-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'application_id')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reversed_by')->textInput() ?>

    <?= $form->field($model, 'reversed_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
