<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Allocation History';
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

               [
                        'attribute' => 'loan_item_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
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
           // 'allocated_amount',
                  [
                      'attribute' => 'allocated_amount',
                     'hAlign'=>'right',
                          'format'=>['decimal', 2],
                        //'label'=>"Status",
                        //'width' => '200px',    
                  ],   
        ],
    ]); ?>
</div>
 </div>
</div>