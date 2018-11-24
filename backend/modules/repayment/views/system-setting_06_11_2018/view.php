<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemSetting */

$this->title = $model->system_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->system_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->system_setting_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'system_setting_id',
            'academic_year_id',
            'currency_id',
            'waiting_days_for_uncollected_disbursement_return',
            'application_open_date',
            'application_close_date',
            'minimum_loanable_amount',
            'loan_repayment_grace_period_days',
            'employee_monthly_loan_repayment_percent',
            'self_employed_monthly_loan_repayment_amount',
            'previous_loan_repayment_for_new_loan',
            'total_budget',
        ],
    ]) ?>

</div>
