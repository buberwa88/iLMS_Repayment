<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-claimant-form">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    ?>
    <p>Please Enter PIN sent to your Mobile Number or Email</p>
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'pin' => ['label' => 'PIN', 'options' => ['placeholder' => 'Enter PIN']],
        ]
    ]);
    ?>
    <div class="text-right">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/default/home-page'], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
