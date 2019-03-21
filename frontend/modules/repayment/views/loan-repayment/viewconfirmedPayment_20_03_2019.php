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
            $control_number=$results1->control_number;
            $totalAmount=number_format($results1->amount,2);
			$totalEmployees=$model->getAllEmployeesUnderBillunderEmployer($model->loan_repayment_id);
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            <?php if($employerSalarySource==0){ ?>
            <?= $this->render('_formPaymentConfirmed', [
                'model' => $model,'totalEmployees'=>$totalEmployees,
                ])            
                    ?>
                            <?php } ?>
<br/>
					   <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/viewloaneebill-confirmedpayment','id'=>$model->loan_repayment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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
