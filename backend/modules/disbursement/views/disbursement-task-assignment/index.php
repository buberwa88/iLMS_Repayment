<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementTaskAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement Task Assignment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-task-assignment-index">
    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Task Assignment', ['create','id'=>$disbursement_schedule_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'disbursement_task_assignment_id',
            //'disbursement_schedule_id',
            
                [
                        'attribute' => 'disbursement_structure_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->disbursementStructure->structure_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementStructure::find()->asArray()->all(),'disbursement_structure_id','structure_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'disbursement_task_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->disbursementTask->task_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementTask::find()->asArray()->all(),'disbursement_task_id','task_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
           // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'deleted_by',
            // 'deleted_at',

            ['class' => 'yii\grid\ActionColumn',
             'template'=>'{update}{delete}'],
        ],
          'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
    </div>
</div>