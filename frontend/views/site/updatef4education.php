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
if($refundTypeId==3){
    $title="Step 2: Update Deceased's Primary/Olevel Education";
}else{
    $title="Step 2: Update Primary/Olevel Education";
}

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
            <?= $this->render('_form_educationGeneralupdate', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
