<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormat */
/* @var $form yii\widgets\ActiveForm */
 
?>

<div class="refund-letter-format-form">

    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'letter_code')->widget(\kartik\widgets\Select2::classname(), [
        'data' =>[1=>"Active",0=>'Inactive'],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'letter_name')->textInput(['maxlength' => true, 'placeholder' => 'Letter Name']) ?>
    
   <?= $form->field($model, 'header')->textInput(['maxlength' => true, 'placeholder' => 'Header']) ?>
   <?= $form->field($model, 'footer')->textInput(['maxlength' => true, 'placeholder' => 'Footer']) ?>
   <?= $form->field($model, 'letter_body')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance'
    ]) ?>
    <?= $form->field($model, 'is_active')->widget(\kartik\widgets\Select2::classname(), [
        'data' =>[1=>"Active",0=>'Inactive'],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <div class="form-group">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
