<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting */

$this->title = $model->allocation_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Institution Type Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-institution-type-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'allocation_plan_id' => $model->allocation_plan_id, 'institution_type' => $model->institution_type], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'allocation_plan_id' => $model->allocation_plan_id, 'institution_type' => $model->institution_type], [
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
            'allocation_plan_id',
            'institution_type',
            'student_distribution_percentage',
        ],
    ]) ?>

</div>
