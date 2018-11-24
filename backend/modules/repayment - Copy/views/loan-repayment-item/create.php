<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentItem */

$this->title = 'Create Loan Repayment Item';
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-item-create">
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
