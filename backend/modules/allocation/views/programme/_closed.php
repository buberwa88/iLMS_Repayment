<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ProgrammeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Higher Learning Institution Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-index">
    <div class="panel panel-info">
        <div class="panel-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'programme_id',
                    'programme_name',
                    'programme_code',
                    [
                        'attribute' => 'learning_institution_id',
                        'vAlign' => 'middle',
                        //  'width' => '200px',
                        'value' => function ($model) {
                            return $model->learningInstitution->institution_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\application\models\LearningInstitution::find()->where(["institution_type" => "UNIVERSITY"])->asArray()->all(), 'learning_institution_id', 'institution_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'programme_group_id',
                        'value' => function($model) {
                            return backend\modules\allocation\models\ProgrammeGroup::getGroupNameByID($model->programme_group_id);
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\allocation\models\ProgrammeGroup::find()->asArray()->all(), 'programme_group_id', 'group_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
//                        'format' => 'raw'
                    ],
//                    [
//                        'attribute' => 'years_of_study',
//                        'vAlign' => 'middle',
//                        'width' => '120px',
//                        'value' => function ($model) {
//                            return $model->years_of_study;
//                        },
//                        'filterType' => GridView::FILTER_SELECT2,
//                        'filter' => Yii::$app->params['programme_years_of_study'],
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => ['allowClear' => true],
//                        ],
//                        'filterInputOptions' => ['placeholder' => 'Search '],
//                        'format' => 'raw'
//                    ],
                    [
                        'attribute' => 'is_active',
                        'value' => function($model) {
                            return $model->getStatusNameByValue();
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'options' => ['style' => 'width:60px;'],
                        'template' => '{view}{update}{delete}'
                    ],
                ],
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>