<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\AcademicYear;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SystemSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'System Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-setting-index">
    <p>
        <?= Html::a('Create System Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'currency_id',
//            'waiting_days_for_uncollected_disbursement_return',
            ['attribute' => 'application_open_date', 'format' => ['date', 'php:d/m/Y']],
            ['attribute' => 'application_close_date', 'format' => ['date', 'php:d/m/Y']],
            'minimum_loanable_amount',
//            'loan_repayment_grace_period_days',
//            'employee_monthly_loan_repayment_percent',
//            'self_employed_monthly_loan_repayment_amount',
//            'previous_loan_repayment_for_new_loan',
            'total_budget',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
