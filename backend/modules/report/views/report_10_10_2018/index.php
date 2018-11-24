<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Configure Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                     'attribute' => 'category',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->category=='1'){
                             return 'Application';   
                            }else if($model->category=='2'){
                             return 'Allocation';   
                            }else if($model->category=='3'){
                             return 'Disbursement';    
                            }else if($model->category=='4'){
                             return 'Repayment';   
                            }else if($model->category=='5'){
                             return 'Apeal';   
                            }else if($model->category=='6'){
                             return 'Complain';   
                            }
                             
                            
                        },
                    ],
            'package',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>
</div>
  </div>
</div>
