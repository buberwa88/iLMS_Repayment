<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPaymentDetail */

$this->title = $model->treasury_payment_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payment Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasury-payment-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->treasury_payment_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->treasury_payment_detail_id], [
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
            'treasury_payment_detail_id',
            'treasury_payment_id',
            'employer_id',
            'amount',
        ],
    ]) ?>

</div>
