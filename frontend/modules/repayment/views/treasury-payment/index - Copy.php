<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\TreasuryPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Treasury Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasury-payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Treasury Payment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'treasury_payment_id',
            'bill_number',
            'control_number',
            'amount',
            'receipt_number',
            // 'pay_method_id',
            // 'pay_phone_number',
            // 'payment_date',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'date_receipt_received',
            // 'payment_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
