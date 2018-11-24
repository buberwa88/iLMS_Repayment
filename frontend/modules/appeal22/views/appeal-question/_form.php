<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealQuestion */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="appeal-question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'question_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\Question::find()->orderBy('question_id')->asArray()->all(), 'question_id', 'question'),
        'options' => ['placeholder' => 'Choose Question'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'attachment_definition_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\AttachmentDefinition::find()->orderBy('attachment_definition_id')->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
        'options' => ['placeholder' => 'Choose Attachment definition'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
