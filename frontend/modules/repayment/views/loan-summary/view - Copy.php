<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */

$this->title = "Loan No: " . $model->bill_number;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-summary-view">

    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'employer_id',
                        'label' => 'Employer Name',
                        'value' => call_user_func(function ($data) {
                                    if ($data->employer_id == '') {
                                        return $data->applicant->user->firstname;
                                    } else {
                                        return $data->employer->employer_name;
                                    }
                                }, $model),
                    ],
                    [
                        'attribute' => 'amount',
                        'label' => 'Total Loan Amount',
                        'value' => $model->amount,
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'paid',
                        'label' => 'Paid',
                        'value' => call_user_func(function ($data) {
                                    return $data->getTotalPaidunderBill($data->loan_summary_id);
                                }, $model),
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'VRF',
                        'label' => 'VRF Accrued Daily',
                        'value' => call_user_func(function ($data) {
                                    if ($data->vrf_accumulated == '') {
                                        return '';
                                    } else {
                                        return $data->vrf_accumulated;
                                    }
                                }, $model),
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'outstanding',
                        'label' => 'Outstanding(TZS)',
                        'value' => call_user_func(function ($data) {
                                    return ($data->amount + $data->vrf_accumulated) - $data->getTotalPaidunderBill($data->loan_summary_id);
                                }, $model),
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'bill_status',
                        'label' => 'Loan Status',
                        'value' => call_user_func(function ($data) {
                                    if ($data->bill_status == 0) {
                                        return 'Posted';
                                    } else if ($data->bill_status == 1) {
                                        return "On Payment";
                                    } else if ($data->bill_status == 2) {
                                        return "Paid";
                                    } else if ($data->bill_status == 3) {
                                        return "Cancelled";
                                    } else if ($data->bill_status == 4) {
                                        return "Ceased";
                                    } else if ($data->bill_status == 5) {
                                        return "Ceased";
                                    }
                                }, $model),
                    ],
                    [
                        'attribute' => 'created_at',
                        //'label'=>'VRF Accrued Daily',
                        'value' => call_user_func(function ($data) {
                                    if ($data->created_at == '') {
                                        return '';
                                    } else {
                                        return date("d-m-Y", strtotime($data->created_at));
                                    }
                                }, $model),
                    ],
                    [
                        'attribute' => 'vrf_last_date_calculated',
                        //'label'=>'VRF Accrued Daily',
                        'value' => call_user_func(function ($data) {
                                    if ($data->vrf_last_date_calculated == '') {
                                        return '';
                                    } else {
                                        return date("d-m-Y", strtotime($data->vrf_last_date_calculated));
                                    }
                                }, $model),
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Note',
                        'value' => $model->description,
                    ],
                ],
            ])
            ?>


            <h3>Loanees in this bill.</h3>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'applicant_id',
                        'label' => 'Indexno',
                        'value' => function($model) {
                            return $model->applicant->f4indexno;
                        }
                    ],
                    [
                        'attribute' => 'fullname',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->applicant->user->firstname . ", " . $model->applicant->user->middlename . " " . $model->applicant->user->surname;
                        }
                    ],
                    [
                        'attribute' => 'principal',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->getIndividualEmployeesPrincipalLoan($model->applicant_id, $model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'penalty',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->getIndividualEmployeesPenalty($model->applicant_id, $model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'LAF',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->getIndividualEmployeesLAF($model->applicant_id, $model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'vrf',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->getIndividualEmployeesVRF($model->applicant_id, $model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'totalLoan',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->getIndividualEmployeesTotalLoan($model->applicant_id, $model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'outstandingDebt',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->getIndividualEmployeesOutstandingDebt($model->applicant_id, $model->loan_summary_id);
                        },
                        'format' => ['decimal', 2],
                    ],
                //['class' => 'yii\grid\ActionColumn'],
                ],
                'responsive' => true,
                'hover' => true,
                'condensed' => true,
                'floatHeader' => false,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Loanees in this bill') . ' </h3>',
                    'type' => 'info',
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                    'showFooter' => true
                ],
            ]);
            ?>
        </div>
    </div>
</div>
