<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Framework';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create/Add Framework', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'academicYear.academic_year',
                    'allocation_plan_title',
                    'allocation_plan_desc',
                    'allocation_plan_number',
                    [
                        'attribute' => 'allocation_plan_stage',
                        'value' => function($model) {
                            return $model->getStatusNameByValue();
                        }
                    ],
                    // 'created_at',
                    ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
