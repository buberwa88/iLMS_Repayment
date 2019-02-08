<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimantEmployment */

$this->title = 'Update Refund Claimant Employment: ' . $model->refund_claimant_employment_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Claimant Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_claimant_employment_id, 'url' => ['view', 'id' => $model->refund_claimant_employment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-claimant-employment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
