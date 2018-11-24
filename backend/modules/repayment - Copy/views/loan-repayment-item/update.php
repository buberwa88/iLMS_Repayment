<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentItem */

$this->title = 'Update Loan Repayment Item: ' . $model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['view', 'id' => $model->loan_repayment_item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-update">

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
