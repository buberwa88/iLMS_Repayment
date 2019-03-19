<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\application\models\AttachmentDefinition;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-comment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=
    $form->field($model, 'attachment_definition_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(AttachmentDefinition::find()->orderBy('attachment_definition_id')->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
        'options' => ['placeholder' => 'Choose Attachment  '],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?=
    $form->field($model, 'reason_type')->widget(\kartik\widgets\Select2::classname(), [
        'data' => $model->getReasoGroups(),
        'options' => ['placeholder' => '--select--'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true, 'placeholder' => 'Comment']) ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
