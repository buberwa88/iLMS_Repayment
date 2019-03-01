<?php

use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
$educationAttained= $resultsCheckResultsGeneral->educationAttained;

//label sequences
if($educationAttained==2){
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}else if($educationAttained==1){
    $step3=3;$step4=4;$step5=5;$step6=6;$step7=7;
}else{
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}

if($refundTypeId==3){
    $title="Step 6: Social Fund Details";
}else if($refundTypeId==1){
    $title="Step ".$step6.": Social Fund Details";
}else if($refundTypeId==2){
    $title="Step 5: Social Fund Details";
}
//end label step sequence

$this->title = $title;
//$this->params['breadcrumbs'][] = ['label' => 'Refund Education Histories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?= $this->render('_form_socialFund', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
