<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = "Loan Payments";
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Batches', 'url' => ['bills-payments']];
$this->params['breadcrumbs'][] = $this->title;

$resultsBatch = $modelBatch->getLoanRepayment($loan_repayment_id);
if ($resultsBatch->payment_status == 0) {
    $status = "Pending";
} else {
    $status = "Complete";
}
?>
<div class="loan-repayment-view">

    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_formBatch', [
                'model' => $model, 'amount' => $resultsBatch->amount, 'paymentRefNo' => $resultsBatch->control_number, 'payment_status' => $status,
            ])
            ?>
            <h3>Loanees in this payment.</h3>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'firstname',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'firstname', 'firstname'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'middlename',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'middlename', 'middlename'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'surname',
                        'label' => 'Last Name',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'surname', 'surname'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'amount',
                        'format' => 'raw',
                        'value' => $model->amount,
                        'format' => ['decimal', 2],
                    ],
                // 'loan_summary_id',
                //['class' => 'yii\grid\ActionColumn'],
                ],
                'responsive' => true,
                'hover' => true,
                'condensed' => true,
                'floatHeader' => false,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Loan Repayment Batches') . ' </h3>',
                    'type' => 'info',
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                    'showFooter' => true
                ],
            ]);
            ?> 
        </div>
    </div>
</div>
