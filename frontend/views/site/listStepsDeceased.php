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
            <h4><i class="icon fa fa-info"></i>  DECEASED - LOAN REFUND APPLICATION  #<?php echo $model->application_number; ?>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $refund_claim_id]) ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa  fa-power-off"></i> Logout</a>
            </h4>

        </div>
        <div class="panel-body">
            <?php if($incomplete !=3){ ?>
            <div class="alert alert-info alert-dismissible">
                <h4 >Please complete the steps listed below to submit your application</h4>
            </div>
            <?php } ?>
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
            $resultsCheckResultsGeneral=RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
            ?>

            <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ?  yii\helpers\Html::a("Step 1: Contacts Details ",['site/index-contactdetails']) : "Step 1: Contacts Details ";?><label class='label  <?= RefundContactPerson::getStageChecked($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundContactPerson::getStageChecked($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php if ($resultsCheckResultsGeneral->educationAttained > 0) { ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ? yii\helpers\Html::a("Step 2: Deceased's Primary/Olevel Education", ['site/indexf4educationdetails']) : "Step 2: Deceased's Primary/Olevel Education"; ?><label class='label  <?= $resultsCheckResultsGeneral->educationAttained > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= $resultsCheckResultsGeneral->educationAttained > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php }else{ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Deceased's Primary/Olevel Education", ['site/create-educationgeneral']); ?><label class='label  <?= RefundClaimant::getStageChecked($refund_claim_id) > 0 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= RefundClaimant::getStageChecked($refund_claim_id) > 0 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            <?php } ?>


            <?php if(count($resultsCheckResultsGeneral->death_certificate_number)==0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Death Details ",['site/create-deathdetails']);?><label class='label  <?= count($resultsCheckResultsGeneral->death_certificate_number)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->death_certificate_number)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->death_certificate_number)>0){ ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ?  yii\helpers\Html::a("Step 3: Death Details ",['site/index-deathdetails']): "Step 3: Death Details ";?><label class='label  <?= count($resultsCheckResultsGeneral->death_certificate_number)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->death_certificate_number)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->court_letter_certificate_document)==0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Court Details",['site/create-courtdetails']);?><label class='label  <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->court_letter_certificate_document)>0){ ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ?  yii\helpers\Html::a("Step 4: Court Details",['site/index-courtdetails']) : "Step 4: Court Details";?><label class='label  <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCount==0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Bank Details ",['site/create-refund-bankdetails']);?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCount >0){ ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ?  yii\helpers\Html::a("Step 5: Bank Details ",['site/index-bankdetails','id'=>$refund_application_id]): "Step 5: Bank Details ";?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCountSocialFund==0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Social Fund Details ",['site/create-securityfund']);?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCountSocialFund > 0){ ?>
                <li class="list-group-item"><?= $resultsCheckResultsGeneral->submitted != 3 ?  yii\helpers\Html::a("Step 6: Social Fund Details ",['site/index-socialfund']) : "Step 6: Social Fund Details ";?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 7: Preview, Confirm and Submit ", ['site/refund-applicationview', 'refundApplicationID' => $refund_application_id]); ?><label class='label  <?= $resultsCheckResultsGeneral->submitted > 1 ? "label-success" : "label-danger"; ?> pull-right'><span class="glyphicon <?= $resultsCheckResultsGeneral->submitted > 1 ? "glyphicon-check" : "glyphicon-remove"; ?>"></span></label></li>
            </ul>
        </div>
    </div>
</div>
