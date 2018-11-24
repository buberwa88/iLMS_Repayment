<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanStudent */

$this->title = 'Update Allocation Plan Student: ' . $model->allocation_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_plan_id, 'url' => ['view', 'allocation_plan_id' => $model->allocation_plan_id, 'application_id' => $model->application_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-plan-student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
