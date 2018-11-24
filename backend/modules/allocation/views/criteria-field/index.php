<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\CriteriaFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Criteria Fields';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="criteria-field-index">
    <div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <p>
                <?php
                if ($model->criteria->is_active == \backend\modules\allocation\models\Criteria::STATUS_INACTIVE) {
                    echo Html::a('Create Criteria Field', ['create', 'id' => $id], ['class' => 'btn btn-success']);
                }
                ?>
                <?= Html::a('Search', '#', ['class' => 'btn btn-info search-button']) ?>
            </p>
            <div class="search-form" style="display:none">
                <?= $this->render('_search', ['model' => $searchModel, 'id' => $id]); ?>
            </div>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'allowBatchToggle' => true,
                        'detail' => function ($model) {
                            return $this->render('view', ['model' => $model]);
                        },
                                'detailOptions' => [
                                    'class' => 'kv-state-enable',
                                ],
                            ],
                            // 'criteria_field_id',
                            // 'criteria_id',
                            'applicantCategory.applicant_category',
                            'source_table',
                            // 'source_table_field',
                            //'operator',
//             'value',
//             'parent_id',
//             'join_operator',
                            [
                                'attribute' => 'type',
                                'vAlign' => 'middle',
                                'width' => '130px',
                                'value' => function ($model) {
                                  return backend\modules\allocation\models\CriteriaField::getCriteriaFieldTypeNameByValue($model->type);
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => [1 => 'Eligibility', 2 => 'Needness', 3 => 'Source'],
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Search  '],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'academic_year_id',
                                'vAlign' => 'middle',
                                'width' => '120px',
                                'value' => function ($model) {
                                    return $model->academicYear->academic_year;
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Search '],
                                'format' => 'raw'
                            ],
                            //  'academic_year_id',
                            // 'type',
                            'value',
                            'operator',
                            'weight_points',
                            'priority_points',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{delete}'
                            ],
                        ],
                        'hover' => true,
                            //'condensed' => true,
                            //'floatHeader' => true,
                    ]);
                    ?>
        </div>
    </div>
</div>