<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkSpecialGroup */

$this->title = $model->special_group_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Framework Special Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-framework-special-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->special_group_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->special_group_id], [
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
            'special_group_id',
            'allocation_framework_id',
            'group_name',
            'applicant_source_table',
            'applicant_souce_column',
            'applicant_source_value',
            'operator',
        ],
    ]) ?>

</div>
