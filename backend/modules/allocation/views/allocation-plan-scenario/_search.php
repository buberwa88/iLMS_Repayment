<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkScenarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-framework-scenario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_framework_scenario_id') ?>

    <?= $form->field($model, 'allocation_framework_id') ?>

    <?= $form->field($model, 'allocation_scenario') ?>

    <?= $form->field($model, 'priority_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
