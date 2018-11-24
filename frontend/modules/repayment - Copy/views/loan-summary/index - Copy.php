<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loans Summaries';
$this->params['breadcrumbs'][] = ['label' => 'List of Notifications', 'url' => ['/repayment/default/notification']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-summary-index">
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
                    //'bill_number',
                    //'amount',
                    [
                        'attribute' => 'bill_number',
                        'label' => 'Loan No.',
                        'value' => function($model) {
                            return $model->bill_number;
                        },
                    ],
                    [
                        'attribute' => 'amount',
                        'value' => function($model) {
                            return $model->amount;
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'paid',
                        'value' => function($model) {
                            return $model->getTotalPaidunderBill($model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'VRF',
                        'label' => 'VRF Accrued Daily',
                        'value' => function($model) {
                            if ($model->vrf_accumulated == '') {
                                return '';
                            } else {
                                return $model->vrf_accumulated;
                            }
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'outstanding',
                        'value' => function($model) {
                            return ($model->amount + $model->vrf_accumulated) - $model->getTotalPaidunderBill($model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'bill_status',
                        'label' => 'Loan Status',
                        'value' => function ($model) {
                            if ($model->bill_status == 0) {
                                return 'Posted';
                            } else if ($model->bill_status == 1) {
                                return "On Payment";
                            } else if ($model->bill_status == 2) {
                                return "Paid";
                            } else if ($model->bill_status == 3) {
                                return "Cancelled";
                            } else if ($model->bill_status == 4) {
                                return "Ceased";
                            } else if ($model->bill_status == '5') {
                                return "Ceased";
                            }
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Action',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('View', $url, ['class' => 'btn btn-success',
                                            'title' => Yii::t('app', 'view'),
                                ]);
                            },
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = 'index.php?r=repayment/loan-summary/view&id=' . $model->loan_summary_id;
                                return $url;
                            }
                        }
                            ],
                        ],
                        'responsive' => true,
                        'hover' => true,
                        'condensed' => true,
                        'floatHeader' => false,
                        'panel' => [
                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
                            'type' => 'info',
                            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                            'showFooter' => true
                        ],
                    ]);
                    ?>
        </div>
    </div>
</div>
