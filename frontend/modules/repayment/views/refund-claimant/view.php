<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */

$this->title = $model->refund_claimant_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Claimants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_claimant_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_claimant_id], [
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
            'refund_claimant_id',
            'applicant_id',
            'firstname',
            'middlename',
            'surname',
            'sex',
            'phone_number',
            'f4indexno',
            'f4_completion_year',
            'necta_firstname',
            'necta_middlename',
            'necta_surname',
            'necta_sex',
            'necta_details_confirmed',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
