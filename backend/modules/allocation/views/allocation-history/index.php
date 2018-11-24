<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Allocations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-history-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Award Student Loan', ['allocate'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'academic_year_id',
                        'value' => 'academicYear.academic_year',
                    ],
                    [
                        'attribute' => 'allocation_name',
                        'label' => 'Name',
                        'value' => 'allocation_name',
                    ],
                    [
                        'attribute' => 'allocation_framework_id',
                        'label' => 'Framework Used',
                        'value' => 'allocationFramework.allocation_plan_title',
                    ],
                    [
                        'attribute' => 'study_level',
                        'value' => function($model) {
                            return $model->getStudyLevelName();
                        }
                    ],
                    [
                        'attribute' => 'place_of_study',
                        'value' => function($model) {
                            return $model->getPlaceofStudy();
                        }
                    ],
                    [
                        'attribute' => 'student_type',
                        'value' => function($model) {
                            return $model->getStudentTypeName();
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            return strtoupper($model->getStatusName());
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
