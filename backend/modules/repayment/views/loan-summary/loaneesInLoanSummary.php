<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loanees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                           <?php 
                            
                            if($totalUnverifiedEmployees > 0){ ?>
                            <p>
        <?= Html::a('Submit Beneficiaries', ['verify-beneficiaries-in-bulk'], ['class' => 'btn btn-success']) ?>
                
    </p>
                            <?php } ?>
            

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
                  return $this->render('viewLoanDetailsInLoanSummary',['model'=>$model]);  
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
                            return $model->f4indexno;
                        },
            ],			
            [
                'attribute' => 'totalLoan',
				'label'=>'Total Loan',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
                //return backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($model->applicant_id);
				return \frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($model->applicant_id);
        },
            ],                    
        ],
    ]); ?>
</div>
       </div>
</div>
