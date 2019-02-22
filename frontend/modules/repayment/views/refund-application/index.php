<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-application-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Application', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_application_id',
            'refund_claimant_id',
            'application_number',
            'refund_claimant_amount',
            'finaccial_year_id',
            // 'academic_year_id',
            // 'trustee_firstname',
            // 'trustee_midlename',
            // 'trustee_surname',
            // 'trustee_sex',
            // 'current_status',
            // 'refund_verification_framework_id',
            // 'check_number',
            // 'bank_account_number',
            // 'bank_account_name',
            // 'bank_id',
            // 'refund_type_id',
            // 'liquidation_letter_number',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'is_active',
            // 'submitted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
