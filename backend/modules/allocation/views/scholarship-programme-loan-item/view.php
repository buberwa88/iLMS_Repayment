<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgrammeLoanItem */

$this->title = $model->scholarships_id;
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Programme Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-programme-loan-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'scholarships_id' => $model->scholarships_id, 'programme_id' => $model->programme_id, 'loan_item_id' => $model->loan_item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'scholarships_id' => $model->scholarships_id, 'programme_id' => $model->programme_id, 'loan_item_id' => $model->loan_item_id], [
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
            'created_at',
            'academic_year_id',
            'scholarships_id',
            'programme_id',
            'loan_item_id',
            'rate_type',
            'unit_amount',
            'duration',
        ],
    ]) ?>

</div>
