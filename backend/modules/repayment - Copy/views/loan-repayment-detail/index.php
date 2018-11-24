<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Repayment Batch Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Loan Repayment Batch Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'loan_repayment_detail_id',
            'loan_repayment_id',
            'applicant_id',
            'loan_repayment_item_id',
            'amount',
            // 'loan_summary_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
