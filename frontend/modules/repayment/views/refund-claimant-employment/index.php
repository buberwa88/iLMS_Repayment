<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEmploymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Claimant Employments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-employment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Claimant Employment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_claimant_employment_id',
            'employer_name',
            'start_date',
            'end_date',
            'refund_claimant_id',
            // 'refund_application_id',
            // 'employee_id',
            // 'matching_status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
