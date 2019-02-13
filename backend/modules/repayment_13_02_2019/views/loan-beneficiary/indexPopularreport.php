<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\PopularReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Favourites Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="popular-report-index">
    <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Add Report', ['create-popularreport'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            //'report_id',
            [
                     'attribute' => 'report_id',
                        'label'=>"Report Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            
                             return $model->report->name;   
                            
                        },
                    ],
            [
                     'attribute' => 'package',
                        'label'=>"Narration",
                        'format' => 'raw',
                        'value' => function ($model) {
                            
                             return $model->report->package;   
                            
                        },
                    ],                    
            //'rate',
            //'set_date',
                  [
'class'    => 'yii\grid\ActionColumn',
'template' => '{view}{delete}',
'buttons'  => [ 
    'view' => function ($url, $model) {
        $url = Url::to(['loan-beneficiary/view-popularreport', 'id' => $model->report_id]);
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
    
    },
    'delete' => function ($url, $model) {
        $url = Url::to(['loan-beneficiary/delete-popularreport', 'id' => $model->id]);
        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
            'title'        => 'delete',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method'  => 'post',
        ]);
    
    },
]
]
        ],
    ]); ?>
</div>
  </div>
</div>
