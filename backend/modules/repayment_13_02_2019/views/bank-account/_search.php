<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\BankAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bank_account_id') ?>

    <?= $form->field($model, 'bank_id') ?>

    <?= $form->field($model, 'branch_name') ?>

    <?= $form->field($model, 'account_name') ?>

    <?= $form->field($model, 'account_number') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
