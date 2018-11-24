<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanStudent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_plan_id')->textInput() ?>

    <?= $form->field($model, 'application_id')->textInput() ?>

    <?= $form->field($model, 'needness_amount')->textInput() ?>

    <?= $form->field($model, 'allocated_amount')->textInput() ?>

    <?= $form->field($model, 'study_year')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
