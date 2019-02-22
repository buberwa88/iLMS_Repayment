<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Url;
use common\models\ApplicantQuestion;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use backend\modules\repayment\models\RefundApplicationOperation;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
$detailsRefundApplication=\backend\modules\repayment\models\RefundApplicationOperation::getApplicationDEtails($application_id);
if($model->verification_response==-1){
$currentResonse="Waiting";
$sendasx=0;
$showSend=0;
}else{
$currentResonse1=\backend\modules\repayment\models\RefundVerificationResponseSetting::findOne($model->verification_response);
$currentResonse=$currentResonse1->reason;
$response_code=$currentResonse1->response_code;
$sendasx=1;
$Temporary_stop_Deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Temporary_stop_Deduction_letter;
$Permanent_stop_deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Permanent_stop_deduction_letter;
$Issue_denial_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Issue_denial_letter;
if($response_code==$Temporary_stop_Deduction_letter || $response_code==$Permanent_stop_deduction_letter ||  $response_code==$Issue_denial_letter){
$showSend=1;
}else{
$showSend=0;
}
}

$this->title ="Refund Application Verification # ".$detailsRefundApplication->application_number;

//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Refund', 'url' => Yii::$app->request->referrer];
$this->params['breadcrumbs'][] = $this->title;
$list = [1 => 'Confirm'];
if($access_role_master=='audit_investigation_department'){
    $verificationStatus = \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatusAuditSection();
}else{
    $verificationStatus = \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatus();
}


?>

<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>


   <div class="panel-body">

    <div class="row" style="margin: 1%;">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><b>CLAIMANT  DETAILS</b></h3>
                </div>
                <?php $fullname = $model->refundClaimant->firstname.' '.$model->refundClaimant->middlename.' '.$model->refundClaimant->surname;
                $application_id1=$application_id;
                $released=$released;
                $verificationStatus1=$verificationStatus;
                ?>
                <p>
                    &nbsp;Full Name:-<b><?= $fullname;?></b><br/>
                    &nbsp;Form IV Index No:- <b><?= $model->refundClaimant->f4indexno;?></b><br/>
                    <br/><br/><br/>
                </p>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="box box-primary">
              <div class="box-header">
                  <h3 class="box-title"><b>CLAIMANT DETAILS MATCHING STATUS</b></h3>
              </div>     
               <?php $fullname = $model->refundClaimant->firstname.' '.$model->refundClaimant->middlename.' '.$model->refundClaimant->surname;
			   $application_id1=$application_id;
                           $released=$released;
                           $verificationStatus1=$verificationStatus;
			   ?>   
               <p>
                 &nbsp;F4index #:-<b><?php if($model->refundClaimant->applicant_id > 0){echo "Count 1";} ?></b><br/>
                  Claimant Names:-<b><?php if($model->refundClaimant->applicant_id > 0){echo "Count 1";} ?></b><br/>
                 &nbsp;Previous Refund Exists:- <b></b><br/>
                 <br/><br/><br/>
              </p>
          </div>
        </div>
        
    </div>
       <div class="row" style="margin: 1%;">
           <div class="col-xs-12">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title"><b>VERIFICATION RESPONSE</b></h3>
                   </div>
                   <table class="table table-condensed">
                       <tr>
                           <td>Status:</td>
                           <td><b><?php echo $currentResonse; ?></b></td>
                           <td><?php
                               if($sendasx==1){
                                   if($showSend==1){
                                   echo Html::a('VIEW AND SEND', ['/repayment/loan-beneficiary/view-loanee-details', 'id' =>$applicantID]);
                                   }
                               }
                               ?></td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
       <div class="row" style="margin: 1%;">
           <div class="col-xs-12">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title"><b>CLAIMANT LOAN</b></h3>
                   </div>
                   <table class="table table-condensed">
                       <tr>
                           <td>Total Loan:</td>
                           <td><b><?php
                                  //$applicantID=30;
                                   $applicantID=$detailsRefundApplication->refundClaimant->applicant_id;
                                   $date=date("Y-m-d");
                                   $loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
                                   echo number_format(backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($applicantID,$date,$loan_given_to),2); ?></b></td>
                           <td>Amount Paid:</td>
                           <td><b><?php
                                  echo  number_format(\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicantID,$date,$loan_given_to),2);
                                   ?></b></td>
                           <td>Balance:</td>
                           <td><b><?php
                                  echo number_format(\frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($applicantID,$date,$loan_given_to),2);
                                   ?></b></td>
                           <td><?php
                               if($applicantID > 0){
                              echo Html::a('VIEW DETAIL', ['/repayment/loan-beneficiary/view-loanee-details', 'id' =>$applicantID]);
                               }
                               ?></td>
                       </tr>
                   </table>



               </div>
           </div>
       </div>
   <div class="row" style="margin: 1%;">
      <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><b>CLAIMANT ATTACHMENTS</b></h3>
                </div>     
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],            
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model,$modelRefundAppOper) use($fullname,$application_id1,$released){
                  return $this->render('verificationlevel',['model'=>$model,'fullname' => $fullname,'application_id'=>$application_id1,'released'=>$released,'modelRefundAppOper'=>$modelRefundAppOper]);
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
             [
                     'attribute' => 'attachment_definition_id',
                        'label'=>"Verification Item",
                        'value' => function ($model) {
                            return $model->attachmentDefinition->attachment_desc;							
                        },
             ],          
             [
                'attribute' => 'verification_status',
                    'value' => function ($model) use($application_id1){
						$resultsPath=\backend\modules\repayment\models\RefundVerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id1);
						
                       if($resultsPath->verification_status == 0){
                            return Html::label("UNVERIFIED", NULL, ['class'=>'label label-default']);
                            } else if($resultsPath->verification_status == 1) {
                            return Html::label("VALID", NULL, ['class'=>'label label-success']);
                            }
                              else if($resultsPath->verification_status == 2) {
                            return Html::label("INVALID", NULL, ['class'=>'label label-danger']);
                            }
                               else if($resultsPath->verification_status == 3) {
                                        return Html::label("WAITING", NULL, ['class'=>'label label-warning']);
                                    }else if($resultsPath->verification_status == 4) {
                                        return Html::label("INCOMPLETE", NULL, ['class'=>'label label-danger']);
                                    }
                        },
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ], 					
             [
               'attribute' => 'comment',
                'label' => 'Verification Status Reason',
				'value' => function ($model) use($application_id1) {
     $resultsPath=\backend\modules\repayment\models\RefundVerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id1);
                            //return $resultsPath->comment;
                           return \backend\modules\repayment\models\RefundComment::getVerificationComment($resultsPath->refund_comment_id);
                 },
             ],
           ],
      ]); ?>
	  <?php if($model->refund_verification_framework_id==''){
		  $checkFrameworkID=0;
		  	  }else{
		   $checkFrameworkID=$model->refund_verification_framework_id;
			  } ?>
    </div>   
