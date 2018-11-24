<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPayment */

$this->title = 'Update Treasury Payment: ' . $model->treasury_payment_id;
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->treasury_payment_id, 'url' => ['view', 'id' => $model->treasury_payment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="treasury-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
