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
            <h4><i class="icon fa fa-info"></i>  YOU ARE  APPLYING FOR REFUND AS OVER DEDUCTED</h4>
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
            <ul>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 1: Repayment Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Employment Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Bank Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Contacts Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Social Fund Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Submit ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
            </ul>
        </div>
    </div>
</div>
