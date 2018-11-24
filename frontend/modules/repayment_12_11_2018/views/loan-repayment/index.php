<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bill';
$this->params['breadcrumbs'][] = $this->title;

            $resultsAfterCheck=$model->checkWaitingConfirmationFromGePG($employerID);            
            $results1=$model->checkControlNumberStatus($employerID);
            $results=$results1->bill_number;
            $control_number=$results1->control_number;
            $payment_status=$results1->payment_status;
            $ActiveBill=$modelBill->getActiveBill($employerID);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            $totalAmount=number_format($results1->amount,2);
            $loan_repayment_id=$results1->loan_repayment_id;
            $totalEmployees=$model->getAllEmployeesUnderBillunderEmployer($loan_repayment_id);
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                      <?php
                      if($results !=0 && $billID !=0 && $payment_status =='0' && $control_number ==''){
                      echo "Waiting for Payment Reference number!";    
                      }
                      ?>
                        </div>
                        <div class="panel-body">
            <?php
            if($resultsAfterCheck->payment_status !='0'){

            if($results !=0 && $billID !=0 && $payment_status ==''){
            ?>
            <?= $this->render('_form', [
                'model' => $model,'amount'=>$totalAmount,'paymentRefNo'=>$control_number,'totalEmployees'=>$totalEmployees,'loan_repayment_id'=>$loan_repayment_id,'bill_number'=>$results,
                ])            
                    ?>
            <?php } ?>                 
                            
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    if($results ==0 && $billID !=0){
    ?>

    <p>
        <?= Html::a('Generate Bill', ['generate-bill'], ['class' => 'btn btn-success']) ?>
        
    </p>
    <?php }
    echo "<br/>";
    if($results !=0 && $billID !=0 && $payment_status ==''){
	//loanees under bill
    ?>
   <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/view-loaneeinbill-payment','id'=>$loan_repayment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?> 
    <?php 
	//end loanees under bill
	} 
//View bills
if($results ==0 && $billID !=0){
?>
<?= GridView::widget([
        'dataProvider' => $dataProviderBills,
        'filterModel' => $searchModelBills,
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
	<?php
}
//end view bills

	
            }
    ?>
</div>
       </div>
</div>
