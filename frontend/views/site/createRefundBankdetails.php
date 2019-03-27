<?php

use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
$educationAttained=$resultsCheckResultsGeneral->educationAttained;

if($educationAttained==2){
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}else if($educationAttained==1){
    $step3=3;$step4=4;$step5=5;$step6=6;$step7=7;
}else{
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}

if($refundTypeId==3){
    $title="Step 5: Bank Details";
}else if($refundTypeId==1){
    $title="Step ".$step5.": Bank Details";
}else if($refundTypeId==2){
	$title="Step 4: Bank Details";
}
$this->title = $title;
//$this->params['breadcrumbs'][] = ['label' => 'Refund Claimants', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-create">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php if($refundTypeId==3){ ?>
            <div class="alert alert-info alert-dismissible" id="labelshow">
            <h4 class="necta" id="necta"><i class="icon fa fa-info"></i>Jaza taharifa zilizopo kwenye kiambatanisho kilichothibitishwa na mahakama chenye acount namba ya bank.</h4>
            </div>
            <?php } ?>
    <?= $this->render('_form_bankDetails', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
