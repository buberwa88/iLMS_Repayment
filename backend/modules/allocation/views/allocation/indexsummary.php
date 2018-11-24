<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List  of Allocated Student Summary';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-index">
   <div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'allocation_id',
           // 'allocation_batch_id',
           // '',
                 [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('allocation_batch_summary',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
                   [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->application->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'surName',
                         'label'=>"Last Name",
                        'vAlign' => 'middle',
                         
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->application->applicant->user->surname;
                        },
                    ],
                    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->application->applicant->f4indexno;
                        },
                    ],
           
//                    [
//                        'attribute' => 'loan_item_id',
//                        'vAlign' => 'middle',
//                        'width' => '200px',
//                        'value' => function ($model) {
//                            return $model->loanItem->item_name;
//                        },
//                        'filterType' => GridView::FILTER_SELECT2,
//                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => ['allowClear' => true],
//                        ],
//                        'filterInputOptions' => ['placeholder' => 'Search '],
//                        'format' => 'raw'
//                    ],
           // 'allocated_amount',
                    [
                    'attribute' => 'allocated_amount',
                    'value' => function ($model) {
                    return backend\modules\allocation\models\Allocation::find()->where(['application_id'=>$model->application->application_id,'allocation_batch_id'=>$model->allocation_batch_id])->sum('allocated_amount');
                    },
                    'hAlign'=>'right',
                    'format'=>['decimal', 2],
                    //'label'=>"Status",
                    'width' => '130px',
                    ], 
                                                  
            // 'is_canceled',
            // 'cancel_comment:ntext',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
   </div>
</div>