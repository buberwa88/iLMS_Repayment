<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\allocation\models\ScholarshipDefinition;
?>
<div class="scholarship-student-index">
    <!--    <h4>Grant / Scholarship Students</h4>-->
    <p>
        <?php if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) { ?>

            <?= \yii\bootstrap\Html::a('Add Loan Item Setting', ['/allocation/allocation-plan/add-loan-item-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_loan_item,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute' => 'item_name',
                'label' => 'Loan Item',
                'value' => 'loanItem.item_name',
            ],
            'priority_order',
//            ['attribute' => 'unit_amount',
//                'value' => 'unit_amount',
////                'format'=>  Yii::$app->formatter
//            ],
            ['attribute' => 'rate_type',
                'value' => function($model) {
                    return backend\modules\allocation\models\LoanItem::getItemRateByValue($model->rate_type);
                },
            ],
            [
                'attribute' => 'loan_award_percentage',
                'label' => 'Minimum Loan Award %',
                'value' => 'loan_award_percentage',
            ],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visible' => ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) ? TRUE : FALSE,
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['allocation-plan/delete-loan-item', 'id' => $model->allocation_plan_id, 'item' => $model->loan_item_id]);
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                    'title' => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                        ]);
                    },
                        ],
                    ]
                ],
            ]);
            ?>
</div>
