<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPlanClusterSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Plan Cluster Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-cluster-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Plan Cluster Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'allocation_plan_cluster_setting_id',
            'allocation_plan_id',
            'cluster_definition_id',
            'cluster_priority',
            'student_percentage_distribution',
            // 'budget_percentage_distribution',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
