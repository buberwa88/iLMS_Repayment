<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'NID') ?>

    <?= $form->field($model, 'f4indexno') ?>

    <?= $form->field($model, 'f6indexno') ?>

    <?php // echo $form->field($model, 'mailing_address') ?>

    <?php // echo $form->field($model, 'date_of_birth') ?>

    <?php // echo $form->field($model, 'place_of_birth') ?>

    <?php // echo $form->field($model, 'loan_repayment_bill_requested') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
