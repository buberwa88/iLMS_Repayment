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

$attemptedApplication = 0;
$session = Yii::$app->session;
$refund_claim_id = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$incomplete = $resultsCheckResultsGeneral->submitted;
$educationAttained = $resultsCheckResultsGeneral->educationAttained;
//label sequences
if($educationAttained==2){
$step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}else if($educationAttained==1){
$step3=3;$step4=4;$step5=5;$step6=6;$step7=7;
}else{
$step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}
//end label step sequence
?>
<div class="education-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="icon fa fa-folder"></i> NON-BENEFICIARY - LOAN REFUND APPLICATION  #<?php echo $model->application_number; ?>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $refund_claim_id]) ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa  fa-power-off"></i> Logout</a></h4>
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
            $f4educationCaptured = RefundClaimant::getStageChecked($refund_claim_id);
            $resultsCheckCount = RefundApplication::getStageCheckedBankDetails($refund_application_id);
            $resultsCheckCountSocialFund = RefundApplication::getStageCheckedSocialFund($refund_application_id);
            $resultsCheckCountEmploymentDetails = RefundClaimantEmployment::getStageChecked($refund_application_id);
            ?>
            <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 1: Contacts Details ", ['site/index-contactdetails']) : "Step 1: Contacts Details "; ?><label class='label  <?= RefundContactPerson::getStageChecked($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundContactPerson::getStageChecked($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php if ($resultsCheckResultsGeneral->educationAttained > 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 2: Primary/Form 4 Education", ['site/indexf4educationdetails']) : "Step 2: Primary/Form 4 Education"; ?><label class='label  <?= $resultsCheckResultsGeneral->educationAttained > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= $resultsCheckResultsGeneral->educationAttained > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php }else{ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Primary/Form 4 Education", ['site/create-educationgeneral']); ?><label class='label  <?= RefundClaimant::getStageChecked($refund_claim_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimant::getStageChecked($refund_claim_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if($educationAttained==1){ ?>
            <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step ". $step3.": Tertiary Education Details ", ['site/index-tertiary-education']) : "Step ".$step3.": Tertiary Education Details "; ?><label class='label <?= RefundClaimantEducationHistory::getStageChecked($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimantEducationHistory::getStageChecked($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCountEmploymentDetails == 0) { ?>
            <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step ".$step4.": Employment Details ", ['site/create-employment-details']) : "Step ".$step4.": Employment Details "; ?><label class='label  <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCountEmploymentDetails > 0) { ?>
            <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step ".$step4.": Employment Details ", ['site/index-employment-details']) : "Step ".$step4.": Employment Details "; ?><label class='label  <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimantEmployment::getStageChecked($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCount == 0) { ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step ".$step5.": Bank Details ", ['site/create-refund-bankdetails']); ?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCount > 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step ".$step5.": Bank Details ", ['site/index-bankdetails', 'id' => $refund_application_id]) : "Step ".$step5.": Bank Details "; ?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundApplication::getStageCheckedBankDetails($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCountSocialFund == 0) { ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step ".$step6.": Social Fund Details ", ['site/create-securityfund']); ?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundApplication::getStageCheckedSocialFund($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <?php if ($resultsCheckCountSocialFund > 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step ".$step6.": Social Fund Details ", ['site/index-socialfund']) : "Step ".$step6.": Social Fund Details "; ?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundApplication::getStageCheckedSocialFund($refund_application_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step ".$step7.": Preview, Confirm and Submit", ['site/refund-applicationview', 'refundApplicationID' => $refund_application_id]); ?><label class='label  <?= $resultsCheckResultsGeneral->submitted > 1 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= $resultsCheckResultsGeneral->submitted > 1 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            </ul>
        </div>
    </div>
</div>
