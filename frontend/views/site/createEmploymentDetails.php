<?php

use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */

//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
//end set session
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
$educationAttained=$resultsCheckResultsGeneral->educationAttained;

/*
if($refundTypeId==3){
    $title="Step 2: Deceased's Tertiary Education Details";
}else{
    $title="Step 2: Tertiary Education Details";
}
*/

//label sequences
if($educationAttained==2){
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}else if($educationAttained==1){
    $step3=3;$step4=4;$step5=5;$step6=6;$step7=7;
}else{
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}

if($refundTypeId==3){
    $link="site/create-familysessiondetails";
}else if($refundTypeId==1){
    $title="Step ".$step4.": Employment Details";
    $link="site/refund-applicationview";
}else if($refundTypeId==2){
    $title="Step 2: Employment Details";
}else{
    $title="Step 4: Employment Details";
}
//end label step sequence

$this->title =$title;
//$this->params['breadcrumbs'][] = ['label' => 'Refund Education Histories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?= $this->render('_form_employmentDetails', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
