<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistOperation */

$this->title = 'Update Refund Paylist Operation: ' . $model->refund_application_operation_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylist Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_application_operation_id, 'url' => ['view', 'id' => $model->refund_application_operation_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-paylist-operation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
