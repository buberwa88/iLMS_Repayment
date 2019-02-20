<?php
$incomplete = 0;

use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundClaimantEmployment;
use frontend\modules\repayment\models\RefundContactPerson;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;

$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

$modelRefundApplication = RefundApplication::find()->where("refund_application_id={$model->refund_application_id}")->one();
$modelRefundClaimant = RefundClaimant::find()->where("refund_claimant_id={$modelRefundApplication->refund_claimant_id}")->one();
$modelRefundClaimantEducHistory = RefundClaimantEducationHistory::find()->where("refund_application_id={$modelRefundApplication->refund_application_id}")->all();
$modelRefundClaimantEmploymentDet = RefundClaimantEmployment::find()->where("refund_application_id={$modelRefundApplication->refund_application_id}")->all();
$modelRefContactPers = RefundContactPerson::find()->where("refund_application_id={$model->refund_application_id}")->all();
if ($modelRefundApplication->refund_type_id == 1) {
    $title = "NON-BENEFICIARY - REFUND APPLICATION DETAILS #" . $model->application_number;
} else if ($modelRefundApplication->refund_type_id == 2) {
    $title = "OVER-DEDUCTED - REFUND APPLICATION DETAILS #" . $model->application_number;
} else if ($modelRefundApplication->refund_type_id == 3) {
    $title = "DECEASED - REFUND APPLICATION #" . $model->application_number;
}
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($model->refund_application_id);
$this->title = $title;
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

            <?php
            $vieqw = 0;
            //if($vieqw==1){
            ?>

            <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa  fa-power-off"></i> Logout</a>       

        </div>

        <div class="panel-body">
            <?php  if($resultsCheckResultsGeneral->refund_type_id==1){ ?>
            <!--CLAIMNANT PARTICULARS-->
            <div class="row" style="margin: 1%;">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Claimant Particulars</b> </h3>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">

                                <table class="table table-condensed">
                                    <tr>
                                        <td style="width: 10%;">Name: </td>
                                        <td><b><?= strtoupper($modelRefundClaimant->firstname . ' ' . $modelRefundClaimant->middlename . ' ' . $modelRefundClaimant->surname); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10%">f4 Index #: </td>
                                        <td style="width: 10%"><b><?= strtoupper($modelRefundClaimant->f4indexno); ?></b></td>
                                        <td style="width: 10%">Completion Year: </td>
                                        <td style="width: 10%"><b><?= strtoupper($modelRefundClaimant->f4_completion_year); ?></b></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>            

            <div class="row" style="margin: 1%;">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Step 1: Form 4 Education</b> </h3>
                            <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                            <?php } ?>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <tr>
                                        <td>First Name: </td>
                                        <td><b><?= $modelRefundClaimant->firstname; ?></b></td>
                                        <td>Middle Name: </td>
                                        <td><b><?= $modelRefundClaimant->middlename; ?></b></td>
                                        <td>Last Name: </td>
                                        <td><b><?= $modelRefundClaimant->surname; ?></b></td>
                                        <td>Academic Certificate Document:</td>
                                        <td ><?php
                                            if ($modelRefundClaimant->f4_certificate_document != '') {
                                                ?>
                                                <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                <?php
                                            } else {
                                                echo "No Document";
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
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Step 2: Tertiary Education Details</b></h3>
                            <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                            <?php } ?>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <?php
                                    foreach ($modelRefundClaimantEducHistory AS $educationHistory) {
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Study Level: </td>
                                            <td><b><?= $educationHistory->studylevel->applicant_category; ?></b></td>
                                            <td>Institution: </td>
                                            <td><b><?= $educationHistory->institution->institution_name; ?></b></td>
                                            <td>Programme: </td>
                                            <td><b><?= $educationHistory->program->programme_name; ?></b></td>
                                            <td>Entry Year: </td>
                                            <td><b><?= $educationHistory->entry_year; ?></b></td>
                                            <td>Completion Year: </td>
                                            <td><b><?= $educationHistory->completion_year; ?></b></td>
                                            <td>Academic Certificate Document:</td>
                                            <td ><?php
                                                if ($educationHistory->certificate_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //}?>
                                    <?php }
                                    ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 1%;">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Step 3: Employment Details</b></h3>
                            <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                            <?php } ?>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <?php
                                    foreach ($modelRefundClaimantEmploymentDet AS $employmentDetails) {
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Employer Name: </td>
                                            <td><b><?php
                     echo \frontend\modules\repayment\models\Employer::getEmployerCategory($employmentDetails->employer_name)->employer_name;

                                                    $employmentDetails->employer_name; ?></b></td>
                                            <td>Employee ID/Check #: </td>
                                            <td><b><?= $employmentDetails->employee_id; ?></b></td>
                                            <td>Start Date: </td>
                                            <td><b><?= $employmentDetails->start_date; ?></b></td>
                                            <td>End Date: </td>
                                            <td><b><?= $employmentDetails->end_date; ?></b></td>
                                            <td>Fisrt Salary/Pay Slip Document</td>
                                            <td ><?php
                                                if ($employmentDetails->second_slip_document != '') {
                                                    ?>
                                                    <a href="path/to/image.jpg" alt="Image description" target="_blank" style="display: inline-block; width: 50px; height; 50px; background-image: url(<?= $employmentDetails->first_slip_document; ?>);">VIEW</a>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                            <td>Second Salary/Pay Slip Document</td>
                                            <td><?php
                                                if ($employmentDetails->second_slip_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //}?>
                                    <?php }
                                    ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 1%;">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Step 4: Bank Details</b></h3>
                            <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                            <?php } ?>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <?php
                                    //foreach($modelRefundClaimantEmploymentDet AS $employmentDetails){
                                    //if(!$educationHistory->certificate_document){
                                    ?>

                                    <tr>
                                        <td>Bank Name: </td>
                                        <td><b><?= $modelRefundApplication->bank_name; ?></b></td>
                                        <td>Account Number: </td>
                                        <td><b><?= $modelRefundApplication->bank_account_number; ?></b></td>
                                        <td>Account Name: </td>
                                        <td><b><?= $modelRefundApplication->bank_account_name; ?></b></td>
                                        <td>Account Name: </td>
                                        <td><b><?= $modelRefundApplication->bank_account_name; ?></b></td>
                                        <td>Branch: </td>
                                        <td><b><?= $modelRefundApplication->branch; ?></b></td>
                                        <td>Bank Card Document:</td>
                                        <td ><?php
                                            if ($modelRefundApplication->bank_card_document != '') {
                                                ?>
                                                <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                <?php
                                            } else {
                                                echo "No Document";
                                            }
                                            ?></td>
                                    </tr>
                                    <?php //} ?>
                                    <?php //}  ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 1%;">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Step 5: Contacts Details</b></h3>
                            <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                            <?php } ?>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <?php
                                    foreach ($modelRefContactPers AS $contactPersDetails) {
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>First Name: </td>
                                            <td><b><?= $contactPersDetails->firstname; ?></b></td>
                                            <td>Middle Name: </td>
                                            <td><b><?= $contactPersDetails->middlename; ?></b></td>
                                            <td>Last Name: </td>
                                            <td><b><?= $contactPersDetails->surname; ?></b></td>
                                            <td>Phone Number: </td>
                                            <td><b><?= $contactPersDetails->phone_number; ?></b></td>
                                            <td>Email: </td>
                                            <td><b><?= $contactPersDetails->email_address; ?></b></td>                                                                                 </tr>
                                        <?php //} ?>
                                    <?php }
                                    ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 1%;">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Step 6: Social Fund Details</b></h3>
                            <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                            <?php } ?>
                        </div>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <?php
