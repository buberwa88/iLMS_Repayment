<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundContactPerson;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
$incomplete=0;
$attemptedApplication=0;
$session = Yii::$app->session;
$refund_claim_id = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
      <h4><i class="icon fa fa-info"></i>  YOU ARE  APPLYING FOR REFUND AS NON-BENEFICIARY           
           </h4>
	  
        </div>
        <div class="panel-body">
            <p>
                <?php
                if($refund_application_id !=''){
                ?>
                <label class="label label-primary"> Overall Status</label>:
                <?php
                }
                ?>
                <?php
                if($refund_application_id !='' && $incomplete !=1){
                    echo '<label class="label label-danger">Incomplete</label>';
                }
                else if($refund_application_id !='' && $incomplete==1){
                    echo '<label class="label label-success">Complete</label>';
                }
                ?>
            </p>
                </ul>
				<?php 
                $f4educationCaptured=RefundClaimant::getStageChecked($refund_claim_id);
				?>
				<?php if($f4educationCaptured == 0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 1: Form 4 Education ",['site/create-refundf4education']);?><label class='label  <?= RefundClaimant::getStageChecked($refund_claim_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundClaimant::getStageChecked($refund_claim_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
				<?php } ?>
				<?php if($f4educationCaptured > 0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 1: Form 4 Education ",['site/f4education-preview','id'=>$refund_claim_id]);?><label class='label  <?= RefundClaimant::getStageChecked($refund_claim_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundClaimant::getStageChecked($refund_claim_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
				<?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Tertiary Education Details ",['site/index-tertiary-education']);?><label class='label <?=RefundClaimantEducationHistory::getStageChecked($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundClaimantEducationHistory::getStageChecked($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Employment Details ",['site/index-employment-details']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Bank Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Contacts Details ",['site/contact-details-preview']);?><label class='label  <?= RefundContactPerson::getStageChecked($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundContactPerson::getStageChecked($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Social Fund Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 7: Submit ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
       </ul>
        </div>
        </div>
</div>
