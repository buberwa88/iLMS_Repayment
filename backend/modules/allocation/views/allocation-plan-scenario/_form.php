<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkScenario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-framework-scenario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_framework_id')->textInput() ?>

    <?= $form->field($model, 'allocation_scenario')->textInput() ?>

    <?= $form->field($model, 'priority_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
