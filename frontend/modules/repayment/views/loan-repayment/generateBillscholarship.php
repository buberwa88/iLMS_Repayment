<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = 'Bill';
$this->params['breadcrumbs'][] = ['label' => 'Loan Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$results=frontend\modules\repayment\models\LoanSummary::checkForActiveEmployees($model->employer_id,$loan_given_to);
?>
<div class="loan-repayment-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
      <?php if($results==1){ ?>
    <?= $this->render('_formGeneratebill', [
        'model' => $model,
    ]) ?>
	<?php 
	}else{
	?>
	 <p class='alert alert-info'>
	Dear employer, ensure there is loan summary for payment!				
	</p>
	<?php 
	}
	?>
	<br/><br/>
	<h3>Bills List</h3>
	<br/>
<?= GridView::widget([
        'dataProvider' => $dataProviderBills,
        'filterModel' => $searchLoanRepayment,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute'=>'bill_number',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->bill_number;                    
            },
            ],
            [
                'attribute'=>'control_number',
                'format'=>'raw',
                'value'=>function($model)
            {
            if($model->control_number==''){
             return '<p class="btn green"; style="color:red;">Waiting!</p>';
            }else{
             return $model->control_number;    
            }                 
            },
            ],
			[
                'attribute'=>'payment_date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
            },
            ],
			[
                'attribute'=>'date_bill_generated',
				'label'=>'Payment Date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->date_bill_generated;                    
            },
            ],
			[
            'attribute'=>'payment_status',
			'label'=>'Status',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 if($model->payment_status==0){
				 $status='<p class="btn green"; style="color:red;">Pending</p>';   
				}else{
				 $status='<p class="btn green"; style="color:green;">Complete</p>'; 
				}
				return $status;
            },             
            ],
            [
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],             
                    ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',
			 'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                    ]);
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=repayment/loan-repayment-detail/view&id=' . $model->loan_repayment_id;
                    return $url;
                }
            }
			],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
    </div>
</div>