</div>
</div>


       <div class="row" style="margin: 1%;">
           <div class="col-xs-12">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title"><b>APPLICATION VERIFICATION STATUS</b></h3>
                   </div>
                   <?php
                   $modelRefundApplicaOper = RefundApplicationOperation::find()->where("refund_application_id={$application_id1}")->all();
                   ?>
                   <table class="table table-condensed">
                       <?php
                       if(count($modelRefundApplicaOper > 0)){
                       ?>
                           <tr>
                               <td><b>Sequence</b></td>
                               <td><b>From Level</b></td>
                               <td><b>To Level</b></td>
                               <td><b>Status</b></td>
                               <td><b>Comment</b></td>
                               <td><b>Narration</b></td>
                               <td><b>Response</b></td>
                               <td><b>Verified By</b></td>
                           </tr>
                       <?php
                           $noCount=1;
                       foreach($modelRefundApplicaOper AS $operaApp){
                           //if(!$educationHistory->certificate_document){

                           ?>

                           <tr>
                               <td><?= $noCount;?></td>
                               <td><?= $operaApp->refundInternalOperationalPrevious->name;?></td>
                               <td><?= $operaApp->refundInternalOperational->name;?></td>
                               <td>
                                       <?php
                                       if($operaApp->status==0){
                                         $status="Waiting";
                                       }else if($operaApp->status==1){$status="Valid";
                                       }else if($operaApp->status==2){$status="Invalid";
                                       }else if($operaApp->status==3){
                                           $status="Need Further Verification";
                                       }
                                       echo $status;
                                       ?></td>
                               <td><?= $operaApp->refundStatusReasonSetting->reason;?></td>
                               <td><?= $operaApp->narration;?></td>
                               <td><?= $operaApp->verificationResponse->reason;?></td>
                               <td><?= $operaApp->lastVerifiedBy->firstname." ".$operaApp->lastVerifiedBy->middlename." ".$operaApp->lastVerifiedBy->surname;?></td>
                           </tr>
                           <?php $noCount++; }?>
                           <?php
                       } ?>
                   </table>



               </div>
           </div>
       </div>

       <?php if($currentStageStatus == 1){  ?>
       <div class="row" style="margin: 1%;">
           <div class="col-xs-12">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title"><b>VERIFICATION RESPONSE</b></h3>
                   </div>
                   <table class="table table-condensed">
                       <tr>
                           <td>Status:</td>
                           <td><b><?php echo $currentResonse; ?></b></td>
                           <td><?php
                               if($sendasx==1){
                                   if($showSend==1){
                               echo Html::a('VIEW AND SEND', ['/repayment/loan-beneficiary/view-loanee-details', 'id' => $applicantID]);
                               }
                               }
                               ?></td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
       <?php } ?>
   </div>
   </div>
</div>
