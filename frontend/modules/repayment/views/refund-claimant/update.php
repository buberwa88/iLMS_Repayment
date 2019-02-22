<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */

$this->title = 'Update Refund Claimant: ' . $model->refund_claimant_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Claimants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_claimant_id, 'url' => ['view', 'id' => $model->refund_claimant_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-claimant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
