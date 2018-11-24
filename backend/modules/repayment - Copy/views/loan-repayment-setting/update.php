<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentSetting */

$this->title = 'Update Loan Repayment Setting: ' . $model->loanRepaymentItem->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loanRepaymentItem->item_name, 'url' => ['view', 'id' => $model->loan_repayment_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-repayment-setting-update">
  <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
