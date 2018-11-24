<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Refund Claims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_id',
            'claim_category',
            'employer_id',
            'applicant_id',
            'employee_id',
            // 'description',
            // 'claimant_letter_id',
            // 'claimant_letter_received_date',
            // 'claim_decision_date',
            // 'amount',
            // 'phone_number',
            // 'email_address:email',
            // 'bank_name',
            // 'bank_account_number',
            // 'branch_name',
            // 'claim_status',
            // 'claim_file_id',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
       </div>
</div>
