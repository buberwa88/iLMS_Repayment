<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanClusterSetting */

$this->title = 'Create Allocation Plan Cluster Setting';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Cluster Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-cluster-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
