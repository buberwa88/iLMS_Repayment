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
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
$detailsRefundApplication=\backend\modules\repayment\models\RefundApplicationOperation::getApplicationDEtails($application_id);
if($model->verification_response==-1){
$currentResonse="Waiting";
}else{
$currentResonse=\backend\modules\repayment\models\RefundVerificationResponseSetting::findOne($model->verification_response)->reason;
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
                    &nbsp;Form IV Index No:- <b><?php echo $model->refundClaimant->f4indexno.".".$model->refundClaimant->f4_completion_year;?></b><br/>
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
                 &nbsp;F4index #:-<b><?php if($model->refundClaimant->applicant_id > 0){echo "";} ?></b><br/>
                  Claimant Names:-<b><?php if($model->refundClaimant->applicant_id > 0){echo "Count 1";} ?></b><br/>
                 &nbsp;Previous Refund Exists:- <b></b><br/>
                 <br/><br/><br/>
              </p>
          </div>
        </div>
    </div>
       <?php if($model->refund_type_id==1 || $model->refund_type_id==2){ ?>
       <div class="row" style="margin: 1%;">
           <div class="col-xs-12">
               <div class="box box-primary">
                   <div class="box-header">
                       <h3 class="box-title"><b>CHECK #/EMPLOYEE ID DETAILS</b></h3>
                   </div>
                   <table class="table table-condensed">
                       <tr>
                           <td>Full Name:</td>
                           <td><b><?php echo $model->refundClaimant->applicant->user->firstname." ".$model->refundClaimant->applicant->user->middlename." ".$model->refundClaimant->applicant->user->surname; ?></b></td>
                           <td>F4index #:</td>
                           <td><b><?php echo $model->refundClaimant->applicant->f4indexno; ?></b></td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
       <?php } ?>
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
                                   /*
                              echo Html::a('VIEW DETAIL', ['/repayment/loan-beneficiary/view-loanee-details', 'id' =>$applicantID],['target' => '_blank', 'class' => 'btn btn-success center-block']);
                                   */
                                   ?>
                                   <?php
                                   Modal::begin([
                                       'header' => '<h4><strong>CUSTOMER STATEMENT : REPAYMENTS</strong></h4>',
                                       'size'=>'width:100%',
                                       'toggleButton' =>   ['label' => 'View Repayment Statement', 'style'=>'margin-left:4px', 'class' => 'btn btn-primary'],
                                   ]);
                                   ?>
                                           <?= $this->render('../../../report/views/report/customerStatementRepaymentPayments',['applicant_id'=>$applicantID]) ?>
                                   <?php
                                   Modal::end();
                                   ?>
                               <?php
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
                           <?php if($operaApp->status > 0){ ?>
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
                               <?php
                               $noCount++;
                           } ?>
                           <?php  }?>
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
                   <h3 class="box-title"><b>VERIFY APPLICATION</b></h3>
               </div>

               <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
               <?php
               echo Form::widget([ // fields with labels
                   'model'=>$modelRefundAppOper,
                   'form'=>$form,
                   'columns'=>3,
                   'attributes'=>[
                       //'verificationStatus'=>['label'=>'Verification Status:', 'options'=>['placeholder'=>'Enter.']],

                       'verificationStatus' => ['type' => Form::INPUT_WIDGET,
                           'widgetClass' => \kartik\select2\Select2::className(),
                           'label' => 'Verification Status',
                           'options' => [
                               'data' => $verificationStatus,
                               'options' => [
                                   'prompt' => ' Select ',
                                   'id' => 'verificationStatus_id',
                                   //'onchange'=>'ShowStopDedStatus()',
                               ],
                               'pluginOptions' => [
                                   'allowClear' => true
                               ],
                           ],
                       ],

                       'refund_statusreasonsettingid' => ['type' => Form::INPUT_WIDGET,
                           'widgetClass' => \kartik\select2\Select2::className(),
                           'label' => 'Comment',
                           'widgetClass' => DepDrop::className(),
                           'options' => [
                               'data' => ArrayHelper::map(backend\modules\repayment\models\RefundStatusReasonSetting::find()->all(), 'refund_status_reason_setting_id', 'reason'),
                               'options' => [
                                   'prompt' => ' Select ',
                                   'id' => 'refund_statusreasonsettingid_id',
                               ],
                               'pluginOptions' => [
                                   'depends' => ['verificationStatus_id'],
                                   'placeholder' => 'Select ',
                                   'url' => Url::to(['/repayment/employer/setting-reasons']),
                               ],
                           ],
                       ],

                       'needStopDeductionOrNot' => ['type' => Form::INPUT_WIDGET,
                           'widgetClass' => \kartik\select2\Select2::className(),
                           'label' => 'Verification Response',
                           'widgetClass' => DepDrop::className(),
                           'options' => [
                               'data' => ArrayHelper::map(backend\modules\repayment\models\RefundVerificationResponseSetting::find()->all(), 'refund_verification_response_setting_id', 'reason'),
                               'options' => [
                                   'prompt' => ' Select ',
                                   'id' => 'needStopDeductionOrNot_id',
                               ],
                               'pluginOptions' => [
                                   'depends' => ['verificationStatus_id'],
                                   'placeholder' => 'Select ',
                                   'url' => Url::to(['/repayment/employer/verification-response','refund_type_id'=>$refund_type_id,'retired_status'=>$social_fund_status]),
                               ],
                           ],
                       ],


                       //'refund_statusreasonsettingid'=>['label'=>'Comment', 'options'=>['placeholder'=>'Enter.']],
                     ]
               ]);
               ?>
               <?= $form->field($modelRefundAppOper, 'narration')->label('Narration')->textInput() ?>
               <?= $form->field($modelRefundAppOper, 'refund_application_id')->label(FALSE)->hiddenInput(["value" =>$application_id1]) ?>
               <?= $form->field($modelRefundAppOper, 'refundType')->label(FALSE)->hiddenInput(["value" =>$refund_type_id,'id' => 'refundType_id']) ?>
               <?= $form->field($modelRefundAppOper, 'retiredStatus')->label(FALSE)->hiddenInput(["value" =>$social_fund_status,'id' => 'retiredStatus_id']) ?>
               <?= $form->field($modelRefundAppOper, 'previous_internal_operational_id')->label(FALSE)->hiddenInput(["value" =>$previous_internal_operational_id]) ?>
               <div class="text-right">
                   <?= Html::submitButton($modelRefundAppOper->isNewRecord ? 'SAVE' : 'SAVE', ['class' => $modelRefundAppOper->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                   <?php
                   echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
                   echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/refund-application-operation/verifyapplication','id'=>$application_id1], ['class' => 'btn btn-warning']);

                   ActiveForm::end();
                   ?>

               </div>
           </div>
       </div>
</div>
       <?php } ?>
   </div>
   </div>
</div>
