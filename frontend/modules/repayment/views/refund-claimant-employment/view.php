<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimantEmployment */

$this->title = $model->refund_claimant_employment_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Claimant Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-employment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_claimant_employment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_claimant_employment_id], [
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
            'refund_claimant_employment_id',
            'employer_name',
            'start_date',
            'end_date',
            'refund_claimant_id',
            'refund_application_id',
            'employee_id',
            'matching_status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
