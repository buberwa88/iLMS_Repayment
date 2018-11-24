<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\StudentExamResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Exam Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-index">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Student Exam Result', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
               [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('view',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
            //'student_exam_result_id',
            'registration_number',
            'f4indexno',
          //  'academic_year_id',
            //'programme_id',
              [
                  'attribute' => 'programme_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->programme->programme_code;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
           //  'study_year',
            [
                  'attribute' => 'study_year',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->study_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>1,2=>2,3=>3,4=>4,5=>5],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            // 'exam_status_id',
            [
                  'attribute' => 'exam_status_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->exam_status_id;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\ExamStatus::find()->asArray()->all(), 'exam_status_id', 'status_desc'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            // 'semester',
            // 'confirmed',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn',
             'template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
</div>
    
</div>