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
$this->title = "My Application (".strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname).")";
$this->params['breadcrumbs'][] = 'My Application';
    echo TabsX::widget([
    'items' => [
        
        
         [
          'label'=>'<div onclick="getIframeContents(\'pay-application-fee\')">Step 1: Application Fee</div>',
          
          'content'=>'<iframe src="'.yii\helpers\Url::to(['/application/applicant/pay-application-fee']).'" width="100%" height="500px" id="pay-application-fee"></iframe>',
          'id'=>'pay-application-fee-tab',
          
        ],
    
        [
          'label'=>'<div onclick="getIframeContents(\'general-information\')">Step 2: Personal Details</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/general-information']).'" width="100%" height="500px" id="general-information"></iframe>',
          'id'=>'general-information-tab',
          
        ],

        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 3: Priminary Information</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'tab10',
          
        ],
       
        
        [
            'label'=>'<div onclick="getIframeContents(\'academic-qualification\')">Step 4: Primary Education</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/academic-qualification/']).'" width="100%" height="400px" id="academic-qualification"></iframe>',
          'id'=>'academic-qualification-tab',
          
        ],
        
        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 5: Post Form IV Education</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'programme-choices-tab',
          
        ],
        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 6: Tertiary Education</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'tab5',
          
        ],
        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 7: Gurdian Details</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'tab6',
          
        ],
        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 8: Guarantor Details</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'tab7',
          
        ],
        
        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 9: Attachments</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'tab8',
          
        ],
        
        [
          'label'=>'<div onclick="getIframeContents(\'programme-choices\')">Step 10: Declaration & Signature</div>',
          
          //'content'=>'<iframe src="'.yii\helpers\Url::to(['/applicants/programme-choices']).'" width="100%" height="500px" id="programme-choices"></iframe>',
          'id'=>'tab9',
          
        ],
//  
    
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => false,
    'encodeLabels' => false
]);
    
    
 
//yii\jui\Dialog::begin([
//    'clientOptions' => [
//        'modal' => true,
//        'autoOpen' => false,
//        'height' => '500',
//        'width' => '750'
//            ],
//            'options' => [
//                'title' => 'Exam Sitting Results',
//                'id' => 'sitting-subjects-dialog'
//            ]
//                ]
//           );
//    
//    echo "<iframe src='' class='list-group-item' id='sitting-subjects-iframe' width='100%' height='100%'></iframe>";
//    \yii\jui\Dialog::end();
?>

<!--<img id="loader-image" src="img/loading.gif">-->



 