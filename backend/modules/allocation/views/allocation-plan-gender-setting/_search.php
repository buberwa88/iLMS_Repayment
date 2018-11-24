<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanGenderSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-plan-gender-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_plan_gender_setting_id') ?>

    <?= $form->field($model, 'allocation_plan_id') ?>

    <?= $form->field($model, 'female_percentage') ?>

    <?= $form->field($model, 'male_percentage') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
