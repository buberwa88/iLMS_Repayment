<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-schedule-index">
    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Disbursement Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'disbursement_schedule_id',
            'operator_name',
           // 'from_amount',
                [
                      'attribute' => 'from_amount',
                     'hAlign'=>'right',
                          'format'=>['decimal', 2],
                        //'label'=>"Status",
                       // 'width' => '130px',    
                  ],  
           // 'to_amount',
                [
                      'attribute' => 'to_amount',
                     'hAlign'=>'right',
                          'format'=>['decimal', 2],
                        //'label'=>"Status",
                      //  'width' => '130px',    
                  ],  
           // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
         'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
    </div>
</div>