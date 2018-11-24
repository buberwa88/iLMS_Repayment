<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */

$this->title = 'Update Employer Penalty Payment: ' . $model->employer_penalty_payment_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalty Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employer_penalty_payment_id, 'url' => ['view', 'id' => $model->employer_penalty_payment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-penalty-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
