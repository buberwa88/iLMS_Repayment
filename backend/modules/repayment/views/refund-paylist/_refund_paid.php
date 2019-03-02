<h2 class="header" style="font-size: 20px;font-weight: bold;margin-top: 0px;"> Refund Pay Lists </h2>

<?=
\kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $paylistModel,
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