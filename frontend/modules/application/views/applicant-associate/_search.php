<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-associate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'applicant_associate_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'organization_name') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'middlename') ?>

    <?php // echo $form->field($model, 'surname') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'postal_address') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'physical_address') ?>

    <?php // echo $form->field($model, 'email_address') ?>

    <?php // echo $form->field($model, 'NID') ?>

    <?php // echo $form->field($model, 'occupation_id') ?>

    <?php // echo $form->field($model, 'passport_photo') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'learning_institution_id') ?>

    <?php // echo $form->field($model, 'ward_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
