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

$title="Step 1: Update Contacts Details";
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

    <?= $this->render('_form_update_contacts', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
