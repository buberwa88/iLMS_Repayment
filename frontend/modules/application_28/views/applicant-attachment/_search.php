<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\ApplicantAttachmentSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="applicant-attachment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'applicant_attachment_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'attachment_definition_id') ?>

    <?= $form->field($model, 'attachment_path') ?>

    <?= $form->field($model, 'verification_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
