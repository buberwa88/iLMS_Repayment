<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programme-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'programme_id') ?>

    <?= $form->field($model, 'learning_institution_id') ?>

    <?= $form->field($model, 'programme_code') ?>

    <?= $form->field($model, 'programme_name') ?>

    <?= $form->field($model, 'years_of_study') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
