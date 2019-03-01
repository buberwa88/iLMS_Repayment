<?php

use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
//$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
//if($refundTypeId==3){
    //$title="Step 1: Deceased's Form 4 Education";
//}else{
    //$title="Step 1: Form 4 Education";
//}

//$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
if($refundTypeId==3){
    $title="Step 2: Deceased's Form 4 Education";
}else if($refundTypeId==1){
    $title="Step 2: Form 4 Education";
    if ($resultsCheckResultsGeneral->educationAttained > 0) {
        //$link = 'site/indexf4educationdetails';
    }else{
        //$link = 'site/create-educationgeneral';
    }
}else if($refundTypeId==2){
    $title="Step 2: Form 4 Education";
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

    <?= $this->render('_form_education_type', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
