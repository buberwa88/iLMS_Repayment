<h2 class="header" style="font-size: 20px;font-weight: bold;margin-top: 0px;"> Paid Refunds </h2>
<?=
\kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $paylistModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'paylist_number',
            'label' => 'Pay list #',
            'value' => function($model) {
                return $model->paylist->paylist_number;
            },
        ],
        [
            'attribute' => 'refund_application_reference_number',
            'label' => 'Application #',
            'value' => function($model) {
                return strtoupper($model->refund_application_reference_number);
            },
            'vAlign' => 'middle',
        ],
        [
            'attribute' => 'claimant_name',
            'label' => 'Claimant',
            'value' => function($model) {
                return strtoupper($model->claimant_name);
            },
            'vAlign' => 'left',
        ],
        [
            'attribute' => 'refund_claimant_amount',
            'label' => 'Amount',
            'vAlign' => 'right',
            'value' => function($model) {
                return number_format($model->refund_claimant_amount);
            },
        ], [
            'attribute' => 'date_updated',
            'label' => 'Paid Date',
            'vAlign' => 'right',
            'value' => function($model) {
                return ($model->paylist->date_updated) ? Date('d-M-Y', strtotime($model->paylist->date_updated)) : ' - ';
            },
        ],
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getStatusName();
            },
        ],
        [
            'attribute' => 'payment_bank_account_number',
            'label' => 'Bank Account',
            'value' => function($model) {
                return $model->payment_bank_account_number;
            }
        ],
        [
            'attribute' => 'payment_bank_name',
            'label' => 'Bank Name',
            'value' => function($model) {
                return $model->payment_bank_name . ' ' . (($model->payment_bank_branch) ? $model->payment_bank_branch : '');
            }
        ],
//        ['class' => 'yii\grid\ActionColumn',
////            'template' => '{view}',
//        // 'visible' => ($model->status == \backend\modules\repayment\models\RefundPaylist::STATUS_CREATED) ? TRUE : FALSE
//        ],
    ],
]);
?>