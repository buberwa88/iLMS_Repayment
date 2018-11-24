<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\SentNotificationSearch $searchModel
 */

$this->title = 'Send Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-notification-index">
    <?php 
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'sent_notification_id',
            [
              'label'=>'Message Subject' ,
               'value'=>function($model){
                return app\models\Cnotification::findOne($model->cnotification_id)->subject;
               }
            ],
            //'description',
            [
              'label'=>'Target Group',
              'value'=>function($model){
                  
                     $groups = app\models\SentNotification::getTargetGroups(); 
                     return $groups[$model->target_group];
                  
              }
            ],
           [
             'label'=>'Sent',
             'value'=>function($model){
                return number_format(app\models\Notification::find()->where("sent_notification_id = {$model->sent_notification_id}")->count());
             },
             'hAlign'=>'right',
             'format'=>'raw',
           ],
                      [
             'label'=>'Read',
             'value'=>function($model){
                return number_format(app\models\Notification::find()->where("sent_notification_id = {$model->sent_notification_id} and is_read = 1")->count());
             },
             'hAlign'=>'right',
             'format'=>'raw',
           ],
            //'user_sent',
           [
             'label'=>'Date',
             'attribute'=>'date_sent',
           ],
            //['attribute' => 'date_sent','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 

//            [
//                'class' => 'yii\grid\ActionColumn',
//                'buttons' => [
//                    'update' => function ($url, $model) {
//                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
//                            Yii::$app->urlManager->createUrl(['sent-notification/view', 'id' => $model->sent_notification_id, 'edit' => 't']),
//                            ['title' => Yii::t('yii', 'Edit'),]
//                        );
//                    }
//                ],
//            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'default',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', '', ['class' => 'btn btn-success','onclick'=>"$('#sending-notification-dialog-id').dialog('open'); return false;"]),
           // 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); 
    
                 Dialog::begin([
//    'clientOptions' => [
//        'modal' => true,
//        'autoOpen' => false,
//        'height' => '400',
//        'width' => '600'
//    ],
    'options' => [
        'title' => 'Sending Notification',
        'id' => 'sending-notification-dialog-id'
    ]
        ]
);
 echo $this->render('_form',['model'=>$model]);
Dialog::end();  
?>
   

</div>
