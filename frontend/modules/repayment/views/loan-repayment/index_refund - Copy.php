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
     $incomplete=0;
use yii\helpers\Html;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\ApplicantAttachment;
use backend\modules\application\models\ReattachmentSetting;
//$this->title = 'Welcome '. $modelApplicant->firstname.' '.$modelApplicant->othernames.' '.$modelApplicant->surname;
$this->title ='Refund Application';
$this->params['breadcrumbs'][] = 'Refund Application';
echo $jwded;exit;
?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
                </ul>
    <li class="list-group-item">Step 1: Pay Application Fee   <label class="label <?=  $modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"label-success":"label-danger";?> pull-right"><span class="glyphicon  <?=$modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label> </li>
    <li class="list-group-item">Step 2: Intended Level of Study<label class='label  <?= $step2==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$step2==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 3: Applicant Basic Information<label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item">Step 4: Primary Education  <label class='label  <?= Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 5: Form 4 Education <label class='label  <?= Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 6: Post form 4 Education <label class='label  <?= $alevel>0||$college>0||$other>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$alevel>0||$college>0||$other>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>

       </ul>
        </div>
        </div>
</div>
<?= $form->field($model, 'refund_type')->radio(['label' => 'Option 1', 'value' => 1, 'uncheck' => null]) ?>
<?= $form->field($model, 'refund_type')->radio(['label' => 'Option 2', 'value' => 0, 'uncheck' => null]) ?>
<?= $form->field($model, 'refund_type')->radio(['label' => 'Option 3', 'value' => 2, 'uncheck' => null]) ?>
<?= $form->field($model, 'refund_type')->radio(['label' => 'Option4', 'value' => 3, 'uncheck' => null]) ?>
    




 
