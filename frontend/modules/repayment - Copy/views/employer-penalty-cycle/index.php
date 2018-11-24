<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\EmployerPenaltyCycleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Penalty Cycles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-cycle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employer Penalty Cycle', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'employer_penalty_cycle_id',
            'employer_id',
            'repayment_deadline_day',
            'penalty_rate',
            'duration',
            // 'duration_type',
            // 'is_active',
            // 'cycle_type',
            // 'start_date',
            // 'end_date',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
