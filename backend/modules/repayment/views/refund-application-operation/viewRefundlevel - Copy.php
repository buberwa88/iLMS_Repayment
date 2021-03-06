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

$this->title ="Refund Application Verification";
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Refund', 'url' => Yii::$app->request->referrer];
$this->params['breadcrumbs'][] = $this->title;
$list = [1 => 'Confirm'];
$list2 = backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatusResponse();
?>
<script type="text/javascript">
    function ShowStopDedStatus() {
        var stopDeductionConfirm = document.getElementById("verificationStatus_id");
        var stopDeductionConfirmV = stopDeductionConfirm.value;

        //alert (claim_category_value);
        if (stopDeductionConfirmV == '1') {
            document.getElementById('stopdeduction_show').style.display = 'block';
            document.getElementById('denial_letter_show').style.display = 'none';
        } else if (stopDeductionConfirmV == '2') {
            document.getElementById('denial_letter_show').style.display = 'block';
            document.getElementById('stopdeduction_show').style.display = 'none';
    }else{
            document.getElementById('stopdeduction_show').style.display = 'none';
            document.getElementById('denial_letter_show').style.display = 'none';

        }
    }
</script>
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
                 &nbsp;F4index #:-<b></b><br/>
                  Claimant Names:-<b></b><br/>
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
                       <tr>
                           <td>Application Preview Status</td>
                           <td><b>Complete</b></td>
                       </tr>
                       <?php
                       if(count($modelRefundApplicaOper > 0)){
                       foreach($modelRefundApplicaOper AS $operaApp){
                           //if(!$educationHistory->certificate_document){

                           ?>

                           <tr>
                               <td>Verification Level: </td>
                               <td><b><?= $operaApp->access_role_master;?></b></td>
                               <td>Status: </td>
                               <td><b>
                                       <?php
                                       if($operaApp->status==0){
                                         $status="Waiting";
                                       }else if($operaApp->status==1){$status="Valid";
                                       }else if($operaApp->status==2){$status="Invalid";
                                       }else if($operaApp->status==3){
                                           $status="Need Further Verification";
                                       }
                                       echo $status;
                                       ?></b></td>
                               <td>Comment: </td>
                               <td><b><?= $operaApp->refundStatusReasonSetting->reason;?></b></td>
                               <td>Narration: </td>
                               <td><b><?= $operaApp->narration;?></b></td>
                               <td>Verified By: </td>
                               <td><b><?= $operaApp->lastVerifiedBy->firstname." ".$operaApp->lastVerifiedBy->middlename." ".$operaApp->lastVerifiedBy->surname;?></b></td>
                           </tr>
                           <?php }?>
                           <?php
                       } ?>
                   </table>



               </div>
           </div>
       </div>


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
                   'columns'=>2,
                   'attributes'=>[
                       //'verificationStatus'=>['label'=>'Verification Status:', 'options'=>['placeholder'=>'Enter.']],

                       'verificationStatus' => ['type' => Form::INPUT_WIDGET,
                           'widgetClass' => \kartik\select2\Select2::className(),
                           'label' => 'Verification Status',
                           'options' => [
                               'data' => \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatus(),
                               'options' => [
                                   'prompt' => ' Select ',
                                   'id' => 'verificationStatus_id',
                                   'onchange'=>'ShowStopDedStatus()',
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

                       //'refund_statusreasonsettingid'=>['label'=>'Comment', 'options'=>['placeholder'=>'Enter.']],
                     ]
               ]);
               ?>
               <?php if($social_fund_status ==2 && $refund_type_id==1){ ?>
               <div id="stopdeduction_show" style="display:none">
               <?php
               echo $form->field($modelRefundAppOper, 'needStopDeductionOrNot')->label('Need Permanent Stop Deduction.')->radioList($list,
                   [
                       'inline'=>true,
                       'id'=>social_fund_status_id,
                       //'onchange'=>'ShowFundStatus(this)',
                   ]);
               ?>
               </div>
                   <div id="denial_letter_show" style="display:none">
                       <?php
                       echo $form->field($modelRefundAppOper, 'needNeedDenialLetter')->label('Need Denial Letter.')->radioList($list2,
                           [
                               'inline'=>true,
                               'id'=>needNeedDenialLetter_id,
                               //'onchange'=>'ShowFundStatus(this)',
                           ]);
                       ?>
                   </div>
               <?php } ?>
               <?= $form->field($modelRefundAppOper, 'narration')->label('Narration')->textInput() ?>
               <?= $form->field($modelRefundAppOper, 'refund_application_id')->label(FALSE)->hiddenInput(["value" =>$application_id1]) ?>
               <?= $form->field($modelRefundAppOper, 'refundType')->label(FALSE)->hiddenInput(["value" =>$refund_type_id,'id' => 'refundType_id']) ?>
               <?= $form->field($modelRefundAppOper, 'retiredStatus')->label(FALSE)->hiddenInput(["value" =>$social_fund_status,'id' => 'retiredStatus_id']) ?>
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
   </div>
   </div>
</div>
