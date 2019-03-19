<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = "Loan Payments";
$this->params['breadcrumbs'][] = ['label' => 'Loan Payments', 'url' => ['bills-payments']];
$this->params['breadcrumbs'][] = $this->title;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$resultsBatch=$modelBatch->getLoanRepayment($loan_repayment_id);
if($resultsBatch->payment_status==0){
 $status="Pending";   
}else{
 $status="Complete";  
}
?>
<div class="loan-repayment-view">

<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<?= $this->render('_formBatch', [
                'model' => $model,'amount'=>$resultsBatch->amount,'paymentRefNo'=>$resultsBatch->control_number,'payment_status'=>$status,'bill_number'=>$resultsBatch->bill_number
                ])            
                    ?>
            <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/view-loanee-under-payment','id'=>$loan_repayment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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
