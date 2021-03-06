<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgBillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-bill-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'payer',
            'bill_number',
			'control_number',
            'bill_amount',
            [
                'attribute' => 'status',
                //'label' => 'Status',
//                'vAlign' => 'middle',
//                'width' => ' ',
                'value' => function($model) {
                    if (($model->status == 0 || $model->status == '' || $model->status == 3)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-info"> OK';
                    }


                    if (($model->status == 1)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-danger"> Cancelled Waiting';
                    }
					if (($model->status == 2)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-danger"> Cancelled Failed';
                    }
					if (($model->status == 4)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-danger"> Cancelled';
                    }
                },
                'format' => 'raw',
                'filter' => [0 => 'OK', 4 => 'Cancelled', 1 => 'Cancelled Waiting', 2 => 'Cancelled Failed']
            ],
            // 'response_message',
            // 'date_created',
            // 'cancelled_reason',
            // 'cancelled_by',
            // 'cancelled_date',
            // 'cancelled_response_status',
            // 'cancelled_response_code',
            [
                'label' => ' ',
               'value' => function ($model) {
                if (($model->status == 0 || $model->status == '')) {
                        return Html::a('<span class="label label-danger">Cancel</span>', Yii::$app->urlManager->createUrl(['/application/gepg-bill/update', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Cancel'),
                                    'data' => ['confirm' => 'Are you sure you want to cancel this Bill?'],
                        ]);
                    } else {
                        return ' ';
                    }
                },
                        'format' => 'raw',
                    ],
                //['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
    </div>
       </div>
</div>
