<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationHistory */

$this->title = $model->allocation_name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Allocation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-history-view">
    <!--<div class="panel panel-info">-->
    <!--<div class="panel-body">-->
    <p>
        <?php
        if ($model->status == backend\modules\allocation\models\AllocationHistory::STATUS_DRAFT) {
            echo Html::a('Mark as Reviewed', ['review', 'id' => $model->loan_allocation_history_id], ['class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to Mark this Allocation as Reviewed?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        <?php
        if ($model->status == backend\modules\allocation\models\AllocationHistory::STATUS_REVIEWED) {
            echo Html::a('Approve this Allocation', ['approve', 'id' => $model->loan_allocation_history_id], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure you want to Approve this Allocation?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        <?php
        if ($model->status == backend\modules\allocation\models\AllocationHistory::STATUS_DRAFT) {
            echo Html::a('Delete', ['delete', 'id' => $model->loan_allocation_history_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'academic_year_id',
                'value' => $model->academicYear->academic_year,
            ],
            'allocation_name',
            [
                'attribute' => 'description',
                'label' => 'Description',
                'value' => $model->description,
            ],
            [
                'attribute' => 'allocation_framework_id',
                'label' => 'Framework Used',
                'value' => $model->allocationFramework->allocation_plan_title,
            ],
            [
                'attribute' => 'study_level',
                'value' => $model->getStudyLevelName()
            ],
            [
                'attribute' => 'place_of_study',
                'value' => $model->getPlaceofStudy()
            ],
            [
                'attribute' => 'student_type',
                'value' => $model->getStudentTypeName()
            ],
            [
                'attribute' => 'status',
                'value' => strtoupper($model->getStatusName())
            ],
         
            'created_at',
//                    'created_by',
            'reviewed_at',
//                    'reviewed_by',
            'approved_at',
//                    'approved_by',
               'totalAllocatedAmount',
        ],
    ])
    ?>
    <!--</div>-->
    <!--</div>-->
</div>
