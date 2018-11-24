<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanClusterSetting */

$this->title = 'Update Allocation Plan Cluster Setting: ' . $model->allocation_plan_cluster_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Cluster Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_plan_cluster_setting_id, 'url' => ['view', 'id' => $model->allocation_plan_cluster_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-plan-cluster-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
