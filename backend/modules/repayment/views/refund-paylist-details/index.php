<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundPaylistDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Paylist Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Paylist Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_paylist_details_id',
            'refund_paylist_id',
            'refund_application_reference_number',
            'refund_claimant_id',
            'refund_application_id',
            // 'claimant_f4indexno',
            // 'claimant_name',
            // 'refund_claimant_amount',
            // 'phone_number',
            // 'email_address:email',
            // 'academic_year_id',
            // 'financial_year_id',
            // 'payment_bank_account_name',
            // 'payment_bank_account_number',
            // 'payment_bank_name',
            // 'payment_bank_branch',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
