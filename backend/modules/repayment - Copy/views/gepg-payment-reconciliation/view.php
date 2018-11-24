<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgPaymentReconciliation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Payment Reconciliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-payment-reconciliation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'trans_id',
            'trans_date',
            'bill_number',
            'control_number',
            'receipt_number',
            'paid_amount',
            'payment_channel:ntext',
            'account_number',
            'Remarks',
            'date_created',
        ],
    ]) ?>

</div>
