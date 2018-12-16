<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
$this->title = 'Beneficiaries under my scholarships';
//$this->params['breadcrumbs'][] = ['label' => 'Loan Summary', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\frontend\modules\repayment\models\LoanRepaymentDetail::checkFullPaidBeneficiaries($loan_given_to);
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php								
							
echo TabsX::widget([
    'items' => [  
         [
            'label' => 'Not Paid',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-summary/index-scholarshipnotpaid']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],	
        [
            'label' => 'Paid',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-summary/index-scholarshippaid']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '3',
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