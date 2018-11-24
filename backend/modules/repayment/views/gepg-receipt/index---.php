<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gepg Receipts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gepg Receipt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bill_number',
            'response_message:ntext',
            'retrieved',
            'trans_id',
            // 'payer_ref_id',
            // 'control_number',
            // 'bill_amount',
            // 'paid_amount',
            // 'currency',
            // 'trans_date',
            // 'payer_phone',
            // 'payer_name',
            // 'receipt_number',
            // 'account_number',
            // 'reconciliation_status',
            // 'amount_diff',
            // 'recon_master_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
