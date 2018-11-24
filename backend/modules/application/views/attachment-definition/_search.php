<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\AttachmentDefinitionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attachment-definition-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'attachment_definition_id') ?>

    <?= $form->field($model, 'attachment_desc') ?>

    <?= $form->field($model, 'max_size_MB') ?>

    <?= $form->field($model, 'require_verification') ?>

    <?= $form->field($model, 'verification_prompt') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
