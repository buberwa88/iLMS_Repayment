<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionContactSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="learning-institution-contact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'learning_institution_id') ?>

    <?= $form->field($model, 'cp_firstname') ?>

    <?= $form->field($model, 'cp_middlename') ?>

    <?= $form->field($model, 'cp_surname') ?>

    <?= $form->field($model, 'cp_email_address') ?>

    <?php // echo $form->field($model, 'cp_phone_number') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'signature') ?>

    <?php // echo $form->field($model, 'is_signator') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
