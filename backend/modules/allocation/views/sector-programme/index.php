<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\SectorProgrammeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Sector Programme';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-programme-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sector Programme', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'sector_programme_id',
             [
                        'attribute' => 'sector_definition_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->sectorDefinition->sector_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>ArrayHelper::map(backend\modules\allocation\models\SectorDefinition::find()->asArray()->all(), 'sector_definition_id', 'sector_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
            //'sectorDefinition.sector_name',
                   [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
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
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
 </div>
</div>