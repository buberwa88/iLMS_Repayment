<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFrameworkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-framework-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'verification_framework_id') ?>

    <?= $form->field($model, 'verification_framework_title') ?>

    <?= $form->field($model, 'verification_framework_desc') ?>

    <?= $form->field($model, 'verification_framework_stage') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'confirmed_by') ?>

    <?php // echo $form->field($model, 'confirmed_at') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
