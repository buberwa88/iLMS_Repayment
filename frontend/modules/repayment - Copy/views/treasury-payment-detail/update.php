<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPaymentDetail */

$this->title = 'Update Treasury Payment Detail: ' . $model->treasury_payment_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payment Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->treasury_payment_detail_id, 'url' => ['view', 'id' => $model->treasury_payment_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="treasury-payment-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
