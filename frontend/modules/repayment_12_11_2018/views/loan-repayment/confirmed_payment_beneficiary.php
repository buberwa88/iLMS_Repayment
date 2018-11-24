<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Bill';
$this->params['breadcrumbs'][] = $this->title;

            $results1=$model->getLoanRepayment($loan_repayment_id);
            $results=$results1->repayment_reference_number;
            $control_number=$results1->control_number;
            $payment_status=$results1->payment_status;
            $ActiveBill=$modelBill->getActiveBillLoanee($results1->applicant_id);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            $totalAmount=number_format($results1->amount,2);
            $loan_repayment_id=$results1->loan_repayment_id;
            $totalEmployees=$model->getAllEmployeesUnderBillunderEmployer($loan_repayment_id);
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?php
                      if($results !=0 && $billID !=0 && $payment_status =='0' && $control_number ==''){
                      echo "Waiting for Payment Reference number!";    
                      }
                      ?>
                        </div>
                        <div class="panel-body">
            <?php
            $employerID=$employerID;
            
            echo "tele";
            
            if(strcmp($results,'0') !=0 && $billID !=0 && $payment_status =='0'){
            ?>
            <?= $this->render('_formPaymentConfirmedLoanee', [
                'model' => $model,'amount'=>$totalAmount,'paymentRefNo'=>$control_number,'totalEmployees'=>$totalEmployees,'loan_repayment_id'=>$loan_repayment_id,
                ])            
                    ?>
            <?php } ?>                 
                            
    <?php // echo $this->render('_search', ['model' => $searchModel]); 

    echo "<br/>";
    if(strcmp($results,'0') !=0 && $billID !=0 && $payment_status ==''){
    ?>
    <h3>Loanees in this Payment.</h3>
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute'=>'applicantName',
            'filter'=>'',    
            'value' =>function($model)
            {
                return $model->applicant->user->firstname.", ".$model->applicant->user->middlename." ".$model->applicant->user->surname;
            }
        ],
            [
            'attribute'=>'applicant_id',
            'label'=>'Indexno',    
            'value' =>function($model)
            {
                return $model->applicant->f4indexno;
            }
        ],
//            [
//            'attribute'=>'amount',
//            'format'=>'raw',    
//            'value' =>function($model)
//            {
//                return $model->amount;
//            },
//            'format'=>['decimal',2],
//        ],
                
                [
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->getAmountRequiredForPaymentIndividualLoanee($model->applicant_id,$model->loan_repayment_id);
            },
            'format'=>['decimal',2],
        ],
            
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php } ?>
</div>
       </div>
</div>
