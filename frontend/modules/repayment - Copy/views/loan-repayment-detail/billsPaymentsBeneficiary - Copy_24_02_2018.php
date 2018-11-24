<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
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
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= $this->render('_formBeneficiaryPayments', [
                'model' => $model,'total_loan'=>$total_loan,'amount_paid'=>$amount_paid,'balance'=>$balance,
                ])            
                    ?>
            <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Payments',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/bills-payments-benefiaciary-view']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
</div>
       </div>
</div>
