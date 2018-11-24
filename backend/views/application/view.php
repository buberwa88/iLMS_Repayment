<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

$this->title = $model->application_id;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->application_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->application_id], [
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
            'application_id',
            'applicant_id',
            'academic_year_id',
            'bill_number',
            'control_number',
            'receipt_number',
            'amount_paid',
            'pay_phone_number',
            'date_bill_generated',
            'date_control_received',
            'date_receipt_received',
            'programme_id',
            'application_study_year',
            'current_study_year',
            'applicant_category_id',
            'bank_account_number',
            'bank_account_name',
            'bank_id',
            'bank_branch_name',
            'submitted',
            'verification_status',
            'needness',
            'allocation_status',
            'allocation_comment',
            'student_status',
            'created_at',
        ],
    ]) ?>

</div>
