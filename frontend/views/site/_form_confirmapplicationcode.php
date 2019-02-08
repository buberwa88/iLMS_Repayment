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
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
?>
    <?php
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'attributes'=>[
            'applicationCode'=>['label'=>'Code:', 'options'=>['placeholder'=>'Enter Code']],
        ]
    ]);
    ?>
    <?= $form->field($model, 'refundClaimantid')->label(false)->hiddenInput(['value'=>$id,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction'=>'/site/captcha','id'=>'captcha_block_id'
    ]) ?>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Confirm' : 'Confirm', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
        ActiveForm::end();
        ?>
    </div>
