<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerPenaltyCycle */

$this->title = $model->employer_penalty_cycle_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalty Cycles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-cycle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->employer_penalty_cycle_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->employer_penalty_cycle_id], [
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
            'employer_penalty_cycle_id',
            'employer_id',
            'repayment_deadline_day',
            'penalty_rate',
            'duration',
            'duration_type',
            'is_active',
            'cycle_type',
            'start_date',
            'end_date',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
