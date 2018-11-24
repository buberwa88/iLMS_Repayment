<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerMonthlyPenaltySettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employer-monthly-penalty-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'employer_mnthly_penalty_setting_id') ?>

    <?= $form->field($model, 'employer_type') ?>

    <?= $form->field($model, 'payment_deadline_day_per_month') ?>

    <?= $form->field($model, 'penalty') ?>

    <?= $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
