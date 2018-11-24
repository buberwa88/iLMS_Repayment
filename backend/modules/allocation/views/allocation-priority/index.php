<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPrioritySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Allocation Priorities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-priority-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Allocation Priority', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'allocation_priority_id',
                    [
                        'attribute' => 'academic_year_id',
                        'value' => function($model) {
                            return common\models\AcademicYear::getNameById($model->academic_year_id);
                        }
                    ],
                    [
                        'attribute' => 'source_table',
                        'value' => function($model) {
                            return backend\modules\allocation\models\SourceTable::getNamebyId($model->source_table);
                        }
                    ],'source_table_field',
                    [
                        'attribute' => 'field_value',
                        'value' => function($model) {
                            return $model->getSourceTableValue();
                        }
                    ],
                    'priority_order',
                    [
                        'attribute' => 'baseline',
                        'value' => function($model) {
                            return Yii::$app->params['AllocationBaseline'][$model->baseline];
                        },
                    ],
                    // 'created_at',
                    // 'created_by',
                    // 'updated_at',
                    // 'updated_by',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>