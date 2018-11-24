<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerPenaltySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monthly Penalties';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="employer-penalty-index">

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

            //'employer_penalty_id',
            //'employer_id',
            //'amount',
			'penalty_date',
			[
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            
            //'created_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>		
</div>
       </div>
</div>
