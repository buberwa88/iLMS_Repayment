<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPlanLoanItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Plan Loan Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-loan-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Plan Loan Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'allocation_plan_id',
            'loan_item_id',
            'priority_order',
            'rate_type',
            'unit_amount',
            // 'duration',
            // 'loan_award_percentage',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
