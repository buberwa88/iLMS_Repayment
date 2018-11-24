<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ClusterProgrammeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cluster Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-field-index">
    <div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <p>
                <!--ALLOW ONLY TOADD PROGRAM WHEN CLUSTER IS ACTIVE-->
                <?php if ($cmodel->is_active): ?>
                    <?= Html::a('Create Cluster Programme', ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>

                <?php endif; ?>
            </p>


            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['IN', "is_current", [0, 1]])->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'programme_id',
                        'value' => 'programme.programme_name',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\application\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'programme_category_id',
                        'vAlign' => 'middle',
                        // 'width' => '200px',
                        'value' => 'programmeCategory.programme_category_name',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeCategory::find()->asArray()->all(), 'programme_category_id', 'programme_category_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'programme_group_id',
                        'vAlign' => 'middle',
                        // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->programmeGroup->group_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeGroup::find()->asArray()->all(), 'programme_group_id', 'group_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    'programme_priority',
                    [
                        'attribute' => 'institution',
                        'value' => 'programme.learningInstitution.institution_name'
                    ],
                    ['class' => 'yii\grid\ActionColumn',
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