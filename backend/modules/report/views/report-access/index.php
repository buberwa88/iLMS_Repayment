<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportAccessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Accesses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-access-index">
       <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <p>
       <?= Html::a('Create Report Access', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'report_access_id',
            [
                     'attribute' => 'report_id',
                        'label'=>"Report Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            
                             return $model->report->name;   
                            
                        },
                    ],
            //'report_id',
                                [
                     'attribute' => 'user_role',
                        'label'=>"Role",
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->user_role !=''){
                             return $model->user_role;   
                            }else{
                             return '';   
                            } 
                        },
                    ],
                                [
                     'attribute' => 'user_id',
                        'label'=>"Specific User",
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->user->firstname !=''){
                             return $model->user->firstname." ".$model->user->middlename." ".$model->user->surname;   
                            }else{
                             return '';   
                            } 
                        },
                    ],
            //'created_by',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
  </div>
</div>
