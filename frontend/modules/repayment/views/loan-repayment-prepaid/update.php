<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentPrepaid */

$this->title = 'Update Loan Repayment Prepaid: ' . $model->prepaid_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Prepaids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->prepaid_id, 'url' => ['view', 'id' => $model->prepaid_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-repayment-prepaid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
