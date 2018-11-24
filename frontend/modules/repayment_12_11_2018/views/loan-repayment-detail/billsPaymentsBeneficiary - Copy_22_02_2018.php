<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\repayment\models\LoanRepayment;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Payments';
$this->params['breadcrumbs'][] = $this->title;
$model = new LoanRepayment();
/*
$controlNumber='12';
$amount='100000';
$model->updatePaymentAfterGePGconfirmPaymentDone($controlNumber,$amount);
 * 
 */
 
 
          
            $results1=$batchDetailModel->getAmountTotalPaidLoanee($applicantID);
            $totalLoan=$BillDetailModel->getTotalLoanBeneficiaryOriginal($applicantID);
            
 $total_loan=$totalLoan;
 //$total_loan='2000000';
 $amount_paid=$results1;
 $balance=$total_loan-$amount_paid;
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= $this->render('_formBeneficiaryPayments', [
                'model' => $model,'total_loan'=>$total_loan,'amount_paid'=>$amount_paid,'balance'=>$balance,
                ])            
                    ?>

    
    <h3>Payments.</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'loan_repayment_id',
            'employer.employer_name',
            //'applicant_id',
            //'repayment_reference_number',
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
                'attribute'=>'amountApplicant',
                'format'=>'raw',
                'value'=>function($model)
            {
            if($model->loan_repayment_id !=''){
             return $model->getTotalAmountPaidLoaneeUnderTransaction($model->loan_repayment_id);
            }                 
            },
                    'format'=>['decimal',2],
            ],
            [
                'attribute'=>'date_control_received',
                'label'=>'Pay Date',
                'format'=>'raw',
                'value'=>$model->date_control_received,
                'filter'=>'',
            ],
            [
            'attribute'=>'payment_status',
            'header'=>'Status',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->payment_status == '1')
                {
                    return '<p class="btn green"; style="color:green;">Complete</p>';
                    
                }
                else
                {   
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

            
                    
        ],
    ]); ?>
</div>
       </div>
</div>
