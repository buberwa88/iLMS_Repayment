<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummaryDetail */

$this->title = $model->loan_summary_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Bill Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-summary-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_summary_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->loan_summary_detail_id], [
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
            'loan_summary_detail_id',
            'loan_summary_id',
            'applicant_id',
            'loan_repayment_item_id',
            'academic_year_id',
            'amount',
        ],
    ]) ?>

</div>
