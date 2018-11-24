<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Application Fee Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-receipt-index">
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
            // 'id',
            'bill_number',
            //'response_message:ntext',
            // 'retrieved',
            // 'trans_id',
            // 'payer_ref_id',
            'control_number',
            // 'bill_amount',
            [

                'attribute' => 'bill_amount',
                //'label'=>'Expected Amount',
                //'hAlign' => 'right',
                'value' => function($model) {
                    return $model->bill_amount;
                    // return $model->is_paid == 1 ? $model->amount_paid : $model->total_amount;
                },
                'format' => 'raw',
                'format' => ['decimal', 2],
            ],
            // 'paid_amount',
            [

                'attribute' => 'paid_amount',
                //'label'=>'Expected Amount',
                //'hAlign' => 'right',
                'value' => function($model) {
                    return $model->paid_amount;
                    // return $model->is_paid == 1 ? $model->amount_paid : $model->total_amount;
                },
                'format' => 'raw',
                'format' => ['decimal', 2],
            ],
            //'currency',
            // 'trans_date',
            // 'payer_phone',
            // 'payer_name',
            'receipt_number',
            // 'account_number',
            // 'reconciliation_status',
            //'recon_amount',
            [

                'attribute' => 'recon_amount',
                //'label'=>'Expected Amount',
                //'hAlign' => 'right',
                'value' => function($model) {
                    return $model->recon_amount;
                    // return $model->is_paid == 1 ? $model->amount_paid : $model->total_amount;
                },
                'format' => 'raw',
                'format' => ['decimal', 2],
            ],
            //'amount_diff',
            [

                'attribute' => 'amount_diff',
                //'label'=>'Expected Amount',
                //'hAlign' => 'right',
                'value' => function($model) {
                    return $model->amount_diff;
                    // return $model->is_paid == 1 ? $model->amount_paid : $model->total_amount;
                },
                'format' => 'raw',
                'format' => ['decimal', 2],
            ],
            // 'recon_master_id',
            //'reconciliation_status',
            [
                'attribute' => 'reconciliation_status',
                'label' => 'Status',
//                'vAlign' => 'middle',
//                'width' => ' ',
                'value' => function($model) {
                    if (($model->reconciliation_status == 0)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-info"> Reconciled ';
                    }


                    if (($model->reconciliation_status == 1)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-danger"> Not Reconciled ';
                    }

                    if (($model->reconciliation_status == 2)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-info"> Reconciled with Difference ';
                    }
                },
                'format' => 'raw',
                'filter' => [0 => 'Reconciled', 1 => 'Not Reconciled', 2 => 'Reconciled with Difference']
            ],
        // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    </div>
       </div>
</div>
