<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPayment */

$this->title = $model->treasury_payment_id;
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasury-payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->treasury_payment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->treasury_payment_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'treasury_payment_id',
            'bill_number',
            'control_number',
            'amount',
            'receipt_number',
            'pay_method_id',
            'pay_phone_number',
            'payment_date',
            'date_bill_generated',
            'date_control_received',
            'date_receipt_received',
            'payment_status',
        ],
    ]) ?>

</div>
