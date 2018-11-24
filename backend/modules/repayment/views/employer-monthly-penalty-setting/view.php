<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerMonthlyPenaltySetting */

$this->title = $model->employer_mnthly_penalty_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Monthly Penalty Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-monthly-penalty-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->employer_mnthly_penalty_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->employer_mnthly_penalty_setting_id], [
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
            'employer_mnthly_penalty_setting_id',
            'employer_type_id',
            'payment_deadline_day_per_month',
            'penalty',
            'is_active',
            'created_at',
            'created_by',
        ],
    ]) ?>

</div>
