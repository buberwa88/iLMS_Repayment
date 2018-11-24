<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\modules\repayment\models\LoanRepayment;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Payments';
$this->params['breadcrumbs'][] = $this->title;
$model = new LoanRepayment();

$controlNumber = '61';
$amount = '4734000.00';
$model->updatePaymentAfterGePGconfirmPaymentDone($controlNumber, $amount);
?>
<div class="loan-repayment-index">

    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'loan_repayment_id',
        //'employer_id',
        //'applicant_id',
        //'repayment_reference_number',
        [
            'attribute' => 'control_number',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->control_number == '') {
                    return '<p class="btn green"; style="color:red;">Waiting!</p>';
                } else {
                    return $model->control_number;
                }
            },
        ],
        [
            'attribute' => 'amount',
            'format' => 'raw',
            'value' => $model->amount,
            'format' => ['decimal', 2],
        ],
        [
            'attribute' => 'payment_status',
            'header' => 'Status',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->payment_status == '1') {
                    return '<p class="btn green"; style="color:green;">Complete</p>';
                } else {
                    return '<p class="btn green"; style="color:red;">Pending</p>';
                }
            },
        ],
        //'amount',
        // 'receipt_number',
        // 'pay_method_id',
        // 'pay_phone_number',
        // 'date_bill_generated',
        // 'date_control_received',
        // 'date_receipt_received',
        ['class' => 'yii\grid\ActionColumn',
            'header' => 'Action',
            'template'=>'{view}',
                ],
            ],
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'floatHeader' => false,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Verified Beneficiaries') . ' </h3>',
                'type' => 'info',
                'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                'showFooter' => true
            ],
        ]);
        ?>
        </div>
    </div>
</div>
