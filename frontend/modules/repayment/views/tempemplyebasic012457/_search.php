<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Tempemplyebasic012457Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tempemplyebasic012457-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'loan_repayment_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'old_amount') ?>

    <?= $form->field($model, 'new_amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
