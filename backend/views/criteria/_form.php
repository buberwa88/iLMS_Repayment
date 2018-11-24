<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Criteria */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="criteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'criteria_id')->textInput(['placeholder' => 'Criteria']) ?>

    <?= $form->field($model, 'criteria_description')->textInput(['maxlength' => true, 'placeholder' => 'Criteria Description']) ?>

    <?= $form->field($model, 'criteria_origin')->textInput(['placeholder' => 'Criteria Origin']) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
