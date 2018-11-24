<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="learning-institution-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'learning_institution_id') ?>

    <?= $form->field($model, 'institution_type') ?>

    <?= $form->field($model, 'institution_code') ?>

    <?= $form->field($model, 'institution_name') ?>

    <?= $form->field($model, 'institution_phone') ?>

    <?php // echo $form->field($model, 'institution_address') ?>

    <?php // echo $form->field($model, 'ward_id') ?>

    <?php // echo $form->field($model, 'bank_account_number') ?>

    <?php // echo $form->field($model, 'bank_account_name') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'bank_branch_name') ?>

    <?php // echo $form->field($model, 'entered_by_applicant') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'contact_firstname') ?>

    <?php // echo $form->field($model, 'contact_middlename') ?>

    <?php // echo $form->field($model, 'contact_surname') ?>

    <?php // echo $form->field($model, 'contact_email_address') ?>

    <?php // echo $form->field($model, 'contact_phone_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
