<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistDetails */

$this->title = 'Update Refund Paylist Details: ' . $model->refund_paylist_details_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylist Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_paylist_details_id, 'url' => ['view', 'id' => $model->refund_paylist_details_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-paylist-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
