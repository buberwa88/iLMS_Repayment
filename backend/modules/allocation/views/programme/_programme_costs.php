<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
?>
<div class="programme-fee-index">
    <div class="panel panel-info">

        <div class="panel-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>
            <p>
                <?= Html::a('Add Programme Cost', ['/allocation/programme/cost','id'=>$model->programme_id], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Clone Programme Cost', ['/allocation/programme/clone-programme-cost','id'=>$model->programme_id], ['class' => 'btn btn-warning']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    /*
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
                     * 
                     */
                            [
                                'attribute' => 'academic_year_id',
                                'vAlign' => 'middle',
                                'width' => '130px',
                                'value' => function ($model) {
                                    return $model->academicYear->academic_year;
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Search'],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'loan_item_id',
                                'vAlign' => 'middle',
                                //  'width' => '200px',
                                'value' => function ($model) {
                                    return $model->loanItem->item_name;
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Search '],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'year_of_study',
                                'vAlign' => 'middle',
                                'width' => '120px',
                                'value' => function ($model) {
                                    return $model->year_of_study;
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
                                'attribute' => 'unit_amount',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                'value' => function($model){
                                //'label'=>"Status",
                                    return $model->unit_amount;
                                }
                                //'width' => '200px',
                            ],
                            [
                                'attribute' => 'rate_type',
                                'hAlign' => 'justify',
                                'value' => function($model) {
                                    return backend\modules\allocation\models\LoanItem::getLoanItemRateNameByItemId($model->loan_item_id);
                                },
                                'format' => ['text'],
                                'label' => "Rate/Amount",
                            ],
                            'duration',
                            ['class' => 'yii\grid\ActionColumn',
                                'options' => ['style' => 'width:60px;'],
                                'template' => '{update}{delete}'],
                        ],
                        'hover' => true,
                        'condensed' => true,
                        'floatHeader' => true,
                    ]);
                    ?>
        </div>
    </div>
</div>