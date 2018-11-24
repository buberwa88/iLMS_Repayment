<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */

$this->title = $model->employer_penalty_payment_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalty Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->employer_penalty_payment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->employer_penalty_payment_id], [
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
            'employer_penalty_payment_id',
            'employer_id',
            'amount',
            'payment_date',
            'created_at',
        ],
    ]) ?>

</div>
