<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Bill';
$this->params['breadcrumbs'][] = $this->title;

            $results1=$model->getLoanRepayment($loan_repayment_id);
            $results=$results1->bill_number;
            $control_number=$results1->control_number;
            $payment_status=$results1->payment_status;
            $ActiveBill=$modelBill->getActiveBill($results1->employer_id);
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
            $employerID=$employerID;
            
            
            
            if($results !=0 && $billID !=0 && $payment_status ==''){
            ?>
            <?= $this->render('_formPaymentConfirmed', [
                'model' => $model,'amount'=>$totalAmount,'paymentRefNo'=>$control_number,'totalEmployees'=>$totalEmployees,'loan_repayment_id'=>$loan_repayment_id,
                ])            
                    ?>
            <?php } ?>                 
                            
    <?php // echo $this->render('_search', ['model' => $searchModel]); 

    echo "<br/>";
    if($results !=0 && $billID !=0 && $payment_status ==''){
    ?>
    <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/viewloaneebill-confirmedpayment','id'=>$loan_repayment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
    <?php } ?>
</div>
       </div>
</div>
