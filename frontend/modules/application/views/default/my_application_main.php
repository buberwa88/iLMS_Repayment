<?php
use yii\helpers\Url;
?>

<script>
   function getIframeContents(id){
    
      var url = document.getElementById(id).src;
      
      $('#'+id).contents().find('html').html('<strong><font color="green">Loading....</font></strong>')
      $('#'+id).attr('src', url); 
   } 
   
   function viewSittinResults(url){
      $('#sitting-subjects-iframe').contents().find('html').html('<strong><font color="green">Loading....</font></strong>')
      $('#sitting-subjects-dialog').dialog('open');
      $('#sitting-subjects-iframe').attr('src', url); 
   }
   
   function changeStep(direction){
      var current_step = $('#application_steps_id').val();
      var new_step = current_step + direction;
      if(new_step < 1 || new_step > 8 ){
          return;
      }
      var url;
      switch(new_step){
          case 1:
              url = <?= Url::to(['/application/applicant/pay-application-fee']) ?>
              break;
          case 2:
              break;
          case 3:
              break;
          case 4:
              break;
          case 5:
              break;
          case 6:
              break;
          case 7:
              break;
          case 8:
              break;
          default:
              return;
       }
       
       $('#application_steps_id').attr('src', url); 
   }
</script>

<style>
    iframe{
        border: 0;
    }
    
/*    #loader-image{
        width: 150px;
        height: 100px;
        position: fixed;
        margin-left: 10%;
        margin-bottom: 10%;
        z-index: 3000;
        
        
    }*/
</style>

<?php
use kartik\tabs\TabsX;
//$this->title = 'Welcome '. $modelApplicant->firstname.' '.$modelApplicant->othernames.' '.$modelApplicant->surname;
$this->title = "Fill Application";
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
echo "<center>";
echo yii\helpers\Html::button("Previous", ['onclick'=>'changeStep(-1)']);
echo "&nbsp;&nbsp;&nbsp;";
$items = [
    1=>'Step1: Application Fee ',
    
    2=>'Step2: My Profile ',
    3=>'Step3: Primary Education ',
    4=>'Step4: Form IV Education ',
    5=>'Step5: Post form IV Education ',
    6=>'Step6: Guardian Details ',
    7=>'Step7: Guarantor Details ',
    8=>'Step8: Attachments ',
];
echo yii\helpers\Html::dropDownList('application_steps', null, $items, ['id'=>'application_steps_id']);
echo "&nbsp;&nbsp;&nbsp;";
echo yii\helpers\Html::button("Next", ['onclick'=>'changeStep(1)']);
echo "</center>";
?>
<iframe src=" <?= \yii\helpers\Url::to(['/application/applicant/pay-application-fee']) ?>" width="100%" height="500px" id="content_iframe_id"></iframe>',



 