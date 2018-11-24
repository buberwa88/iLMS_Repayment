<script>
    function getNotification(notification_id){
        $('#contents_div_id_'+notification_id).html('<b><font color=green>Loading...</font></b>');
        var state = $('#notification_'+notification_id).attr('state');
        if(state == 'collapsed'){
                  $.ajax({
        url: '<?= yii\helpers\Url::to(['/notifications/get-notification'], true) ?>&notification_id='+notification_id,
        type: 'get',
        dataType: 'JSON',
        success: function(response){
          var notification =  response.notification;
           $('#contents_div_id_'+notification_id).html(notification);
           $('#notification_'+notification_id).attr('state','expanded');
           $('#notification_image_1_'+notification_id).attr('style','display:none');
           $('#notification_image_2_'+notification_id).attr('style','display:display');
        }
    });  
        } else {
          $('#contents_div_id_'+notification_id).html($('#summary_unbolded_'+notification_id).html());
          $('#notification_'+notification_id).attr('state','collapsed');
        }
       
        
    }
</script>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;


$this->registerAssetBundle(yii\web\JqueryAsset::className(), View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\NotificationSearch $searchModel
 */
$fullname = $modelApplicant->firstname.' '.$modelApplicant->othernames.' '.$modelApplicant->surname;
$this->title = 'Welcome '.$fullname;
$this->params['breadcrumbs'][] = 'Welcome';
$notifications = app\models\Notification::find()->where("user_id = {$modelApplicant->user_id}")->orderBy('date_created desc')->all();
$modelInst = app\models\Institution::findOne(1);

if($modelInst->application_status == 4 || $modelInst->application_status == 5){
    echo "<p style='color: #013ADF'><strong>Selection results are OUT. Click on the 'Selection Results' Menu to view</strong></p>";
}
?>
<div class="notification-index">
    <div class="list-group">
  <?php
  foreach ($notifications as $key => $notification) {
     $summary = str_replace('{fullname}',$fullname, $notification->notification);
        $summary = strip_tags($summary);
        $summary = substr($summary, 0, 120).". . .";
        $date = date('d M Y H:i:s', strtotime($notification->date_created));
        if($notification->is_read == 0){
            $display_summary = '<b>'.$summary.'</b>';
            $display_date = '<b>'.$date.'</b>';
            $display1 = 'display';
            $display2 = 'none';
        } else {
            $display_summary = $summary;
            $display_date = $date;
            $display1 = 'none';
            $display2 = 'display';
        }  
  echo '<a href="#" class="list-group-item" onclick="getNotification('.$notification->notification_id.')" state="collapsed" id="notification_'.$notification->notification_id.'">';
  echo '<h4 class="list-group-item-heading">'.Html::img('img/new_message_edited.gif',['width'=>35,'height'=>25,'style'=>'display: '.$display1, 'id'=>  'notification_image_1_'.$notification->notification_id]).Html::img('img/message_read.png',['width'=>35,'height'=>25,'style'=>'display: '.$display2,'id'=>  'notification_image_2_'.$notification->notification_id]).$notification->subject.'</h4>';
              
  echo '<div class="list-group-item-text" id="contents_div_id_'.$notification->notification_id.'">'.$display_summary.'<span class="pull-right">'.$display_date.'</span>  </div>';
  echo '<div id="summary_unbolded_'.$notification->notification_id.'" style="display:none"><p class="list-group-item-text">'.$summary.'<span class="pull-right">'.$date.'</span>  </p></div>';
  echo '</a>';
  }
  
   ?>     
   
</div>

</div>
