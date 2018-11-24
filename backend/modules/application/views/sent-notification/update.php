<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\SentNotification $model
 */

$this->title = 'Update Sent Notification: ' . ' ' . $model->sent_notification_id;
$this->params['breadcrumbs'][] = ['label' => 'Sent Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sent_notification_id, 'url' => ['view', 'id' => $model->sent_notification_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sent-notification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
