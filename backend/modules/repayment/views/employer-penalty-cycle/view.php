<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerPenaltyCycle */

$this->title = 'Employer Penalty Cycle Details #' . $model->employer_penalty_cycle_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalty Cycles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?= Html::a('Update', ['update', 'id' => $model->employer_penalty_cycle_id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->employer_penalty_cycle_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'employer_id',
                        'value' => $model->employer_id ? $model->employer->employer_name : 'ALL',
                    ],
                    'repayment_deadline_day',
                    'penalty_rate',
                    'duration',
                    [
                        'attribute' => 'duration_type',
                        'value' => $model->getDurationTypeName(),
                    ],
                    [
                        'attribute' => 'is_active',
                        'value' => $model->is_active ? 'Active' : 'In Active',
                    ],
                    [
                        'attribute' => 'cycle_type',
                        'value' => $model->getCycleTypeName(),
                    ],
                    'start_date',
                    'end_date',
                    //'created_at',
                    //'created_by',
                    //'updated_at',
                    //'updated_by',
                ],
            ])
            ?>

        </div>
    </div>
</div>
