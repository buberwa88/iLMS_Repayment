<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundContactPerson;
use frontend\modules\repayment\models\RefundClaimantEmployment;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
$incomplete=0;
$attemptedApplication=0;
$session = Yii::$app->session;
$refund_claim_id = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$incomplete = $resultsCheckResultsGeneral->submitted;
?>
<div class="education-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="icon fa fa-info"></i>  OVER DEDUCTED - LOAN REFUND APPLICATION  #<?php echo $model->application_number; ?>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $refund_claim_id]) ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa  fa-power-off"></i> Logout</a>
            </h4>

        </div>
        <div class="panel-body">
            <p>
                <?php
                if ($refund_application_id != '') {
                    ?>
                    <label class="label label-primary"> Overall Status</label>:
                    <?php
                }
                ?>
                <?php
                if ($refund_application_id != '' && $incomplete != 3) {
                    echo '<label class="label label-danger">Incomplete</label>';
                } else if ($refund_application_id != '' && $incomplete == 3) {
                    echo '<label class="label label-success">Complete</label>';
                }
                ?>
            </p>
            </ul>
            <?php
            $f4educationCaptured=RefundClaimant::getStageChecked($refund_claim_id);
            $resultsCheckCount=RefundApplication::getStageCheckedBankDetails($refund_application_id);
            $resultsCheckCountSocialFund=RefundApplication::getStageCheckedSocialFund($refund_application_id);
            $resultRefundApplicationGeneral=RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
            ?>
            <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ?  yii\helpers\Html::a("Step 1: Contacts Details ",['site/index-contactdetails']) : "Step 1: Contacts Details ";?><label class='label  <?= RefundContactPerson::getStageChecked($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundContactPerson::getStageChecked($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>

            <?php if ($resultsCheckCountEmploymentDetails == 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 2: Employment Details ", ['site/create-employment-details']) : "Step 2: Employment Details "; ?><label class='label  <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCountEmploymentDetails > 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 2: Employment Details ", ['site/index-employment-details']) : "Step 2: Employment Details "; ?><label class='label  <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>

            <?php
            if(count($resultRefundApplicationGeneral->liquidation_letter_number)==0){
            ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Repayment Details ",['site/create-repaymentdetails']);?><label class='label  <?= count($resultRefundApplicationGeneral->liquidation_letter_number)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultRefundApplicationGeneral->liquidation_letter_number)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php
            if(count($resultRefundApplicationGeneral->liquidation_letter_number) >0){
                ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 3: Repayment Details ",['site/index-repaymentdetails']) : "Step 3: Repayment Details ";?><label class='label  <?= count($resultRefundApplicationGeneral->liquidation_letter_number)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultRefundApplicationGeneral->liquidation_letter_number)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>

            <?php if ($resultsCheckCount == 0) { ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Bank Details ", ['site/create-refund-bankdetails']); ?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCount > 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 4: Bank Details ", ['site/index-bankdetails', 'id' => $refund_application_id]) : "Step 4: Bank Details "; ?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCountSocialFund==0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Social Fund Details ",['site/create-securityfund']);?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCountSocialFund > 0){ ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 5: Social Fund Details ",['site/index-socialfund']) : "Step 5: Social Fund Details ";?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Preview, Confirm and Submit ", ['site/refund-applicationview', 'refundApplicationID' => $refund_application_id]); ?><label class='label  <?= $resultsCheckResultsGeneral->submitted > 1 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= $resultsCheckResultsGeneral->submitted > 1 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            </ul>
        </div>
    </div>
</div>