//foreach($modelRefContactPers AS $contactPersDetails){
//if(!$educationHistory->certificate_document){
                                    ?>

                                    <tr>
                                        <td>Employment Status: </td>
                                        <td><b><?php
                                                if ($modelRefundApplication->social_fund_status == 1) {
                                                    echo 'Retired';
                                                } else {
                                                    echo 'Not Retired';
                                                }
                                                ?></b></td>
                                        <td>Social security fund document:</td>
                                        <td ><?php
                                            if ($modelRefundApplication->social_fund_document != '') {
                                                ?>
                                                <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                <?php
                                            } else {
                                                echo "No Document";
                                            }
                                            ?></td>
                                        <td>Receipt document:</td>
                                        <td ><?php
                                            if ($modelRefundApplication->social_fund_receipt_document != '') {
                                                ?>
                                                <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                <?php
                                            } else {
                                                echo "No Document";
                                            }
                                            ?></td>
                                    </tr>
                                    <?php //} ?>
                                    <?php //}  ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
<!--            here for over deducted-->
            <?php  if($resultsCheckResultsGeneral->refund_type_id==2){ ?>
                <!--CLAIMNANT PARTICULARS-->
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Claimant Particulars</b> </h3>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">

                                    <table class="table table-condensed">
                                        <tr>
                                            <td style="width: 4%;">Name: </td>
                                            <td><b><?= strtoupper($modelRefundClaimant->firstname . ' ' . $modelRefundClaimant->middlename . ' ' . $modelRefundClaimant->surname); ?></b></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 1: Employment Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        foreach ($modelRefundClaimantEmploymentDet AS $employmentDetails) {
                                            //if(!$educationHistory->certificate_document){
                                            ?>

                                            <tr>
                                                <td>Employer Name: </td>
                                                <td><b><?php
                                                        echo \frontend\modules\repayment\models\Employer::getEmployerCategory($employmentDetails->employer_name)->employer_name;
                                                        ?></b></td>
                                                <td>Employee ID/Check #: </td>
                                                <td><b><?= $employmentDetails->employee_id; ?></b></td>
                                                <td>Start Date: </td>
                                                <td><b><?= $employmentDetails->start_date; ?></b></td>
                                                <td>End Date: </td>
                                                <td><b><?= $employmentDetails->end_date; ?></b></td>
                                                <td>Fisrt Salary/Pay Slip Document</td>
                                                <td ><?php
                                                    if ($employmentDetails->second_slip_document != '') {
                                                        ?>
                                                        <a href="path/to/image.jpg" alt="Image description" target="_blank" style="display: inline-block; width: 50px; height; 50px; background-image: url(<?= $employmentDetails->first_slip_document; ?>);">VIEW</a>
                                                        <?php
                                                    } else {
                                                        echo "No Document";
                                                    }
                                                    ?></td>
                                                <td>Second Salary/Pay Slip Document</td>
                                                <td><?php
                                                    if ($employmentDetails->second_slip_document != '') {
                                                        ?>
                                                        <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                        <?php
                                                    } else {
                                                        echo "No Document";
                                                    }
                                                    ?></td>
                                            </tr>
                                            <?php //}?>
                                        <?php }
                                        ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 2: Repayment Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        //foreach($modelRefundClaimantEmploymentDet AS $employmentDetails){
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Liquidation Number: </td>
                                            <td><b><?= $modelRefundApplication->liquidation_letter_number; ?></b></td>
                                            <td>Liquidation Letter Document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->liquidation_letter_document  != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //} ?>
                                        <?php //}  ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 3: Bank Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        //foreach($modelRefundClaimantEmploymentDet AS $employmentDetails){
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Bank Name: </td>
                                            <td><b><?= $modelRefundApplication->bank_name; ?></b></td>
                                            <td>Account Number: </td>
                                            <td><b><?= $modelRefundApplication->bank_account_number; ?></b></td>
                                            <td>Account Name: </td>
                                            <td><b><?= $modelRefundApplication->bank_account_name; ?></b></td>
                                            <td>Account Name: </td>
                                            <td><b><?= $modelRefundApplication->bank_account_name; ?></b></td>
                                            <td>Branch: </td>
                                            <td><b><?= $modelRefundApplication->branch; ?></b></td>
                                            <td>Bank Card Document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->bank_card_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //} ?>
                                        <?php //}  ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 4: Contacts Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        foreach ($modelRefContactPers AS $contactPersDetails) {
                                            //if(!$educationHistory->certificate_document){
                                            ?>

                                            <tr>
                                                <td>First Name: </td>
                                                <td><b><?= $contactPersDetails->firstname; ?></b></td>
                                                <td>Middle Name: </td>
                                                <td><b><?= $contactPersDetails->middlename; ?></b></td>
                                                <td>Last Name: </td>
                                                <td><b><?= $contactPersDetails->surname; ?></b></td>
                                                <td>Phone Number: </td>
                                                <td><b><?= $contactPersDetails->phone_number; ?></b></td>
                                                <td>Email: </td>
                                                <td><b><?= $contactPersDetails->email_address; ?></b></td>                                                                                 </tr>
                                            <?php //} ?>
                                        <?php }
                                        ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 5: Social Fund Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        //foreach($modelRefContactPers AS $contactPersDetails){
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Employment Status: </td>
                                            <td><b><?php
                                                    if ($modelRefundApplication->social_fund_status == 1) {
                                                        echo 'Retired';
                                                    } else {
                                                        echo 'Not Retired';
                                                    }
                                                    ?></b></td>
                                            <td>Social security fund document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->social_fund_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                            <td>Receipt document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->social_fund_receipt_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //} ?>
                                        <?php //}  ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
