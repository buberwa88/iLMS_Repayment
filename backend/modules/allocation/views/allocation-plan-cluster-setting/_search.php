<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanClusterSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-cluster-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_plan_cluster_setting_id') ?>

    <?= $form->field($model, 'allocation_plan_id') ?>

    <?= $form->field($model, 'cluster_definition_id') ?>

    <?= $form->field($model, 'cluster_priority') ?>

    <?= $form->field($model, 'student_percentage_distribution') ?>

    <?php // echo $form->field($model, 'budget_percentage_distribution') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
