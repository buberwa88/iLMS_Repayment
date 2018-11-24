<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\modules\allocation\models\Programme;
use backend\modules\allocation\models\StudentExamResult;
use backend\modules\allocation\models\ExamStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\StudentExamResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Exam Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-index">
    <div class="panel panel-info">
     
        <div class="panel-body">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//               [
//                'class' => 'kartik\grid\ExpandRowColumn',
//                'value' => function ($model, $key, $index, $column) {
//                    return GridView::ROW_COLLAPSED;
//                },
//                'allowBatchToggle' => true,
//                'detail' => function ($model) {
//                  return $this->render('_view_details',['model'=>$model]);  
//                },
//                'detailOptions' => [
//                    'class' => 'kv-state-enable',
//                ],
//                ],
                    //'student_exam_result_id',
                    //'registration_number',
                    [
                        'attribute' => 'academic_year_id',
                        'label' => 'Year',
                        'vAlign' => 'middle',
                        'width' => '40px',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->academicYear->academic_year;
                        },
                    ],
                    [
                        'attribute' => 'study_year',
                        'label' => 'YOS',
                        'vAlign' => 'middle',
                        'width' => '20px',
                        'value' => function ($model) {
                            return $model->study_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'semester',
                        'label' => 'Semester',
                        'vAlign' => 'middle',
                        'hAlign' => 'centre',
                        'width' => '10px',
                        'format' => 'raw',
                        'value' => 'semester'
                    ],
                    [
                        'attribute' => 'registration_number',
                        'label' => 'Student Reg#',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                        'width' => '130px',
                        'value' => function($model) {
                            return $model->registration_number;
                        },
                    ],
                    [
                        'attribute' => 'is_beneficiary',
                        'label' => 'Beneficiary',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
//                        'width' => '100px',
                        'value' => function($model) {
                            switch ($model->is_beneficiary) {
                                case 1:
                                    return 'Yes';
                                    break;
                                case 2:
                                    return 'No';
                                    break;

                                default:
                                    return NULL;
                                    break;
                            }
                        },
                    ],
                    [
                        'attribute' => 'programme_id',
                        'vAlign' => 'middle',
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                        'width' => '300px',
                        'value' => function ($model) {
                            return $model->programme->programme_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'exam_status_id',
                        'vAlign' => 'middle',
                        'width' => '100px',
                        'value' => function ($model) {
                            return $model->examStatus->status_desc;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'HLI Approval',
                        'format' => 'raw',
                        'width' => '100px',
                        'value' => function($model) {
                            switch ($model->status) {
                                case StudentExamResult::STATUS_DRAFT:
                                    return '<span class="label label-danger">Pending';
                                    break;
                                case StudentExamResult::STATUS_VERIFIED:
                                    return '<span class="label label-info">Verified';
                                    break;
                                case StudentExamResult::STATUS_CONFIRMED:
                                    return '<span class="label label-success"> Confirmed ';
                                    break;
                            }
                        },
                    ],
                ],
            ]);
            ?>
            <div class="text-right">
                <?= Html::submitButton('Confirm selected results', ['class' => 'btn btn-warning',]); ?>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>

</div>