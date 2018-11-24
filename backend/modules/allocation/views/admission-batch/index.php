<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AdmissionBatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admission Batch';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-batch-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Admission Batch', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'admission_batch_id',
               [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
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
            'batch_number',
            'batch_desc',
         //   'created_at',
            // 'created_by',

             ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" title="Edit"></span>',
                            $url);
                    },
                      'view' => function ($url,$model,$key) {
                            return Html::a('<span class="green"> <i class="glyphicon glyphicon-search" title="View"></i></span>', $url);
                    },

                ],
                ],
        ],
    ]); ?>
</div>
 </div>
</div>