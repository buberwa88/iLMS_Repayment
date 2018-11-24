<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\LearningInstitutionFeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schoool Fees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-fee-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create School Fee', ['create'], ['class' => 'btn btn-success']) ?>
                <?=
                \yii\bootstrap\Html::a('Clone School fees', ['/allocation/learning-institution-fee/clone'], ['class' => 'btn btn-warning',
                    'data' => [
                        'confirm' => 'Are you sure you want to Clone school fees?',
                        'method' => 'post',
                    ],]
                );
                ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'learning_institution_fee_id',
                    [
                        'attribute' => 'learning_institution_id',
                        'vAlign' => 'middle',
                        //   'width' => '200px',
                        'value' => function ($model) {
                            return $model->learningInstitution->institution_name;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        // 'width' => '200px',
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
                        'attribute' => 'study_level',
                        'hAlign' => 'right',
                        'value' => function($model) {
                            return \backend\modules\allocation\models\LearningInstitution::getStudyLevelNameByValue($model->study_level);
                        },
                        'width' => '200px',
                    ],
                    [
                        'attribute' => 'fee_amount',
                        'hAlign' => 'right',
                        'format' => ['decimal', 2],
                        //'label'=>"Status",
                        'width' => '200px',
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}'],
                ],
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>