<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting */

$this->title = 'Update Allocation Plan Institution Type Setting: ' . $model->allocation_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Institution Type Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_plan_id, 'url' => ['view', 'allocation_plan_id' => $model->allocation_plan_id, 'institution_type' => $model->institution_type]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-plan-institution-type-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
