<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipDefinitionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scholarship-definition-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'scholarship_id') ?>

    <?= $form->field($model, 'scholarship_name') ?>

    <?= $form->field($model, 'scholarship_desc') ?>

    <?= $form->field($model, 'sponsor') ?>

    <?= $form->field($model, 'country_of_study') ?>

    <?php // echo $form->field($model, 'start_year') ?>

    <?php // echo $form->field($model, 'end_year') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'closed_date') ?>

    <?php // echo $form->field($model, 'is_full_scholarship') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
