<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\disbursement\models\Instalment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instalment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'instalment_id')->textInput() ?>

    <?= $form->field($model, 'instalment')->textInput() ?>

    <?= $form->field($model, 'instalment_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
