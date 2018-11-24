<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\SentNotification $model
 */

$this->title = 'Create Sent Notification';
$this->params['breadcrumbs'][] = ['label' => 'Sent Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-notification-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