<!--            end for over deducted-->
<!--               HERE FOR DECEASED-->
            <?php  if($resultsCheckResultsGeneral->refund_type_id==3){ ?>
                <!--CLAIMNANT PARTICULARS-->
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Claimant Particulars</b> </h3>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">

                                    <table class="table table-condensed">
                                        <tr>
                                            <td style="width: 4%;">Name: </td>
                                            <td><b><?= strtoupper($modelRefundClaimant->firstname . ' ' . $modelRefundClaimant->middlename . ' ' . $modelRefundClaimant->surname); ?></b></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10%">f4 Index #: </td>
                                            <td style="width: 10%"><b><?= strtoupper($modelRefundClaimant->f4indexno); ?></b></td>
                                            <td style="width: 10%">Completion Year: </td>
                                            <td style="width: 10%"><b><?= strtoupper($modelRefundClaimant->f4_completion_year); ?></b></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 1: Form 4 Education</b> </h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <tr>
                                            <td>First Name: </td>
                                            <td><b><?= $modelRefundClaimant->firstname; ?></b></td>
                                            <td>Middle Name: </td>
                                            <td><b><?= $modelRefundClaimant->middlename; ?></b></td>
                                            <td>Last Name: </td>
                                            <td><b><?= $modelRefundClaimant->surname; ?></b></td>
                                            <td>Academic Certificate Document:</td>
                                            <td ><?php
                                                if ($modelRefundClaimant->f4_certificate_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
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
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 2: Tertiary Education Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        foreach ($modelRefundClaimantEducHistory AS $educationHistory) {
                                            //if(!$educationHistory->certificate_document){
                                            ?>

                                            <tr>
                                                <td>Study Level: </td>
                                                <td><b><?= $educationHistory->studylevel->applicant_category; ?></b></td>
                                                <td>Institution: </td>
                                                <td><b><?= $educationHistory->institution->institution_name; ?></b></td>
                                                <td>Programme: </td>
                                                <td><b><?= $educationHistory->program->programme_name; ?></b></td>
                                                <td>Entry Year: </td>
                                                <td><b><?= $educationHistory->entry_year; ?></b></td>
                                                <td>Completion Year: </td>
                                                <td><b><?= $educationHistory->completion_year; ?></b></td>
                                                <td>Academic Certificate Document:</td>
                                                <td ><?php
                                                    if ($educationHistory->certificate_document != '') {
                                                        ?>
                                                        <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                        <?php
                                                    } else {
                                                        echo "No Document";
                                                    }
                                                    ?></td>
                                            </tr>
                                            <?php //}?>
                                        <?php }
                                        ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 3: Employment Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        foreach ($modelRefundClaimantEmploymentDet AS $employmentDetails) {
                                            //if(!$educationHistory->certificate_document){
                                            ?>

                                            <tr>
                                                <td>Employer Name: </td>
                                                <td><b><?= $employmentDetails->employer_name; ?></b></td>
                                                <td>Employee ID/Check #: </td>
                                                <td><b><?= $employmentDetails->employee_id; ?></b></td>
                                                <td>Start Date: </td>
                                                <td><b><?= $employmentDetails->start_date; ?></b></td>
                                                <td>End Date: </td>
                                                <td><b><?= $employmentDetails->end_date; ?></b></td>
                                                <td>Fisrt Salary/Pay Slip Document</td>
                                                <td ><?php
                                                    if ($employmentDetails->second_slip_document != '') {
                                                        ?>
                                                        <a href="path/to/image.jpg" alt="Image description" target="_blank" style="display: inline-block; width: 50px; height; 50px; background-image: url(<?= $employmentDetails->first_slip_document; ?>);">VIEW</a>
                                                        <?php
                                                    } else {
                                                        echo "No Document";
                                                    }
                                                    ?></td>
                                                <td>Second Salary/Pay Slip Document</td>
                                                <td><?php
                                                    if ($employmentDetails->second_slip_document != '') {
                                                        ?>
                                                        <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                        <?php
                                                    } else {
                                                        echo "No Document";
                                                    }
                                                    ?></td>
                                            </tr>
                                            <?php //}?>
                                        <?php }
                                        ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 4: Bank Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        //foreach($modelRefundClaimantEmploymentDet AS $employmentDetails){
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Bank Name: </td>
                                            <td><b><?= $modelRefundApplication->bank_name; ?></b></td>
                                            <td>Account Number: </td>
                                            <td><b><?= $modelRefundApplication->bank_account_number; ?></b></td>
                                            <td>Account Name: </td>
                                            <td><b><?= $modelRefundApplication->bank_account_name; ?></b></td>
                                            <td>Account Name: </td>
                                            <td><b><?= $modelRefundApplication->bank_account_name; ?></b></td>
                                            <td>Branch: </td>
                                            <td><b><?= $modelRefundApplication->branch; ?></b></td>
                                            <td>Bank Card Document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->bank_card_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //} ?>
                                        <?php //}  ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 5: Contacts Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        foreach ($modelRefContactPers AS $contactPersDetails) {
                                            //if(!$educationHistory->certificate_document){
                                            ?>

                                            <tr>
                                                <td>First Name: </td>
                                                <td><b><?= $contactPersDetails->firstname; ?></b></td>
                                                <td>Middle Name: </td>
                                                <td><b><?= $contactPersDetails->middlename; ?></b></td>
                                                <td>Last Name: </td>
                                                <td><b><?= $contactPersDetails->surname; ?></b></td>
                                                <td>Phone Number: </td>
                                                <td><b><?= $contactPersDetails->phone_number; ?></b></td>
                                                <td>Email: </td>
                                                <td><b><?= $contactPersDetails->email_address; ?></b></td>                                                                                 </tr>
                                            <?php //} ?>
                                        <?php }
                                        ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 1%;">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><b>Step 6: Social Fund Details</b></h3>
                                <?php if ($resultsCheckResultsGeneral->submitted != 3) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $modelRefundApplication->refund_claimant_id]) ?>" class="btn btn-warning pull-right" style="margin-right: 5px;">Update/Edit</a>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-condensed">
                                        <?php
                                        //foreach($modelRefContactPers AS $contactPersDetails){
                                        //if(!$educationHistory->certificate_document){
                                        ?>

                                        <tr>
                                            <td>Employment Status: </td>
                                            <td><b><?php
                                                    if ($modelRefundApplication->social_fund_status == 1) {
                                                        echo 'Retired';
                                                    } else {
                                                        echo 'Not Retired';
                                                    }
                                                    ?></b></td>
                                            <td>Social security fund document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->social_fund_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                            <td>Receipt document:</td>
                                            <td ><?php
                                                if ($modelRefundApplication->social_fund_receipt_document != '') {
                                                    ?>
                                                    <?= yii\helpers\Html::a("VIEW", ['site/refund-liststeps']); ?>
                                                    <?php
                                                } else {
                                                    echo "No Document";
                                                }
                                                ?></td>
                                        </tr>
                                        <?php //} ?>
                                        <?php //}  ?>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
<!--            END FOR DECEASED-->


            <?php if ($resultsCheckResultsGeneral->submitted != 3 && $resultsCheckResultsGeneral->social_fund_status > 0) { ?>
                <?php $form = ActiveForm::begin(['action' => ['refund-confirm', 'id' => $model->refund_application_id]]); ?>
                <div class="text-right">

                    <?= Html::submitButton($model->isNewRecord ? 'Confirm the above details for Refund Submission' : 'Confirm the above details for Refund Submission', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                <?php } ?>
                <div class="rowQA">
                    <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK TO THE LIST", ['site/refund-liststeps']); ?></div>
                </div>
            </div>
        </div>
    </div>
