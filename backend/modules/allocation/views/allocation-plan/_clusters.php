<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="scholarship-learning-institution-index">
    <!--<h4>Learning Institutions</h4>-->
    <p>
        <?php
        if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) {
            echo \yii\bootstrap\Html::a('Add Cluster Setting', ['/allocation/allocation-plan/add-cluster-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success']);
        }
        ?>
        <?php
//        if ($model_clusters->totalCount && $model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_ACTIVE) {
//            echo \yii\bootstrap\Html::a('Copy Existing Cluster setting', ['/allocation/allocation-plan/clone-cluster-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
//                'data' => [
//                    'confirm' => 'Are you sure you want to Copy Cluster Setting from One Academic Year Into another?',
//                    'method' => 'post',
//                ],]
//            );
//        }
        ?>
    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_clusters,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'clusterDefinition.cluster_name',
            'cluster_priority',
            'student_percentage_distribution',
            //'budget_percentage_distribution',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visible' => ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) ? TRUE : FALSE,
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = yii\helpers\Url::to(['allocation-plan/delete-cluster', 'id' =>$model->allocation_plan_id,'item'=>$model->allocation_plan_cluster_setting_id]);
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                    'title' => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                        ]);
                    }
                        ]
                    ]
                ],
            ]);
            ?>
</div>
