<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\SentNotificationSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sent-notification-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'sent_notification_id') ?>

    <?= $form->field($model, 'cnotification_id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'target_group') ?>

    <?= $form->field($model, 'user_sent') ?>

    <?php // echo $form->field($model, 'date_sent') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
