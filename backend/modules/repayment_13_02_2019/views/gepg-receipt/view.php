<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgReceipt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-receipt-view">

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
            'bill_number',
            'response_message:ntext',
            'retrieved',
            'trans_id',
            'payer_ref_id',
            'control_number',
            'bill_amount',
            'paid_amount',
            'currency',
            'trans_date',
            'payer_phone',
            'payer_name',
            'receipt_number',
            'account_number',
            'reconciliation_status',
            'amount_diff',
            'recon_master_id',
        ],
    ]) ?>

</div>
