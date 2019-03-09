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

<div class="refund-claimant-form" style="margin: 1%;width: 100%;">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    ?>
    <?php
    echo $form->errorSummary($model, ['class' => 'errorSummary']);
    ?>
    <div class="text-left" style="position: relative;float: left;width: 55% !important;margin: 1%;margin-top: 35px;">

        <?php
        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'trustee_identity' => ['label' => 'Enter Your Phone/Email:', 'options' => ['placeholder' => 'Enter your Mobile No or Email Address used during refund application']],
            ]
        ]);
        ?>
    </div>
    <div style="position: relative;float: left; clear: right;margin: 1%;width: 35% !important;">

        <?=
        $form->field($model, 'verificationCode')->widget(Captcha::className(), [
            'captchaAction' => '/site/captcha', 'id' => 'captcha_block_id'
        ])
        ?>
    </div>
    <div class="text-right" style="clear:both;margin-right:7.2%;">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

        <?php
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/view-refund'], ['class' => 'btn btn-warning']);
        ActiveForm::end();
        ?>
    </div>
