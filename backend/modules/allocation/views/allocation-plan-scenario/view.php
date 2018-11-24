<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkScenario */

$this->title = $model->allocation_framework_scenario_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Framework Scenarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-framework-scenario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->allocation_framework_scenario_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->allocation_framework_scenario_id], [
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
            'allocation_framework_scenario_id',
            'allocation_framework_id',
            'allocation_scenario',
            'priority_order',
        ],
    ]) ?>

</div>
