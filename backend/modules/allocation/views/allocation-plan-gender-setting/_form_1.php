<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanGenderSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-gender-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_plan_id')->textInput() ?>

    <?= $form->field($model, 'female_percentage')->textInput() ?>

    <?= $form->field($model, 'male_percentage')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
