<?php

//use kartik\password\StrengthValidator;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;
$verificationStatus = \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatusGeneral();
$verificationStatus2 = \backend\modules\repayment\models\RefundVerificationResponseSetting::getVerificationResponCode();
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'verification_status' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Status:',
            'options' => [
                'data' =>$verificationStatus,
                'options' => [
                    'prompt' => 'Select ',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'reason' => ['label' => 'Response'],
		'response_code' => ['label' => 'Response Code'],
		/*
		'response_code' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Response Code:',
            'options' => [
                'data' =>$verificationStatus2,
                'options' => [
                    'prompt' => 'Select ',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
		*/
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
    ?>

    <?php
    ActiveForm::end();
    ?>
</div>