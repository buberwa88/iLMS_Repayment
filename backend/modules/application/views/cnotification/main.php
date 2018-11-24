<script>
  function RefreshWindow(){
    /alert('How are you?');
//    var url = $('#send-notifications-frame-id').attr('src'); 
//    $('#send-notifications-frame-id').attr('src',url);
//
  }  
</script>

<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

$this->title = 'Manage Notifications';
$this->params['breadcrumbs'][] = $this->title;


echo TabsX::widget([
    'items' => [
        [
           'label'=>'Compose Messages',
           'content'=>'<iframe src="'.yii\helpers\Url::to(['/application/cnotification/index']).'" width="100%" height="400px" style="border: 0"></iframe>',
           'id'=>'1',
        ],
       
        [
           'label'=>'Send Messages',
           'content'=>'<div onclick="RefreshWindow()"><iframe src="'.yii\helpers\Url::to(['/application/sent-notification/index/']).'" width="100%" height="400px" style="border: 0"  id="send-notifications-frame-id"></iframe></div>',
           'id'=>'2',
        ],
        
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);


?>