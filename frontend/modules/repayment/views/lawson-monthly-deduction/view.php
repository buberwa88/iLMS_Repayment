<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LawsonMonthlyDeduction */

$this->title = $model->lawson_monthly_deduction_id;
$this->params['breadcrumbs'][] = ['label' => 'Lawson Monthly Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lawson-monthly-deduction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->lawson_monthly_deduction_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->lawson_monthly_deduction_id], [
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
            'lawson_monthly_deduction_id',
            'ActualBalanceAmount',
            'CheckDate',
            'CheckNumber',
            'DateHired',
            'DeductionAmount',
            'DeductionCode',
            'DeductionDesc',
            'DeptName',
            'FirstName',
            'LastName',
            'MiddleName',
            'NationalId',
            'Sex',
            'VoteName',
            'Votecode',
            'created_at',
        ],
    ]) ?>

</div>
