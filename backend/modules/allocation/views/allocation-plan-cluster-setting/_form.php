<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanClusterSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-cluster-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allocation_plan_id')->textInput() ?>

    <?= $form->field($model, 'cluster_definition_id')->textInput() ?>

    <?= $form->field($model, 'cluster_priority')->textInput() ?>

    <?= $form->field($model, 'student_percentage_distribution')->textInput() ?>

    <?= $form->field($model, 'budget_percentage_distribution')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
