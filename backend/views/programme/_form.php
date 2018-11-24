<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Programme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'learning_institution_id')->textInput() ?>

    <?= $form->field($model, 'programme_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'programme_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'years_of_study')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
