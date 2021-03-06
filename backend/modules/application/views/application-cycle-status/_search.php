<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationCycleStatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-cycle-status-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'application_cycle_status_id') ?>

    <?= $form->field($model, 'application_cycle_status_name') ?>

    <?= $form->field($model, 'application_cycle_status_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
