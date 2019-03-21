<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistDetails */

$this->title = $model->refund_paylist_details_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylist Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_paylist_details_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_paylist_details_id], [
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
            'refund_paylist_details_id',
            'refund_paylist_id',
            'refund_application_reference_number',
            'refund_claimant_id',
            'refund_application_id',
            'claimant_f4indexno',
            'claimant_name',
            'refund_claimant_amount',
            'phone_number',
            'email_address:email',
            'academic_year_id',
            'financial_year_id',
            'payment_bank_account_name',
            'payment_bank_account_number',
            'payment_bank_name',
            'payment_bank_branch',
            'status',
        ],
    ]) ?>

</div>
