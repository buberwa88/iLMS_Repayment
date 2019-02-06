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
        'columns'=>2,
        'attributes'=>[
            'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name']],
            'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
            'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
            'phone_number'=>['label'=>'Phone #:', 'options'=>['placeholder'=>'Phone #']],
            'email'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address']],
            //'refund_type'=>['label'=>'Refund Type:', 'options'=>['placeholder'=>'Refund Type']],
            'refund_type'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Refund Type:',

                'options' => [
                    'data' => ['1'=>'NON-BENEFICIARY', '2'=>'OVER DEDUCTED','3'=>'DECEASED'],
                    'options' => [
                        'prompt' => 'Select ',

                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
        ]
    ]);
    ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction'=>'/site/captcha','id'=>'captcha_block_id'
    ]) ?>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Sign Up' : 'Sign Up', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/default/home-page'], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
