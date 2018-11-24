<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\allocation\models\AllocationBatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List of Allocation Batch');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Allocation Batch'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'allocation_batch_id',
            'batch_number',
            'batch_desc',
           // 'academic_year_id',
               [
                'attribute' => 'academic_year_id',
                'vAlign' => 'middle',
                'width' => '400px',
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
           // 'available_budget',
            // 'is_approved',
            // 'approval_comment:ntext',
            // 'created_at',
            // 'created_by',
            // 'is_canceled',
            // 'cancel_comment:ntext',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{delete}'],
        ],
       'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>