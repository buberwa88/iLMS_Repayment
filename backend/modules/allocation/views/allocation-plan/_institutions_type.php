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
            echo \yii\bootstrap\Html::a('Add Institution Type setting', ['/allocation/allocation-plan/add-institution-type', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success']);
        }
        ?>

        <?php
//        if ($model_institutions_type->totalCount && $model->allocation_plan_stage != backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE) {
//
//            echo \yii\bootstrap\Html::a('Copy Existing Into New Academic Year', ['/allocation/allocation-plan/clone-institution-type', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
//                'data' => [
//                    'confirm' => 'Are you sure you want to Copy Institution Type Setting from One Academic Year Into another?',
//                    'method' => 'post',
//                ],]
//            );
//        }
        ?>

    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_institutions_type,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'institution_type',
                'value' => function($model) {
                    return backend\modules\allocation\models\LearningInstitution::getOwneshipsNameByValue($model->institution_type);
                },
            ],
            'student_distribution_percentage',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visible' => ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) ? TRUE : FALSE,
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['allocation-plan/delete-plan-institution-type', 'id' => $model->allocation_plan_id, 'type' => $model->institution_type]);
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                    'title' => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                        ]);
                    },
                        ]
                    ]
                ],
            ]);
            ?>
</div>
