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

$this->title = 'My Loan';
$this->params['breadcrumbs'][] = $this->title;
         
            //$results1=$batchDetailModel->getAmountTotalPaidLoanee($applicantID);
            //$totalLoan=$BillDetailModel->getTotalLoanBeneficiaryOriginal($applicantID);
			$totalLoan=\backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($applicantID);
            
$total_loan=$totalLoan;
$principal=\backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($applicantID);
$penalty=\backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicantID);
$LAF=\backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicantID);
$vrf=\backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicantID);
$model = new LoanRepayment();
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
            <?= $this->render('_formBeneficiaryLoan', [
                'model' => $model,'total_loan'=>$total_loan,'principal'=>$principal,'penalty'=>$penalty,'LAF'=>$LAF,'vrf'=>$vrf
                ])            
                    ?>	
</div>
       </div>
</div>
