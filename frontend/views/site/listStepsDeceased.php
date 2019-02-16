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
?>
<div class="education-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="icon fa fa-info"></i>  DECEASED - LOAN REFUND APPLICATION  #<?php echo $model->application_number; ?> </h4>

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
            $resultsCheckCount=RefundApplication::getStageCheckedBankDetails($refund_application_id);
            $resultsCheckCountSocialFund=RefundApplication::getStageCheckedSocialFund($refund_application_id);
            $resultsCheckResultsGeneral=RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
            ?>
            <?php if($f4educationCaptured == 0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 1: Deceased's Form 4 Education",['site/create-refundf4education']);?><label class='label  <?= RefundClaimant::getStageChecked($refund_claim_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundClaimant::getStageChecked($refund_claim_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($f4educationCaptured > 0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 1: Deceased's Form 4 Education",['site/indexf4educationdetails','id'=>$refund_claim_id]);?><label class='label  <?= RefundClaimant::getStageChecked($refund_claim_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundClaimant::getStageChecked($refund_claim_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Deceased's Tertiary Education Details",['site/index-tertiary-education']);?><label class='label <?=RefundClaimantEducationHistory::getStageChecked($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundClaimantEducationHistory::getStageChecked($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php if(count($resultsCheckResultsGeneral->death_certificate_number)==0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Death Details ",['site/create-deathdetails']);?><label class='label  <?= count($resultsCheckResultsGeneral->death_certificate_number)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->death_certificate_number)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->death_certificate_number)>0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Death Details ",['site/index-deathdetails']);?><label class='label  <?= count($resultsCheckResultsGeneral->death_certificate_number)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->death_certificate_number)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->court_letter_certificate_document)==0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Court Details",['site/create-courtdetails']);?><label class='label  <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->court_letter_certificate_document)>0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Court Details",['site/index-courtdetails']);?><label class='label  <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->court_letter_certificate_document)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCount==0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Bank Details ",['site/create-refund-bankdetails']);?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCount >0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Bank Details ",['site/index-bankdetails','id'=>$refund_application_id]);?><label class='label  <?= RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedBankDetails($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Contacts Details ",['site/index-contactdetails']);?><label class='label  <?= RefundContactPerson::getStageChecked($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundContactPerson::getStageChecked($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php if($resultsCheckCountSocialFund==0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 7: Social Fund Details ",['site/create-securityfund']);?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if($resultsCheckCountSocialFund > 0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 7: Social Fund Details ",['site/index-socialfund']);?><label class='label  <?= RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageCheckedSocialFund($refund_application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->letter_family_session_document)==0){ ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 8: Family Session Details ",['site/create-familysessiondetails']);?><label class='label  <?= count($resultsCheckResultsGeneral->letter_family_session_document)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->letter_family_session_document)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <?php if(count($resultsCheckResultsGeneral->letter_family_session_document)>0){ ?>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 8: Family Session Details ",['site/index-familysessiondetails']);?><label class='label  <?= count($resultsCheckResultsGeneral->letter_family_session_document)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=count($resultsCheckResultsGeneral->letter_family_session_document)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <?php } ?>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 9: Preview ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 10: Submit ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            </ul>
        </div>
    </div>
</div>
