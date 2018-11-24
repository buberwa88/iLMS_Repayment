<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = 'Adjust Payment Amount';
$this->params['breadcrumbs'][] = ['label' => 'Pay Bill', 'url' => ['loan-repayment/index-beneficiary']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formLoaneeAdjustPayment', [
        'model' => $model,'loan_repayment_id'=>$loan_repayment_id,'amount'=>$amount,'applicantID'=>$applicantID,
    ]) ?>

</div>
    </div>
</div>
