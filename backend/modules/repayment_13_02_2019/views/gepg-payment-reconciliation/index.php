<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgPaymentReconciliationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gepg Payment Reconciliations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-payment-reconciliation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gepg Payment Reconciliation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'trans_id',
            'trans_date',
            'bill_number',
            'control_number',
            // 'receipt_number',
            // 'paid_amount',
            // 'payment_channel:ntext',
            // 'account_number',
            // 'Remarks',
            // 'date_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
