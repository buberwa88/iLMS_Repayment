<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\repayment\models\LoanSummary;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Summary';
$this->params['breadcrumbs'][] = ['label' => 'List of Notifications', 'url' => ['/repayment/default/notification']];
$this->params['breadcrumbs'][] = $this->title;



//echo $employer_id;
$LoanSummaryModel=new LoanSummary();
$billFoundResults=$LoanSummaryModel->getBillRequestedPending($applicantID);
?>
<div class="loan-summary-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                            <?php if($billFoundResults !=0){ ?>
    <p>
        Loan summary requests pending!
        
    </p>
                            <?php } 
							$loanSummarystatus=0;
							?>
                        </div>
                        <div class="panel-body">
                            <?php if($billFoundResults==0){ ?>
    <p>
        <?= Html::a('Request Loan Summary', ['create-bill-request-applicant'], ['class' => 'btn btn-success']) ?>
		<?php if($loanSummarystatus==1){ ?>
		<?= Html::a('Request Loan Summary', ['create-bill-request-applicant', 'id' => $model->loan_summary_detail_id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to exit from the loan summary?',
                'method' => 'post',
            ],
        ]) 		
		?>
        <?php } ?>
    </p>
                            <?php } ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'reference_number',
            //'amount',
            [
                'attribute'=>'amount',
                'value'=>$model->amount,
                'format'=>['decimal',2],
            ],
            [
                'attribute'=>'paid',
                'value'=>function($model)
            {
                 return $model->getTotalPaidunderBill($model->loan_summary_id);
            },
            'format'=>['decimal',2],
            ],
            
            [
                'attribute'=>'outstanding',               
                'value'=>function($model)
            {
             return   ($model->amount + $model->vrf_accumulated)-$model->getTotalPaidunderBill($model->loan_summary_id);
            },
            'format'=>['decimal',2],
            ],
            [
                'attribute'=>'status',
                'label'=>'Status',
                'value'=>function ($model) {
                    if($model->status==0){
                return 'Posted';
                    }else if($model->status==1){
                return "On Payment";        
                    }else if($model->status==2){
                return "Paid";        
                    }else if($model->status==3){
                return "Cancelled";        
                    }else if($model->status==4){
                return "Ceased";        
                    }else if($model->status == '5')
                {   
                   return "Ceased";
                }
            },
            ],
                    /*
                    ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',
                         'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('View', $url, ['class' => 'btn btn-success',
                            'title' => Yii::t('app', 'view'),
                ]);
            },
          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-summary/view&id='.$model->loan_summary_id;
                return $url;
            }
          }
			],
                     * 
                     */
        ],
    ]); ?>
</div>
       </div>
</div>
