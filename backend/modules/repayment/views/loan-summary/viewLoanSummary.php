<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use backend\modules\repayment\models\LoanSummary;


$this->title = 'Loan summary details';
$this->params['breadcrumbs'][] = ['label' => 'Employers waiting Loan summary', 'url' => ['/repayment/employed-beneficiary/employer-waiting-loan-summary']];
$this->params['breadcrumbs'][] = $this->title;


//echo $employer_id;
$LoanSummaryModel=new LoanSummary();
$resultsEmployer=$LoanSummaryModel->getEmployerDetails($employer_id);
//$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".date("m")."-".date("d").date("H").date("i").date("s");
$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".$LoanSummaryModel->getLastBillID($employer_id);
$tracedBy=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;

$totalEmployees=$searchModel->getAllEmployeesUnderBillunderEmployer($employer_id);
$totalAcculatedLoan=number_format($searchModel->getTotalLoanInBill($employer_id),2);
//$this->title = 'Verify and Approve Bill';
$billNote="Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
?>

<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                         <?= Html::encode($this->title) ?>   
                        </div>
    
                        <div class="panel-body">
                            <?= $this->render('_form', [
                                'model' => $model,'employer_name'=>$resultsEmployer->employer_name,'employer_code'=>$resultsEmployer->employer_code,
                                'billNumber'=>$billNumber,'tracedBy'=>$tracedBy,'number_employees'=>$resultsEmployer->employer_code,'employer_id'=>$employer_id,
                                'totalEmployees'=>$totalEmployees,'totalLoanInBill'=>$totalAcculatedLoan,'billNote'=>$billNote,
                                ]) ?>
                            
                            <br/>
	<?php							
							
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Loanees.',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-summary/loanees-in-loan-summary','employerID'=>$employer_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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

