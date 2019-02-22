<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundPaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Paylists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-index">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create/Add Refund Paylist', ['create'], ['class' => 'btn btn-success']) ?>

            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'paylist_number',
                    'paylist_name',
//                    [
//                        'attribute' => 'date_created',
//                        'value' => function($model) {
//                            return Date('D, d-M-Y', strtotime($model->date_created));
//                        },
//                    ],
                    'paylist_description:html',
                    [
                        'attribute' => 'paylist_total_amount',
                        'value' => function($model) {
                            return number_format(backend\modules\repayment\models\RefundPaylistDetails::getPayListTotalAmountById($model->refund_paylist_id));
                        }],
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            return $model->getStatusName();
                        },
                    ],
                    // 'created_by',
                    // 'date_updated',
                    // 'updated_by',
                    // 'status',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    // 'visible' => ($model->status == \backend\modules\repayment\models\RefundPaylist::STATUS_CREATED) ? TRUE : FALSE
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>