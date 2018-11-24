<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<!--<div class="panel-heading"><h4>Allocation Special Groups </h4></div>-->
<p><?php if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) { ?>

        <?= Html::a('Add/Set Special Group', ['/allocation/allocation-plan/add-special-group', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success']) ?>

    <?php } ?>
    <?php
//        if ($model_loan_item->totalCount && $model->allocation_plan_stage != backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE) {
//
//            echo \yii\bootstrap\Html::a('Copy Setting', ['/allocation/allocation-plan/clone-special-group-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
//                'data' => [
//                    'confirm' => 'Are you sure you want to Special Group Setting from One Academic Year Into another?',
//                    'method' => 'post',
//                ],]
//            );
//        }
    ?>
</p>


<?=
kartik\grid\GridView::widget([
    'dataProvider' => $model_special_group,
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'allocation_group_criteria_id',
            'value' => 'criteria.criteria_description'
        ],
        'group_description',
        'priority_order',
        [
            'class' => 'yii\grid\ActionColumn',
            'visible' => ($model->allocation_plan_stage != \backend\modules\allocation\models\AllocationPlan::STATUS_CLOSED) ? TRUE : FALSE,
            'header' => 'Action',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{delete}',
            'visible' => ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) ? TRUE : FALSE,
            'buttons' => [
                'delete' => function ($url, $model) {
                    $url = Url::to(['allocation-plan/delete-plan-specialgroup', 'id' =>$model->allocation_plan_id,'item'=>$model->special_group_id]);
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                'title' => 'delete',
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                    ]);
                },
                    ],
                ],
            ],
        ]);
        ?>
