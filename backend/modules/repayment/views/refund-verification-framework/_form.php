<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFramework */
/* @var $form yii\widgets\ActiveForm */

 
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'RefundVerificationFrameworkItem', 
        'relID' => 'refund-verification-framework-item', 
        'value' => \yii\helpers\Json::encode($model->refundVerificationFrameworkItems),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
//
?>

<div class="refund-verification-framework-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'refund_type_id')->widget(\kartik\widgets\Select2::classname(), [
          'data' =>[1=>'NON-BENEFICIARY', 2=>'OVER-DEDUCTED', 3=>'DECEASED'],
        'options' => ['placeholder' => 'Choose Refund Type'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'verification_framework_title')->textInput(['maxlength' => true, 'placeholder' => 'Verification Framework Title']) ?>

    <?= $form->field($model, 'verification_framework_desc')->textInput(['maxlength' => true, 'placeholder' => 'Verification Framework Desc']) ?>
    <?= $form->field($model, 'is_active')->widget(\kartik\widgets\Select2::classname(), [
        'data' =>[1=>"Active",0=>'Inactive'],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'confirmed_by')->label(FALSE)->hiddenInput(['maxlength' => true, 'placeholder' => '','value'=>Yii::$app->user->identity->user_id]) ?>
    <?= $form->field($model, 'confirmed_at')->label(FALSE)->hiddenInput(['maxlength' => true, 'placeholder' => '','value'=>date("Y-m-d")]) ?>
    <?php
    $forms = [
       
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('RefundVerificationFrameworkItem'),
            'content' => $this->render('_formRefundVerificationFrameworkItem', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->refundVerificationFrameworkItems),
            ]),
        ],
      ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton('Clone/Copy', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
