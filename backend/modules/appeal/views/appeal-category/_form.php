<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealCategory */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="appeal-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
 
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

     <?= $form->field($model, 'status')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [1=>'Active',0=>'InActive'],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <div class="form-group text-right">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
              <?=Html::resetButton('Reset', ['class'=>'btn btn-default']);?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
