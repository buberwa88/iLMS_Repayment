<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\EmployerPenaltyCycleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Penalty Cycles';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">

        <p>
            <?= Html::a('Create/Set Employer Penalty Cycle', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'employer_id',
                'repayment_deadline_day',
                'penalty_rate',
                'duration',
                'duration_type',
                'is_active',
                'cycle_type',
                'start_date',
                'end_date',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
    </div>
