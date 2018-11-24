<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = 'Create Bill(s) in Bulk';
$this->params['breadcrumbs'][] = ['label' => 'Loan Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formBillsBulk', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
