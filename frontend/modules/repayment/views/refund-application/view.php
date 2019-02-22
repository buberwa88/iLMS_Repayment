<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundApplication */

$this->title = $model->refund_application_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_application_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_application_id], [
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
            'refund_application_id',
            'refund_claimant_id',
            'application_number',
            'refund_claimant_amount',
            'finaccial_year_id',
            'academic_year_id',
            'trustee_firstname',
            'trustee_midlename',
            'trustee_surname',
            'trustee_sex',
            'current_status',
            'refund_verification_framework_id',
            'check_number',
            'bank_account_number',
            'bank_account_name',
            'bank_id',
            'refund_type_id',
            'liquidation_letter_number',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'is_active',
            'submitted',
        ],
    ]) ?>

</div>
