<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */

$this->title = 'Create Loan Repayment Batch Detail';
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Batch Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
