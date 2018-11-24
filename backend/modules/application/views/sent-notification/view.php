<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\SentNotification $model
 */

$this->title = $model->sent_notification_id;
$this->params['breadcrumbs'][] = ['label' => 'Sent Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-notification-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'sent_notification_id',
            'cnotification_id',
            'description',
            'target_group',
            'user_sent',
            [
                'attribute' => 'date_sent',
                'format' => [
                    'datetime', (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime']))
                        ? Yii::$app->modules['datecontrol']['displaySettings']['datetime']
                        : 'd-m-Y H:i:s A'
                ],
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => DateControl::classname(),
                    'type' => DateControl::FORMAT_DATETIME
                ]
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->sent_notification_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
