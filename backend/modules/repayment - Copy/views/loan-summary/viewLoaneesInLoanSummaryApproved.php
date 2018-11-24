<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
//use backend\modules\repayment\models\LoanSummaryDetailSearch;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
$this->title = "Beneficiaries";
?>
<div class="loan-summary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('viewLoanDetailsInLoanSummaryApproved',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
                [
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			/*
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			*/
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			[
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
            ],
			[
                'attribute' => 'totalLoan',
				'label'=>"Total Amount",
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
                //return \backend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeeTotalLoan($model->applicant_id);
				return $model->getIndividualEmployeesTotalLoan($model->applicant_id,$model->loan_summary_id);
        },
            ],
			[
            'attribute'=>'outstandingDebt',
            'hAlign' => 'right',
            'format' => ['decimal', 2],    
            'value' =>function($model)
            {
                //return $model->getIndividualEmployeesOutstandingDebt($model->applicant_id,$model->loan_summary_id);
				return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id);
            },
            //'format'=>['decimal',2],
        ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    </div>
</div>
