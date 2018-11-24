<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
//use frontend\modules\repayment\models\LoanRepayment;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Bill';

$totalEmployees=frontend\modules\repayment\models\LoanRepaymentDetail::getTotalBeneficiariesTreasuryBill($model->treasury_payment_id);
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,'totalEmployees'=>$totalEmployees,
                ])            
                    ?>
					<br/>
					   <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/view-loanee-paymenttreasury','id'=>$model->treasury_payment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
        [
            'label' => 'Employers Bills',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/employers-bills-treasury','id'=>$model->treasury_payment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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
