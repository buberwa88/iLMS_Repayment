<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPrioritySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Priorities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-priority-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Priority', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'allocation_priority_id',
            'academic_year_id',
            'source_table',
            'source_table_field',
            'field_value',
            // 'priority_order',
            // 'base_line',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
