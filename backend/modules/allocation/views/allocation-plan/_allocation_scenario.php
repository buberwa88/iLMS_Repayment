<?php

use yii\helpers\Html;
?>
<!--<div class="panel-heading"><h4>Allocation Scenarios or Criterias </h4></div>-->
<p>
    <?php if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) { ?>

        <?= Html::a('Add Execution order', ['/allocation/allocation-plan/add-scenario', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    <?php
//    if ($model_scenarios->totalCount && $model->allocation_plan_stage != backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE) {
//
//        echo \yii\bootstrap\Html::a('Copy Setting', ['/allocation/allocation-plan/clone-scenario-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
//            'data' => [
//                'confirm' => 'Are you sure you want to Copy Scenrio Setting from One Academic Year Into another?',
//                'method' => 'post',
//            ],]
//        );
//    }
    ?>
</p>
<?=
kartik\grid\GridView::widget([
    'dataProvider' => $model_scenarios,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'allocation_scenario',
            'value' => function ($model) {
                return $model->getName();
            },
        ],
        'priority_order',
        [
            'class' => 'yii\grid\ActionColumn',
            //    'visible' => ($model_scenarios->is_active != \backend\modules\allocation\models\AllocationPlan::STATUS_CLOSED) ? TRUE : FALSE,
            'header' => 'Action',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{delete}',
            'visible' => ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) ? TRUE : FALSE,
            'buttons' => [
                'delete' => function ($url, $model) {
                    $url = yii\helpers\Url::to(['allocation-plan/delete-scenario', 'id' => $model->allocation_plan_id,'item'=> $model->allocation_scenario_scenario_id]);
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                'title' => 'delete',
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                    ]);
                }
                    ],
                ],
            ],
        ]);
        ?>
