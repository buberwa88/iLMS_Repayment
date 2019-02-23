<p>

    <?php
    if (frontend\modules\repayment\models\RefundApplication::pendindApplicationForPaylistExist()) {
        echo yii\bootstrap\Html::a('Create/Add Refund Paylist', ['create'], ['class' => 'btn btn-success']);
    }
    ?>

</p>

<h2 class="header" style="font-size: 20px;font-weight: bold;margin-top: 0px;"> Paid Refunds </h2>
<?=
\kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $paylistModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'application_number',
            'label' => 'Application #',
            'value' => function($model) {
                return $model->application_number;
            },
        ],
        [
            'attribute' => 'claimant_name',
            'label' => 'Claimant',
            'value' => function($model) {
                return strtoupper($model->refundClaimant->firstname . ' ' . $model->refundClaimant->middlename . ' ' . $model->refundClaimant->surname);
            },
        ],
        [
            'attribute' => 'check_number',
            'label' => 'Employee ID',
            'value' => function($model) {
                return strtoupper($model->check_number);
            },
        ],
        [
            'attribute' => 'check_number',
            'label' => 'Employer',
            'value' => function($model) {
                return strtoupper($model->check_number);
            },
        ],
//        [
//            'attribute' => 'date_updated',
//            'label' => 'Paid Date',
//            'value' => function($model) {
//                return Date('D, d-M-Y', strtotime($model->paylist->date_updated));
//            },
//        ],
        [
            'attribute' => 'refund_claimant_amount',
            'label' => 'Pay Amount',
            'value' => function($model) {
                return number_format($model->refund_claimant_amount);
            },
        ],
        [
            'attribute' => 'trustee_phone_number',
            'label' => 'Trustee #',
            'value' => function($model) {
                return strtoupper($model->trustee_firstname . ' ' . $model->trustee_midlename . ' ' . $model->trustee_surname);
            },
        ],
        [
            'attribute' => 'payment_bank_account_number',
            'label' => 'Payment Bank',
            'value' => function($model) {
                return $model->bank_name . ' - ' . $model->bank_account_number . '';
            }
        ],
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getCurrentStutusName();
            },
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
        // 'visible' => ($model->status == \backend\modules\repayment\models\RefundPaylist::STATUS_CREATED) ? TRUE : FALSE
        ],
    ],
]);
?>