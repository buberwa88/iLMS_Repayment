<?php
$incomplete=0;
use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundClaimantEmployment;
use yii\bootstrap\Modal;
 
/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        
$modelRefundApplication = RefundApplication::find()->where("refund_application_id={$model->refund_application_id}")->one();
$modelRefundClaimant = RefundClaimant::find()->where("refund_claimant_id={$modelRefundApplication->refund_claimant_id}")->one();
$modelRefundClaimantEducHistory = RefundClaimantEducationHistory::find()->where("refund_application_id={$modelRefundApplication->refund_application_id}")->all();
$modelRefundClaimantEmploymentDet = RefundClaimantEmployment::find()->where("refund_application_id={$modelRefundApplication->refund_application_id}")->all();
if($modelRefundApplication->refund_type_id==1){
$title="APPLICATION FOR REFUND AS NON-BENEFICIARY";	
}else if($modelRefundApplication->refund_type_id==2){
$title="APPLICATION FOR REFUND AS OVER-DEDUCTED";		
}else if($modelRefundApplication->refund_type_id==3){
$title="APPLICATION FOR REFUND DECEASED";		
}
$this->title =$title;
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>

<?php
       $vieqw=0;
	   //if($vieqw==1){
?>

       <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund','id'=>$modelRefundApplication->refund_claimant_id])?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa  fa-power-off"></i> Logout</a>       

 </div>

   <div class="panel-body">
       <div class="row" style="margin: 1%;">
           <div class="col-xs-10">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title">Step 1: Form 4 Education </h3>
                       <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund','id'=>$modelRefundApplication->refund_claimant_id])?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                   </div>

                   <div class="box">
                       <!-- /.box-header -->
                       <div class="box-body no-padding">
                           <table class="table table-condensed">
                               <tr>
                                   <td>First Name: </td>
                                   <td><b><?= $modelRefundClaimant->firstname;?></b></td>
                                   <td>Middle Name: </td>
                                   <td><b><?= $modelRefundClaimant->middlename;?></b></td>
                                   <td>Last Name: </td>
                                   <td><b><?= $modelRefundClaimant->surname;?></b></td>
                               </tr>

                               <tr>
                                   <td>Academic Certificate Document:</td>
                                   <td colspan="5"><?php
                                       if ($modelRefundClaimant->f4_certificate_document != '') {
                                           ?>
                                           <embed src="<?= $modelRefundClaimant->f4_certificate_document; ?>" width="800" height="300">
                                       <?php
                                       } else {
                                           return "No Image";
                                       }
                                       ?></td>
                               </tr>
                           </table>
                       </div>
                       <!-- /.box-body -->
                   </div>
               </div>
           </div>
       </div>
       <div class="row" style="margin: 1%;">
           <div class="col-xs-10">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title">Step 2: Tertiary Education Details</h3>
                       <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund','id'=>$modelRefundApplication->refund_claimant_id])?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                   </div>

                   <div class="box">
                       <!-- /.box-header -->
                       <div class="box-body no-padding">
                           <table class="table table-condensed">
                               <?php foreach($modelRefundClaimantEducHistory AS $educationHistory){
                                   //if(!$educationHistory->certificate_document){
                                   ?>

                               <tr>
                                   <td>Study Level: </td>
                                   <td><b><?= $educationHistory->studylevel->applicant_category;?></b></td>
                                   <td>Institution: </td>
                                   <td><b><?= $educationHistory->institution->institution_name;?></b></td>
                                   <td>Programme: </td>
                                   <td><b><?= $educationHistory->program->programme_name;?></b></td>
                                   <td>Entry Year: </td>
                                   <td><b><?= $educationHistory->entry_year;?></b></td>
                                   <td>Completion Year: </td>
                                   <td><b><?= $educationHistory->completion_year;?></b></td>
                               </tr>
                                       <?php //}?>

                                   <?php if($educationHistory->certificate_document){
                                       ?>
                                       <tr>
                                           <td>Academic Certificate Document</td>
                                           <td colspan="9"><?php
                                               if ($educationHistory->certificate_document != '') {
                                                   ?>
                                                   <embed src="<?= $educationHistory->certificate_document; ?>" width="800" height="300">
                                                   <?php
                                               } else {
                                                   return "No Image";
                                               }
                                               ?></td>
                                       </tr>
                                   <?php } ?>


                               <?php
                               } ?>
                           </table>
                       </div>
                       <!-- /.box-body -->
                   </div>
               </div>
           </div>
       </div>
       <div class="row" style="margin: 1%;">
           <div class="col-xs-10">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title">Step 3: Employment Details</h3>
                       <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund','id'=>$modelRefundApplication->refund_claimant_id])?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                   </div>

                   <div class="box">
                       <!-- /.box-header -->
                       <div class="box-body no-padding">
                           <table class="table table-condensed">
                               <?php foreach($modelRefundClaimantEmploymentDet AS $employmentDetails){
                                   //if(!$educationHistory->certificate_document){
                                   ?>

                                   <tr>
                                       <td>Employer Name: </td>
                                       <td><b><?= $employmentDetails->employer_name;?></b></td>
                                       <td>Employee ID/Check #: </td>
                                       <td><b><?= $employmentDetails->employee_id;?></b></td>
                                       <td>Start Date: </td>
                                       <td><b><?= $employmentDetails->start_date;?></b></td>
                                       <td>End Date: </td>
                                       <td><b><?= $employmentDetails->end_date;?></b></td>
                                   </tr>
                                   <?php //}?>

                                   <?php if($employmentDetails->first_slip_document ){
                                       ?>
                                       <tr>
                                           <td>First Salary/Pay Slip Document</td>
                                           <td colspan="8"><?php
                                               if ($employmentDetails->first_slip_document != '') {
                                                   ?>
                                                   <a href="<?= Yii::$app->urlManager->createUrl([$employmentDetails->first_slip_document])?>"target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-eye"></i>Download</a>
                                                   <?php
                                               } else {
                                                   return "No Document";
                                               }
                                               ?></td>
                                       </tr>
                                   <?php } ?>
                                   <?php if($employmentDetails->second_slip_document ){
                                       ?>
                                       <tr>
                                           <td>Second Salary/Pay Slip Document</td>
                                           <td colspan="9"><?php
                                               if ($employmentDetails->second_slip_document != '') {
                                                   ?>
                                                   <a href="path/to/image.jpg" alt="Image description" target="_blank" style="display: inline-block; width: 50px; height; 50px; background-image: url(<?=$employmentDetails->second_slip_document;?>);">VIEW</a>
                                                   <?php
                                               } else {
                                                   return "No Document";
                                               }
                                               ?></td>
                                       </tr>
                                   <?php } ?>


                                   <?php
                               } ?>
                           </table>
                       </div>
                       <!-- /.box-body -->
                   </div>
               </div>
           </div>
       </div>

   <div class="rowQA">
                <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/refund-liststeps']);?></div>
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
            </div>
   </div>
</div>
</div>
<?php

$this->registerJs("    
                $('.view-image-link').click(function()
                {
                    $.get
                        (
                            'viewimage',
                            {
                                id: $(this).data('id')
                            },
                            function(data) 
                            {
                                $('.modal-body').html(data);
                                $('#imageview').modal();
                            }
                        );
                });");

Modal::begin([ 'id' => 'imageview', 'footer' => '<a href="#" class="btn btn-sm btn-primary" data-dismiss="modal">Close</a>', ]);

Modal::end();
?>
