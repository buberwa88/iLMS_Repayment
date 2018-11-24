<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanClusterSetting */

$this->title = $model->allocation_plan_cluster_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Cluster Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-cluster-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->allocation_plan_cluster_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->allocation_plan_cluster_setting_id], [
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
            'allocation_plan_cluster_setting_id',
            'allocation_plan_id',
            'cluster_definition_id',
            'cluster_priority',
            'student_percentage_distribution',
            'budget_percentage_distribution',
        ],
    ]) ?>

</div>
