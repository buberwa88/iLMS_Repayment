<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationFrameworkScenarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Framework Scenarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-framework-scenario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Framework Scenario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'allocation_framework_scenario_id',
            'allocation_framework_id',
            'allocation_scenario',
            'priority_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
